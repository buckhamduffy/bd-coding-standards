<?php

declare(strict_types=1);

namespace BuckhamDuffy\CodingStandards\Rector;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Comment\Doc;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\UnionType;
use Illuminate\Support\Carbon;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\Property;
use Rector\Rector\AbstractRector;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Name\FullyQualified;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;

final class UseLaravelCarbonRector extends AbstractRector
{
	public function getRuleDefinition(): RuleDefinition
	{
		return new RuleDefinition('// @todo fill the description', [
			new CodeSample(
				<<<'CODE_SAMPLE'
// @todo fill code before
CODE_SAMPLE
				,
				<<<'CODE_SAMPLE'
// @todo fill code after
CODE_SAMPLE
			),
		]);
	}

	/**
	 * @return array<class-string<Node>>
	 */
	public function getNodeTypes(): array
	{
		return [Class_::class, Use_::class];
	}

	/**
	 * @param Class_ $node
	 */
	public function refactor(Node $node): ?Node
	{
		if ($node instanceof Use_) {
			return $this->refactorUseImport($node);
		}

		return $this->refactorClass($node);
	}

	private function refactorUseImport(Use_ $use): ?Use_
	{
		$found = false;
		$uses = [];

		foreach ($use->uses as $singleUse) {
			if ($singleUse->name->toString() === \Carbon\Carbon::class) {
				$found = true;

				$singleUse = new UseUse(
					new Name(['Illuminate', 'Support', 'Carbon']),
					$singleUse->alias,
					$singleUse->type,
					$singleUse->getAttributes(),
				);
			}

			$uses[] = $singleUse;
		}

		$use->uses = $uses;

		return $found ? $use : null;
	}

	private function refactorClass(Class_ $node): ?Class_
	{
		$found = false;

		foreach ($node->stmts as $stmtIndex => $stmt) {
			if ($stmt instanceof Property) {
				if ($stmt->type && ($type = $this->refactorPropertyType($stmt->type))) {
					$stmt->type = $type;
					$node->stmts[$stmtIndex] = $stmt;
					$found = true;
				}

				continue;
			}

			if ($stmt instanceof ClassMethod) {
				if ($stmt->returnType && ($type = $this->refactorPropertyType($stmt->returnType))) {
					$stmt->returnType = $type;
					$node->stmts[$stmtIndex] = $stmt;
					$found = true;
				}

				foreach ($stmt->getParams() as $paramIndex => $param) {
					if (!$param->type) {
						continue;
					}
					if (!($type = $this->refactorPropertyType($param->type))) {
						continue;
					}
					$param->type = $type;
					$stmt->params[$paramIndex] = $param;
					$node->stmts[$stmtIndex] = $stmt;
					$found = true;
				}

				if (($doc = $stmt->getDocComment()) && str_contains($doc->getText(), \Carbon\Carbon::class)) {
					$found = true;
					$stmt->setDocComment(new Doc(
						str_replace(\Carbon\Carbon::class, Carbon::class, $doc->getText()),
						$doc->getStartLine(),
						$doc->getStartFilePos(),
						$doc->getStartTokenPos(),
						$doc->getEndLine(),
						$doc->getEndFilePos(),
						$doc->getEndTokenPos(),
					));
					$node->stmts[$stmtIndex] = $stmt;
				}
			}
		}

		return $found ? $node : null;
	}

	public function refactorPropertyType(Node $type): ?Node
	{
		if ($type instanceof NullableType) {
			if ($type->type->toString() === \Carbon\Carbon::class) {
				return new NullableType(
					new Name($this->carbonFqdn()),
					$type->getAttributes()
				);
			}

			return null;
		}

		if ($type instanceof FullyQualified) {
			if ($type->toString() === \Carbon\Carbon::class) {
				return new FullyQualified(
					new Name($this->carbonFqdn()),
					$type->getAttributes()
				);
			}

			return null;
		}

		if ($type instanceof UnionType) {
			foreach ($type->types as $index => $_type) {
				if (($_type = $this->refactorPropertyType($_type)) !== null) {
					$type->types[$index] = $_type;

					return $type;
				}
			}

			return null;
		}

		return null;
	}

	private function carbonFqdn(): array
	{
		return explode('\\', Carbon::class);
	}
}