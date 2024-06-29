<?php

declare(strict_types = 1);

namespace BuckhamDuffy\CodingStandards\Rector;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\NodeVisitor;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\Class_;
use Rector\Rector\AbstractRector;
use PhpParser\Node\Name\FullyQualified;
use Rector\Naming\Naming\UseImportsResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Renaming\NodeManipulator\ClassRenamer;
use Rector\PostRector\Collector\UseNodesToAddCollector;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;

final class UseLaravelCarbonRector extends AbstractRector
{
	private string $oldCarbon = 'Carbon\\Carbon';
	private string $newCarbon = 'Illuminate\\Support\\Carbon';

	public function __construct(
		private readonly UseNodesToAddCollector $addCollector,
		private readonly UseImportsResolver $importsResolver,
		private readonly ClassRenamer $classRenamer
	)
	{
	}

	public function getRuleDefinition(): RuleDefinition
	{
		return new RuleDefinition('Replaces raw Carbon with Laravel Carbon', [
			new CodeSample(
				<<<'CODE_SAMPLE'
					use Carbon\Carbon;
					
					function(\Carbon\Carbon $date): \Carbon\Carbon {
						$date = \Carbon\Carbon::now();
						return $date->addDays(1);
					}
				CODE_SAMPLE
				,
				<<<'CODE_SAMPLE'
					use Illuminate\Support\Carbon;
					
					function(Carbon $date): Carbon {
						$date = Carbon::now();
						return $date->addDays(1);
					}
				CODE_SAMPLE
			),
		]);
	}

	/**
	 * @return array<class-string<Node>>
	 */
	public function getNodeTypes(): array
	{
		return [FullyQualified::class, Use_::class];
	}

	/**
	 * @param Class_ $node
	 */
	public function refactor(Node $node): null|int|Node
	{
		if ($node instanceof Use_) {
			return $this->refactorUseImport($node);
		}

		if ($node instanceof FullyQualified) {
			return $this->refactorFullyQualified($node);
		}

		return null;
	}

	/**
	 * Finds instances of a use that includes Carbon\Carbon and replaces it with Illuminate\Support\Carbon
	 */
	private function refactorUseImport(Use_ $node): null|int|Node
	{
		foreach ($node->uses as $index => $use) {
			if ($this->nodeNameResolver->isName($use, $this->oldCarbon)) {
				// Just in-case we already added the use
				foreach ($this->importsResolver->resolve() as $useGroup) {
					foreach ($useGroup->uses as $item) {
						if ($this->isName($item, $this->newCarbon)) {
							unset($node->uses[$index]);

							continue 3;
						}
					}
				}

				$use->name = new Name($this->newCarbon, $use->name->getAttributes());
			}
		}

		if (!\count($node->uses)) {
			return NodeVisitor::REMOVE_NODE;
		}

		$node->uses = array_values($node->uses);

		return null;
	}

	/**
	 * Renames any instance of Carbon\Carbon with Illuminate\Support\Carbon
	 */
	private function refactorFullyQualified(FullyQualified $node): ?Node
	{
		$scope = $node->getAttribute(AttributeKey::SCOPE);
		$result = $this->classRenamer->renameNode($node, [$this->oldCarbon => $this->newCarbon], $scope);

		if (!$result) {
			return null;
		}

		$this->addCollector->addUseImport(new FullyQualifiedObjectType($this->newCarbon));

		if ($result instanceof FullyQualified) {
			return new Name('Carbon', $result->getAttributes());
		}

		return $node;
	}
}
