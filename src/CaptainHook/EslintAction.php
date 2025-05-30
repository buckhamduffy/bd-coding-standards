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

class EslintAction implements Action, Constrained
{
	public function execute(Config $config, IO $io, Repository $repository, Config\Action $action): void
	{
		$fileList = $repository->getIndexOperator()->getStagedFilesOfTypes(['vue', 'js', 'ts']);

		$checkFiles = [];

		$io->write('Running ESLint');

		foreach ($fileList as $file) {
			if (!Str::startsWith($file, ['resources'])) {
				continue;
			}

			$checkFiles[] = $file;
		}

		if (!\count($checkFiles)) {
			$io->write('no files had to be checked', true, IO::VERBOSE);

			return;
		}

		$process = new Process(array_merge([
			'./node_modules/.bin/eslint',
			'--fix',
			'--quiet',
			'--format=json',
			'--',
		], $checkFiles));

		$process->run();

		if (!$process->getOutput()) {
			$io->writeError($process->getErrorOutput());

			throw new ActionFailed('ESLint failed to run');
		}

		$repository->getIndexOperator()->addFilesToIndex($checkFiles);

		$output = json_decode(str_replace("\n", '', trim($process->getOutput())), true, 512, \JSON_THROW_ON_ERROR);

		$checkedFiles = collect($output);

		$errors = $checkedFiles->sum(fn ($item) => $this->sum($item));

		if ($errors === 0) {
			foreach ($checkFiles as $file) {
				$data = $checkedFiles->filter(function(array $checkFile) use ($file) {
					return Str::endsWith($checkFile['filePath'], $file);
				})->first();

				$this->outputResults($io, $file, $data);
			}

			$io->write('ESLint passed', true, IO::VERBOSE);

			return;
		}

		foreach ($checkFiles as $file) {
			$data = $checkedFiles->filter(function(array $checkFile) use ($file) {
				return Str::endsWith($checkFile['filePath'], $file);
			})->first();

			$this->outputResults($io, $file, $data);
		}

		throw new ActionFailed('ESLint failed to run');
	}

	public static function getRestriction(): Restriction
	{
		return new Restriction('pre-commit');
	}

	private function outputResults(IO $io, string $file, ?array $data): void
	{
		if (!$data) {
			$io->write(\sprintf('  %s %s', IOUtil::PREFIX_OK, $file));

			return;
		}

		$errors = $this->sum($data);

		if ($errors) {
			$this->outputErrors($io, $file, $data);
		}
	}

	private function sum(array $item, bool $fixable = false): int
	{
		if ($fixable) {
			return $item['fixableErrorCount'] + $item['fixableWarningCount'];
		}

		return $item['errorCount'] + $item['fatalErrorCount'] + $item['warningCount'];
	}

	private function outputErrors(IO $io, string $file, array $data): void
	{
		foreach ($data['messages'] as $message) {
			$io->write(\sprintf(
				'  %s %s:%d - %s',
				IOUtil::PREFIX_FAIL,
				$file,
				$message['line'],
				$message['message'],
			));
		}
	}
}
