<?php

namespace BuckhamDuffy\CodingStandards\Rector\Support;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;

class ArrayHelper
{
	public function __construct()
	{
	}

	public function arrayDimTreeHasNode(ArrayDimFetch $node, callable $callable): bool
	{
		$currentNode = $node;

		while ($currentNode instanceof ArrayDimFetch) {
			$currentNode = $currentNode->var;
		}

		return $callable($currentNode);
	}

	/**
	 * Flatten the array tree into dot form foo.bar.baz
	 * instead of ['foo']['bar']['baz']
	 */
	public function flattenArrayDim(ArrayDimFetch $node): ArrayDimFetch
	{
		$keys = [];
		$currentNode = $node;

		while ($currentNode->var instanceof ArrayDimFetch) {
			$keys[] = $currentNode->dim->value;
			$currentNode = $currentNode->var;
		}

		$keys[] = $currentNode->dim->value;

		return new ArrayDimFetch(
			$currentNode->var,
			new Node\Scalar\String_(
				$this->createArrayKey(...array_values(array_reverse(array_filter($keys))))
			),
			$currentNode->getAttributes()
		);
	}

	public function wrap(mixed $value): array
	{
		if (\is_null($value)) {
			return [];
		}

		return \is_array($value) ? $value : [$value];
	}

	public function createArrayKey(string ...$pieces): string
	{
		return implode('.', $pieces);
	}
}
