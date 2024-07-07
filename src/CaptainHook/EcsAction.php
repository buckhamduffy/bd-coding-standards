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

class EcsAction implements Action, Constrained
{
	protected string $actionName = 'ECS';

	public function execute(Config $config, IO $io, Repository $repository, Config\Action $action): void
	{
		$fileList = $repository->getIndexOperator()->getStagedFilesOfType('php');
		$checkFiles = [];

		$io->write('Running ECS');

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

		$bin = $this->findEcs();

		if (!$bin) {
			throw new ActionFailed('Unable to find the ecs executable');
		}

		$process = new Process(array_merge([
			'php',
			$bin,
			'check',
			'--clear-cache',
			'--no-progress-bar',
			'--no-diffs',
			'--quiet',
			'--output-format=json',
			'--fix',
			'--',
		], $checkFiles));

		$process->run();

		if (!$process->getOutput()) {
			$io->writeError($process->getErrorOutput());

			throw new ActionFailed('ECS failed to run');
		}

		$output = json_decode(str_replace("\n", '', trim($process->getOutput())), true, 512, \JSON_THROW_ON_ERROR);

		$errors = Arr::get($output, 'totals.errors', 0);

		$repository->getIndexOperator()->addFilesToIndex($checkFiles);

		if ($errors === 0) {
			foreach ($checkFiles as $file) {
				if (Arr::has($output, 'files.' . $file)) {
					$this->outputFileResult($io, $file, Arr::get($output, 'files.' . $file));
				} else {
					$io->write(sprintf('  %s %s', IOUtil::PREFIX_OK, $file), true, IO::VERBOSE);
				}
			}

			$io->write('ECS passed', true, IO::VERBOSE);

			return;
		}

		foreach ($checkFiles as $file) {
			if (!\array_key_exists($file, $output['files'])) {
				$io->write(sprintf('  %s %s', IOUtil::PREFIX_OK, $file), true, IO::VERBOSE);

				continue;
			}

			$this->outputFileResult($io, $file, $output['files'][$file]);
		}

		throw new ActionFailed(sprintf('<error>Error: found %d ECS %s</error>', $errors, Str::plural('error', $errors)));
	}

	public static function getRestriction(): Restriction
	{
		return new Restriction('pre-commit');
	}

	private function outputDiffs(IO $io, string $file, array $diffs): void
	{
		foreach ($diffs as $diff) {
			foreach (Arr::get($diff, 'applied_checkers', []) as $checker) {
				$checker = class_basename($checker);
				$checker = preg_replace('/([a-z])([A-Z])/', '$1 $2', $checker);
				$io->write(sprintf('  %s %s - %s', IOUtil::PREFIX_OK, $file, $checker));
			}
		}
	}

	private function outputFileResult(IO $io, string $file, array $data): void
	{
		if (Arr::get($data, 'diffs')) {
			$this->outputDiffs($io, $file, $data['diffs']);
		}

		if (Arr::get($data, 'errors')) {
			$this->outputErrors($io, $file, $data['errors']);
		}
	}

	private function outputErrors(IO $io, string $file, array $errors): void
	{
		foreach ($errors as $error) {
			$io->write(sprintf(
				'  %s %s:%d - %s',
				IOUtil::PREFIX_FAIL,
				$file,
				$error['line'],
				$error['message'],
			));
		}
	}

	private function findEcs(): ?string
	{
		$ef = new ExecutableFinder();

		return $ef->find('ecs', null, ['./vendor/bin', '~/.composer/vendor/bin']);
	}
}
