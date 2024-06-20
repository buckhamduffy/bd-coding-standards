<?php

namespace BuckhamDuffy\CodingStandards\Rector\Support;

use PhpParser\Node;
use Rector\NodeNameResolver\NodeNameResolver;

class RectorHelper
{
	public function __construct(private ArrayHelper $arrayHelper, private NodeNameResolver $nodeNameResolver)
	{
	}

	public function isCallable(Node $node): bool
	{
		return \in_array($node::class, [Node\Expr\MethodCall::class, Node\Expr\FuncCall::class]);
	}

	public function isMethodCall(Node $node, string|array $methods): bool
	{
		if (!$this->isCallable($node)) {
			return false;
		}

		return \in_array($node->name->toString(), $this->arrayHelper->wrap($methods));
	}

	public function getCastType(Node $node): ?string
	{
		if ($node instanceof Node\Expr\Cast\Int_) {
			return 'int';
		}

		if ($node instanceof Node\Expr\Cast\Double) {
			return 'float';
		}

		if ($node instanceof Node\Expr\Cast\Bool_) {
			return 'bool';
		}

		return null;
	}

	public function isClassName(Node $node, string|array $classes): bool
	{
		if (property_exists($node, 'class')) {
			return \in_array($node->class->toString(), $this->arrayHelper->wrap($classes));
		}

		return false;
	}

	/**
	 * @template V
	 * @param  V                         $var
	 * @param  callable(V): V|mixed|void $callable
	 * @return mixed|V
	 */
	public function tap(mixed $var, callable $callable): mixed
	{
		$result = $callable($var);

		if ($result) {
			return $result;
		}

		return $var;
	}

	public function getAttributes(Node $node, array $extra = []): array
	{
		return array_filter(
			array_merge([
				'scope'         => $node->getAttribute('scope'),
				'startLine'     => $node->getAttribute('startLine'),
				'startTokenPos' => $node->getAttribute('startTokenPos'),
				'startFilePos'  => $node->getAttribute('startFilePos'),
				'endLine'       => $node->getAttribute('endLine'),
				'endTokenPos'   => $node->getAttribute('endTokenPos'),
				'endFilePos'    => $node->getAttribute('endFilePos'),
			], $extra)
		);
	}

	public function getLastStmt(Node $node): ?Node
	{
		if (!property_exists($node, 'stmts')) {
			return null;
		}

		if (!\count($node->stmts)) {
			return null;
		}

		return $node->stmts[\count($node->stmts) - 1];
	}

	public function hasPhpAttribute(Node $node, string $name): bool
	{
		if (!property_exists($node, 'attrGroups')) {
			return false;
		}

		foreach ($node->attrGroups as $attrGroup) {
			foreach ($attrGroup as $attrs) {
				foreach ($attrs as $attr) {
					if ($this->nodeNameResolver->isName($attr, $name)) {
						return true;
					}
				}
			}
		}

		return false;
	}
}
