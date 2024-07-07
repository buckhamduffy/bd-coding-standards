<?php

namespace BuckhamDuffy\CodingStandards\CaptainHook;

use CaptainHook\App\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use CaptainHook\App\Console\IO;
use CaptainHook\App\Hook\Action;
use CaptainHook\App\Console\IOUtil;
use CaptainHook\App\Hook\Constrained;
use CaptainHook\App\Hook\Restriction;
use SebastianFeldmann\Git\Repository;
use Symfony\Component\Process\Process;
use CaptainHook\App\Exception\ActionFailed;
use Symfony\Component\Process\ExecutableFinder;

class PhpstanAction implements Action, Constrained
{
	/** Actual action name */
	protected string $actionName = 'PHPStan';

	public function execute(Config $config, IO $io, Repository $repository, Config\Action $action): void
	{
		$fileList = $repository->getIndexOperator()->getStagedFilesOfType('php');
		$checkFiles = [];

		$io->write('Running PHPStan');

		foreach ($fileList as $file) {
			if (!Str::startsWith($file, ['src', 'app'])) {
				continue;
			}

			$checkFiles[] = $file;
		}

		if (!\count($checkFiles)) {
			$io->write('no files had to be checked', true, IO::VERBOSE);

			return;
		}

		$bin = $this->findPhpstan();

		if (!$bin) {
			throw new ActionFailed('Unable to find the phpstan executable');
		}

		$process = new Process(array_merge([
			'php',
			$bin,
			'analyse',
			'--no-progress',
			'--no-interaction',
			'--no-ansi',
			'--memory-limit=1G',
			'--error-format=json',
			'--',
		], $checkFiles));

		$process->run();

		if (!$process->getOutput()) {
			$io->writeError($process->getErrorOutput());

			throw new ActionFailed('PHPStan failed to run');
		}

		$output = json_decode(trim($process->getOutput()), true, 512, \JSON_THROW_ON_ERROR);

		$errors = Arr::get($output, 'totals.errors', 0) + Arr::get($output, 'totals.file_errors', 0);

		if ($errors === 0) {
			foreach ($checkFiles as $file) {
				$io->write(sprintf('  %s %s', IOUtil::PREFIX_OK, $file), true, IO::VERBOSE);
			}

			$io->write('PHPStan passed', true, IO::VERBOSE);

			return;
		}

		foreach ($checkFiles as $file) {
			foreach ($output['files'] as $fileKey => $data) {
				if (Str::contains($fileKey, $file)) {
					foreach ($data['messages'] as $message) {
						$io->write(sprintf(
							'  %s %s:%s - %s',
							IOUtil::PREFIX_FAIL,
							$file,
							$message['line'],
							$message['message']
						));
					}

					continue 2;
				}
			}

			$io->write(sprintf('  %s %s', IOUtil::PREFIX_OK, $file), true, IO::VERBOSE);
		}

		throw new ActionFailed(sprintf('Error: found %d PHPStan %s', $errors, Str::plural('error', $errors)));
	}

	public static function getRestriction(): Restriction
	{
		return new Restriction('pre-commit');
	}

	private function findPhpstan(): ?string
	{
		$ef = new ExecutableFinder();

		$executables = ['phpstan', 'phpstan.phar'];

		foreach ($executables as $executable) {
			$bin = $ef->find($executable, null, ['./vendor/bin', getenv('HOME') . '/.composer/vendor/bin']);
			if ($bin) {
				return $bin;
			}
		}

		return null;
	}
}
