<?php

declare(strict_types=1);

namespace BuckhamDuffy\CodingStandards\Sniffs\Debug;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Forbids the use of debug methods (ds, dd, dump, ray) when called on an object/builder.
 */
class ForbiddenDebugMethodsSniff implements Sniff
{
	/**
	 * Method names that are forbidden when called on an object/builder.
	 *
	 * @var string[]
	 */
	public array $forbiddenMethods = ['ds', 'dd', 'dump', 'ray'];

	/**
	 * @return array<int, int|string>
	 */
	public function register(): array
	{
		return [\T_STRING];
	}

	/**
	 * @param int $stackPtr
	 */
	public function process(File $phpcsFile, $stackPtr): void
	{
		$tokens = $phpcsFile->getTokens();
		$methodName = $tokens[$stackPtr]['content'];

		$forbidden = array_map('strtolower', $this->forbiddenMethods);
		if (!\in_array(strtolower($methodName), $forbidden, true)) {
			return;
		}

		$prevPtr = $phpcsFile->findPrevious(\T_WHITESPACE, $stackPtr - 1, null, true);
		if ($prevPtr === false) {
			return;
		}

		$prevCode = $tokens[$prevPtr]['code'];
		if ($prevCode !== \T_OBJECT_OPERATOR && $prevCode !== \T_NULLSAFE_OBJECT_OPERATOR) {
			return;
		}

		$nextPtr = $phpcsFile->findNext(\T_WHITESPACE, $stackPtr + 1, null, true);
		if ($nextPtr === false || $tokens[$nextPtr]['content'] !== '(') {
			return;
		}

		$phpcsFile->addError(
			\sprintf('Chained debug method "->%s()" is forbidden and must be removed.', $methodName),
			$stackPtr,
			'Found'
		);
	}
}
