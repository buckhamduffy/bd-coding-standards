<?php

namespace BuckhamDuffy\CodingStandards\Rector\Support;

use PhpParser\Node;
use PhpParser\Node\UnionType;
use PhpParser\Node\Identifier;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Expr\ClassConstFetch;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\PHPStanStaticTypeMapper\Enum\TypeKind;
use Rector\StaticTypeMapper\ValueObject\Type\NonExistingObjectType;

class PropertyHelper
{
	public function __construct(
		private StaticTypeMapper $staticTypeMapper,
		private NodeTypeResolver $nodeTypeResolver,
		private NodeNameResolver $nodeNameResolver,
	)
	{
	}

	public function getPropertyType(Property $property, string $kind = TypeKind::PARAM, bool $omitOptional = false): Node
	{
		$type = $property->type;

		if (!$type) {
			return new Identifier('mixed');
		}

		if (!$type instanceof Node) {
			$type = $this->nodeTypeResolver->getType($property->type);

			if (\is_null($type)) {
				return new Identifier('mixed');
			}
		}

		if (!$type instanceof Node) {
			$type = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($type, $kind);
		}

		if (!$type instanceof Node) {
			return new Identifier('mixed');
		}

		if ($type instanceof NonExistingObjectType) {
			$type = new FullyQualified($type->getClassName());
		}

		$type = clone $type;

		if ($type instanceof FullyQualified) {
			if ($this->nodeNameResolver->isName($type, 'Spatie\\LaravelData\\Optional')) {
				return new Identifier('mixed');
			}

			return clone $type;
		}

		if (!$omitOptional) {
			return $type;
		}

		return $this->removeTypesFromUnion($type, ['Spatie\\LaravelData\\Optional']);
	}

	public function removeTypesFromUnion(Node $type, array $removable): Node
	{
		if (!$type instanceof UnionType) {
			return $type;
		}

		foreach ($removable as $remove) {
			foreach ($type->types as $key => $unionType) {
				if ($this->nodeNameResolver->isName($unionType, $remove)) {
					unset($type->types[$key]);
				}
			}
		}

		$type->types = array_values($type->types);

		if (\count($type->types) === 2) {
			if ($index = $this->getNullIndexFromUnion($type)) {
				if (\is_null($index)) {
					return $type;
				}
			}

			return new NullableType($type->types[$index ? 0 : 1]);
		}

		if (\count($type->types) === 1) {
			return $type->types[0];
		}

		return $type;
	}

	public function typeHasTypes(Node $node, array $checkTypes): bool
	{
		if (!$node instanceof UnionType) {
			foreach ($checkTypes as $checkType) {
				if ($this->nodeNameResolver->isName($node, $checkType)) {
					return true;
				}
			}

			return false;
		}

		foreach ($node->types as $unionType) {
			foreach ($checkTypes as $checkType) {
				if ($this->nodeNameResolver->isName($unionType, $checkType)) {
					return true;
				}
			}
		}

		return false;
	}

	public function getNullIndexFromUnion(UnionType $unionType): ?int
	{
		foreach ($unionType->types as $index => $type) {
			if ($this->nodeNameResolver->isName($type, 'null')) {
				return $index;
			}
		}

		return null;
	}

	public function isType(Node $node, string $type = 'bool'): bool
	{
		if ($node instanceof Property) {
			$node = $this->getPropertyType($node, TypeKind::RETURN);
		}

		$node = $this->removeTypesFromUnion(clone $node, ['Spatie\\LaravelData\\Optional']);

		if ($node instanceof NullableType) {
			return $this->nodeNameResolver->isName($node->type, $type);
		}

		return $this->nodeNameResolver->isName($node, $type);
	}

	public function isDataCollection(Node $node): bool
	{
		if ($node instanceof Property) {
			$node = $this->getPropertyType($node, TypeKind::RETURN);
		}

		return $this->nodeNameResolver->isName($node, 'Spatie\LaravelData\DataCollection');
	}

	public function getDataCollectionType(Property $property): ?ClassConstFetch
	{
		if (!$this->isDataCollection($property)) {
			return null;
		}

		if (!\count($property->attrGroups)) {
			return null;
		}

		foreach ($property->attrGroups as $attrGroup) {
			foreach ($attrGroup as $attrs) {
				foreach ($attrs as $attr) {
					if ($this->nodeNameResolver->isName($attr, 'Spatie\LaravelData\Attributes\DataCollectionOf')) {
						return $attr->args[0]->value;
					}
				}
			}
		}

		return null;
	}
}
