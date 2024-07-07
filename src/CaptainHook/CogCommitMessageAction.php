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

class CogCommitMessageAction implements Action, Constrained
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
			'verify',
			$repository->getCommitMsg()->getContent(),
		]);

		$process->run();

		if ($process->isSuccessful()) {
			$io->write('commit message was valid', true, IO::VERBOSE);

			return;
		}

		$io->writeError($process->getErrorOutput());

		throw new ActionFailed('Commit message failed validation');
	}

	public static function getRestriction(): Restriction
	{
		return new Restriction('commit-msg');
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
