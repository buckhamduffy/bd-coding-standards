<?php

namespace BuckhamDuffy\CodingStandards\CaptainHook;

use CaptainHook\App\Config;
use CaptainHook\App\Console\IO;
use CaptainHook\App\Hook\Action;
use CaptainHook\App\Hook\Constrained;
use CaptainHook\App\Hook\Restriction;
use SebastianFeldmann\Git\Repository;
use Symfony\Component\Process\Process;
use CaptainHook\App\Exception\ActionFailed;
use Symfony\Component\Process\ExecutableFinder;

class CogPrePushAction implements Action, Constrained
{
	public function execute(Config $config, IO $io, Repository $repository, Config\Action $action): void
	{
		$ef = new ExecutableFinder();
		$bin = $ef->find('cog');

		if (!$bin) {
			throw new ActionFailed('Unable to find the cocogitto executable');
		}

		$process = new Process([
			$bin,
			'check',
			'--from-latest-tag',
		]);

		$process->run();

		if ($process->isSuccessful()) {
			$io->write('push is valid', true, IO::VERBOSE);

			return;
		}

		if (preg_match('/Error: unable to get any tag/i', $process->getErrorOutput())) {
			$io->write('push is valid', true, IO::VERBOSE);

			return;
		}

		$io->writeError($process->getErrorOutput());

		throw new ActionFailed('pre-push failed validation');
	}

	public static function getRestriction(): Restriction
	{
		return new Restriction('pre-push');
	}

	public function findCog(): ?string
	{
		$executables = ['cog', 'cocogitto'];
		$ef = new ExecutableFinder();

		foreach ($executables as $executable) {
			if ($bin = $ef->find($executable)) {
				return $bin;
			}
		}

		return null;
	}
}
