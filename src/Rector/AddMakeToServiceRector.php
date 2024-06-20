<?php

namespace BuckhamDuffy\CodingStandards\Rector;

use PhpParser\Node;
use PhpParser\Modifiers;
use PhpParser\Node\Stmt\Class_;
use Rector\Rector\AbstractRector;
use PhpParser\Node\Stmt\ClassMethod;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use BuckhamDuffy\CodingStandards\Rector\Attributes\Makeable;
use BuckhamDuffy\CodingStandards\Rector\Support\RectorHelper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;

class AddMakeToServiceRector extends AbstractRector
{
	public function __construct(private RectorHelper $rectorHelper)
	{
	}

	public function getRuleDefinition(): RuleDefinition
	{
		return new RuleDefinition('Replaces certain Laravel $request calls with proper methods', [
			new CodeSample(
				<<<'CODE_SAMPLE'
					#[Makeable]
					class SomeService {
						public function __construct(
							private string $foo,
							private string $bar,
						) {
						}
					}
				CODE_SAMPLE,
				<<<'CODE_SAMPLE'
					#[Makeable]
					class SomeService {
						public function __construct(
							private string $foo,
							private string $bar,
						) {
						}
						
						public static make(string $foo, string $bar): self
						{
							return new self($foo, $bar);
						}
					}
				CODE_SAMPLE
			),
		]);
	}

	public function getNodeTypes(): array
	{
		return [Class_::class];
	}

	/**
	 * @param Class_ $node
	 */
	public function refactor(Node $node): ?Node
	{
		if (!$this->rectorHelper->hasPhpAttribute($node, Makeable::class)) {
			return null;
		}

		if (!$node->getMethod('__construct')) {
			return null;
		}

		if ($method = $node->getMethod('make')) {
			$this->updateMake($method, $node);

			return $node;
		}

		$method = $this->createMakeMethod($node);
		array_splice($node->stmts, 1, 0, [new Node\Stmt\Nop(), $method]);

		return $node;
	}

	private function updateMake(ClassMethod $method, Class_ $class): ClassMethod
	{
		$method->flags = Modifiers::STATIC | Modifiers::PUBLIC;

		$params = [];
		foreach ($class->getMethod('__construct')->params as $param) {
			$params[] = new Node\Param(
				new Node\Expr\Variable($param->var->name),
				$param->default,
				$param->type,
			);
		}

		$method->params = $params;
		$method->returnType = new Node\Name('self');

		$method->stmts = [
			new Node\Stmt\Return_(
				new Node\Expr\New_(
					new Node\Name('self'),
					array_map(
						fn ($param) => new Node\Arg(new Node\Expr\Variable($param->var->name)),
						$params
					),
				),
			)
		];

		return $method;
	}

	private function createMakeMethod(Class_ $node): ClassMethod
	{
		$method = new ClassMethod(
			'make',
			[
				'flags'      => Modifiers::STATIC | Modifiers::PUBLIC,
				'returnType' => new Node\Name('self'),
				'params'     => [],
				'stmts'      => [],
			]
		);

		return $this->updateMake($method, $node);
	}
}
