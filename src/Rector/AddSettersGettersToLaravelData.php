<?php

namespace BuckhamDuffy\CodingStandards\Rector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use BuckhamDuffy\CodingStandards\Rector\Support\PropertyHelper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use BuckhamDuffy\CodingStandards\Rector\Support\GetterSetterHelper;

class AddSettersGettersToLaravelData extends AbstractRector
{
	public function __construct(
		private GetterSetterHelper $getterSetterHelper,
		private PropertyHelper $propertyHelper,
	)
	{
	}

	public function getRuleDefinition(): RuleDefinition
	{
		return new RuleDefinition('Replaces certain Laravel $request calls with proper methods', [
			new CodeSample(
				<<<'CODE_SAMPLE'
					class SomeClass extends Data {
						public string $name;
					}
				CODE_SAMPLE,
				<<<'CODE_SAMPLE'
					class SomeClass extends Data {
						public string $name;
						
						public function getName(): string
						{
							return $this->name;
						}
						
						public function setName(string $name): void
						{
							$this->name = $name;
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
		if (!$node->extends || !$this->isName($node->extends, 'Spatie\\LaravelData\\Data')) {
			return null;
		}

		foreach ($node->getProperties() as $property) {
			if (!$property->isPublic()) {
				continue;
			}

			$node = $this->refactorGetter($node, $property);
			$node = $this->refactorSetter($node, $property);
		}

		return $node;
	}

	private function refactorGetter(Class_ $class, Property $property): Class_
	{
		if ($method = $this->getterSetterHelper->findGetter($class, $property)) {
			$this->getterSetterHelper->updateGetter($method, $property);

			return $class;
		}

		$class->stmts[] = new Nop();
		$class->stmts[] = $this->getterSetterHelper->createGetter(
			$property
		);

		return $class;
	}

	private function refactorSetter(Class_ $class, Property $property): Class_
	{
		if ($method = $this->getterSetterHelper->findSetter($class, $property)) {
			$this->getterSetterHelper->updateSetter($method, $property);

			return $class;
		}

		$class->stmts[] = new Nop();
		$class->stmts[] = $this->getterSetterHelper->createSetter(
			$property,
			$this->propertyHelper->isType($property) ? 'with' : 'set'
		);

		return $class;
	}
}
