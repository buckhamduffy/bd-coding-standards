<?php

namespace BuckhamDuffy\CodingStandards\Rector\Support;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;

class ArgHelper
{
	/**
	 * @param  callable(Arg $arg): Arg $callback
	 * @return Arg[]
	 */
	public function replaceArg(Node $node, int $index, callable $callback, bool $dropNames = false): array
	{
		if (!method_exists($node, 'getArgs')) {
			return [];
		}

		/** @var Arg[] $args */
		$args = $node->getArgs();

		if ($dropNames) {
			foreach ($args as $aIdx => $arg) {
				if ($aIdx !== $index) {
					continue;
				}

				$args[$aIdx] = new Arg(
					$arg->value,
					$arg->byRef,
					$arg->unpack,
					$arg->getAttributes(),
				);
			}
		}

		if (!\array_key_exists($index, $args)) {
			return $args;
		}

		$args[$index] = $callback($args[$index]);

		return $args;
	}

	public function replaceArgInNode(Node|Expr $node, int $index, callable $callback, bool $dropNames = false): Node|Expr
	{
		$node->args = $this->replaceArg($node, $index, $callback, $dropNames);

		return $node;
	}

	public function hasMinArgs(Node $node, int $count = 2): bool
	{
		if (!method_exists($node, 'getArgs')) {
			return false;
		}

		return \count($node->getArgs()) >= $count;
	}

	public function hasCountArgs(Node $node, int $count = 2): bool
	{
		if (!method_exists($node, 'getArgs')) {
			return false;
		}

		return \count($node->getArgs()) === $count;
	}

	public function createArgFromExisting(Node $node, int $index = 0, bool $keepExtra = true): ?Arg
	{
		if (!method_exists($node, 'getArgs')) {
			return null;
		}

		if (!\array_key_exists($index, $node->getArgs())) {
			return null;
		}

		/** @var Arg $arg */
		$arg = $node->getArgs()[$index];

		if ($value = $this->getArgVal($node, $index)) {
			return new Arg(
				$value,
				$keepExtra ? $arg->byRef : false,
				$keepExtra ? $arg->unpack : false,
				$keepExtra ? $arg->getAttributes() : [],
			);
		}

		return null;
	}

	public function getArgVal(Node $node, int $index = 0): mixed
	{
		if (!method_exists($node, 'getArgs')) {
			return false;
		}

		if (!\array_key_exists($index, $node->getArgs())) {
			return null;
		}

		return $node->getArgs()[$index]->value ?? null;
	}

	public function createNullIfExists(Node $node, int $count): ?Arg
	{
		if ($this->hasCountArgs($node, $count)) {
			return new Arg(new Expr\ConstFetch(new Node\Name('null')));
		}

		return null;
	}

	public function createArg(mixed $value = null, bool $keepNull = true): ?Arg
	{
		if (\is_null($value)) {
			if (!$keepNull) {
				return null;
			}

			return new Arg(new Expr\ConstFetch(new Node\Name('null')));
		}

		if (property_exists($value, 'value') && \is_string($value->value)) {
			$value = $value->value;
		} elseif (method_exists($value, 'getName') && \is_string($value->getName())) {
			$value = $value->getName();
		}

		if (\is_string($value)) {
			return new Arg(new Node\Scalar\String_($value));
		}

		return new Arg($value);
	}

	public function convertValueToString(mixed $value): ?string
	{
		if (\is_string($value)) {
			return $value;
		}

		if (property_exists($value, 'value')) {
			return $this->convertValueToString($value->value);
		}

		if (method_exists($value, 'getName') && \is_string($value->getName())) {
			return $value->getName();
		}

		return null;
	}

	public function appendStringToArg(Node $node, mixed $value, int $index = 0): array
	{
		return $this->replaceArg($node, $index, function(Arg $arg) use ($value) {
			return $this->createArg($this->convertValueToString($arg) . '.' . $this->convertValueToString($value));
		});
	}
}
