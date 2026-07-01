<?php

namespace Tests\Unit\Sniffs;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Util\Tokens;
use PHPUnit\Framework\TestCase;
use PHP_CodeSniffer\Files\LocalFile;

class ForbiddenDebugMethodsSniffTest extends TestCase
{
	private const EXPECTED_SOURCE = 'CodingStandards.Debug.ForbiddenDebugMethods.Found';

	public static function setUpBeforeClass(): void
	{
		if (!\defined('PHP_CODESNIFFER_VERBOSITY')) {
			\define('PHP_CODESNIFFER_VERBOSITY', 0);
		}

		if (!\defined('PHP_CODESNIFFER_CBF')) {
			\define('PHP_CODESNIFFER_CBF', false);
		}

		// php_codesniffer ships no composer autoload, so its own autoloader is required.
		require_once __DIR__ . '/../../../vendor/squizlabs/php_codesniffer/autoload.php';

		// The T_* token constants are defined when the Tokens class file is loaded.
		class_exists(Tokens::class);
	}

	public function testFlagsOnlyChainedDebugMethodCalls(): void
	{
		$fixture = __DIR__ . '/../../Fixture/ForbiddenDebugMethodsSniff.php.inc';
		$file = $this->lintFixture($fixture);

		$this->assertSame(
			$this->expectedErrorLines($fixture),
			$this->actualErrorLines($file),
			'Reported error lines do not match the "// forbidden" markers in the fixture'
		);

		foreach ($file->getErrors() as $columns) {
			foreach ($columns as $errors) {
				foreach ($errors as $error) {
					$this->assertSame(self::EXPECTED_SOURCE, $error['source']);
				}
			}
		}
	}

	private function lintFixture(string $fixture): LocalFile
	{
		$config = new Config([
			'-q',
			'--standard=' . __DIR__ . '/../../config/ForbiddenDebugMethodsSniff.xml',
		]);

		$file = new LocalFile($fixture, new Ruleset($config), $config);
		$file->process();

		return $file;
	}

	/**
	 * @return int[]
	 */
	private function expectedErrorLines(string $fixture): array
	{
		$lines = [];

		foreach (file($fixture) as $index => $line) {
			if (str_contains($line, '// forbidden')) {
				$lines[] = $index + 1;
			}
		}

		return $lines;
	}

	/**
	 * @return int[]
	 */
	private function actualErrorLines(LocalFile $file): array
	{
		$lines = array_keys($file->getErrors());
		sort($lines);

		return $lines;
	}
}
