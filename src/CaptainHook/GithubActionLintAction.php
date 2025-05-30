<?php

namespace BuckhamDuffy\CodingStandards\CaptainHook;

use CaptainHook\App\Config;
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

class GithubActionLintAction implements Action, Constrained
{
	/** Actual action name */
	protected string $actionName = 'Github Action Lint';

	public function execute(Config $config, IO $io, Repository $repository, Config\Action $action): void
	{
		$fileList = $repository->getIndexOperator()->getStagedFilesOfTypes(['yml', 'yaml']);
		$checkFiles = [];

		$io->write('Running Action Lint');

		foreach ($fileList as $file) {
			if (!Str::startsWith($file, ['.github/workflows'])) {
				continue;
			}

			$checkFiles[] = $file;
		}

		if (!\count($checkFiles)) {
			$io->write('no files had to be checked', true, IO::VERBOSE);

			return;
		}

		$bin = $this->findActionLint();

		if (!$bin) {
			throw new ActionFailed('Unable to find the ActionLint executable. Please install it with `brew install actionlint`');
		}

		$process = new Process(array_merge([
			$bin,
			'-format',
			'{{json .}}',
			'--',
		], $checkFiles));

		$process->run();

		if (!$process->getOutput()) {
			$io->writeError($process->getErrorOutput());

			throw new ActionFailed('ActionLint failed to run');
		}

		$output = json_decode(trim($process->getOutput()), true, 512, \JSON_THROW_ON_ERROR);
		$output = collect($output);

		if ($bin = $this->findPrettier()) {
			$process = new Process(array_merge([
				$bin,
				'--write',
				'--parser',
				'yaml',
				'--',
			], $checkFiles));

			$process->run();

			$repository->getIndexOperator()->addFilesToIndex($checkFiles);
		}

		if ($output->count() === 0) {
			foreach ($checkFiles as $file) {
				$io->write(\sprintf('  %s %s', IOUtil::PREFIX_OK, $file), true, IO::VERBOSE);
			}

			$io->write('Action Lint passed', true, IO::VERBOSE);

			return;
		}

		foreach ($checkFiles as $file) {
			$items = $output->where('filepath', $file);

			foreach ($items as $item) {
				$io->write(
					\sprintf(
						'  %s %s:%s - %s',
						IOUtil::PREFIX_FAIL,
						$file,
						$item['line'],
						$item['message'],
					),
				);
			}

			if (!$items->count()) {
				$io->write(\sprintf('  %s %s', IOUtil::PREFIX_OK, $file));
			}
		}

		throw new ActionFailed(\sprintf('Error: found %d Action Lint %s', \count($output), Str::plural('error', \count($output))));
	}

	public static function getRestriction(): Restriction
	{
		return new Restriction('pre-commit');
	}

	private function findActionLint(): ?string
	{
		$ef = new ExecutableFinder();

		return $ef->find('actionlint');
	}

	private function findPrettier(): ?string
	{
		$ef = new ExecutableFinder();

		return $ef->find('prettier', null, ['./node_modules/.bin']);
	}
}
