<?php

namespace BuckhamDuffy\CodingStandards\Rector\Support;

use PhpParser\Modifiers;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\UnionType;
use PhpParser\Node\Identifier;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\ClassConstFetch;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\Comments\NodeDocBlock\DocBlockUpdater;
use Rector\PHPStanStaticTypeMapper\Enum\TypeKind;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ReturnTagValueNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;

class GetterSetterHelper
{
	public function __construct(
		private NodeNameResolver $nodeNameResolver,
		private StaticTypeMapper $staticTypeMapper,
		private NodeTypeResolver $nodeTypeResolver,
		private RectorHelper $rectorHelper,
		private PropertyHelper $propertyHelper,
		private PhpDocInfoFactory $phpDocInfoFactory,
		private DocBlockUpdater $docBlockUpdater,
		private ArgHelper $argHelper,
	)
	{
	}

	public function findGetter(Class_ $class, Property $property): ?ClassMethod
	{
		$prefixes = ['get', 'is', ''];
		$propertyName = $this->preparePropertyName($property);

		foreach ($prefixes as $prefix) {
			if ($method = $class->getMethod($prefix . $propertyName)) {
				return $method;
			}
		}

		return null;
	}

	public function prepareGetterName(Property $property): string
	{
		$propertyName = $this->preparePropertyName($property);

		if ($this->propertyHelper->isType($property, 'bool')) {
			if (str_starts_with(lcfirst($propertyName), 'is')) {
				return lcfirst($propertyName);
			}

			return 'is' . $propertyName;
		}

		return 'get' . $propertyName;
	}

	public function findSetter(Class_ $class, Property $property): ?ClassMethod
	{
		$prefixes = ['set', 'with'];
		$name = $this->preparePropertyName($property);

		foreach ($prefixes as $prefix) {
			if ($method = $class->getMethod($prefix . $name)) {
				return $method;
			}
		}

		return null;
	}

	public function createGetter(Property $property, array $attr = []): ClassMethod
	{
		$getter = new ClassMethod(
			$this->prepareGetterName($property),
			[
				'stmts' => [
					$this->createGetterExpression($property),
				],
				'returnType' => $this->propertyHelper->removeTypesFromUnion(
					$this->propertyHelper->getPropertyType(
						$property,
						TypeKind::RETURN
					),
					['Spatie\\LaravelData\\Optional'],
					true,
				),
				'flags' => Modifiers::PUBLIC
			],
			$attr,
		);

		return $this->augmentGetterWithDocBlocks($getter, $property);
	}

	public function createSetter(Property $property, string $prefix = 'set', array $attr = []): ClassMethod
	{
		$setter = new ClassMethod(
			$prefix . $this->preparePropertyName($property),
			[
				'params' => [],
				'stmts'  => [
					$this->createSetterExpression($property),
					new Return_(
						new Variable('this')
					)
				],
				'returnType' => new Name('self'),
				'flags'      => $property->flags,
			],
			$attr,
		);

		$setter = $this->updateSetter($setter, $property);

		return $this->augmentSetterWithDocBlocks($setter, $property);
	}

	public function createSetterExpression(Property $property)
	{
		$type = clone $this->propertyHelper->getPropertyType($property, TypeKind::PARAM, true);

		if ($this->propertyHelper->isDataCollection($type)) {
			if ($dataCollectionType = $this->propertyHelper->getDataCollectionType($property)) {
				return new Expression(
					new Assign(
						new PropertyFetch(
							new Variable('this'),
							$this->nodeNameResolver->getName($property)
						),
						new StaticCall(
							clone $dataCollectionType->class,
							'collect',
							[
								$this->argHelper->createArg(new Variable($this->nodeNameResolver->getName($property))),
								$this->argHelper->createArg(
									new ClassConstFetch(
										new Name('DataCollection'),
										'class'
									)
								),
							]
						)
					)
				);
			}
		}

		return new Expression(
			new Assign(
				new PropertyFetch(
					new Variable('this'),
					$this->nodeNameResolver->getName($property)
				),
				new Variable($this->nodeNameResolver->getName($property))
			)
		);

	}

	public function createSetterParam(Property $property, array $attr = [])
	{
		$type = clone $this->propertyHelper->getPropertyType($property, TypeKind::PARAM, true);

		if ($type instanceof NullableType) {
			$type = $type->type;
		}

		if ($this->propertyHelper->isDataCollection($type)) {
			$type = new UnionType([
				new Identifier('DataCollection'),
				new Identifier('array')
			]);
		}

		return new Param(
			new Variable($this->nodeNameResolver->getName($property)),
			null,
			$type,
		);
	}

	public function preparePropertyName(Property $property): string
	{
		$name = $this->nodeNameResolver->getName($property);

		return ucwords(
			implode(
				'',
				array_map(
					fn (string $item) => ucwords($item),
					explode('_', $name)
				)
			)
		);
	}

	public function updateSetter(ClassMethod $method, Property $property): ClassMethod
	{
		$method->flags = $property->flags;

		if (\count($method->params) === 0) {
			$method->params = [
				$this->createSetterParam($property),
			];

			return $this->augmentSetterWithDocBlocks($method, $property);
		}

		if (\count($method->params) > 1) {
			return $method;
		}

		if ($method->params[0]->type) {
			return $this->augmentSetterWithDocBlocks($method, $property);
		}

		$method->params = [
			$this->createSetterParam($property),
		];

		return $this->augmentSetterWithDocBlocks($method, $property);
	}

	public function updateGetter(ClassMethod $method, Property $property): ClassMethod
	{
		if (!$method->returnType) {
			$method->returnType = $this->propertyHelper->removeTypesFromUnion(
				$this->propertyHelper->getPropertyType(
					$property,
					TypeKind::RETURN
				),
				['Spatie\\LaravelData\\Optional'],
			);
		}

		return $this->augmentSetterWithDocBlocks($method, $property);
	}

	public function augmentGetterWithDocBlocks(ClassMethod $method, Property $property): ClassMethod
	{
		if ($method->getDocComment()) {
			return $method;
		}

		if ($property->getDocComment()) {
			$phpDocInfo = $this->phpDocInfoFactory->createFromNode($property);
			if ($varType = $phpDocInfo?->getVarTagValueNode()) {
				$methodPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($method);
				$methodPhpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
					'@return',
					new ReturnTagValueNode(
						$varType->type,
						'',
					)
				));

				$this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($method);
			}

			return $method;
		}

		if ($this->propertyHelper->isDataCollection($property)) {
			if ($tag = $this->createDataCollectionDocType($property)) {
				$methodPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($method);
				$methodPhpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
					'@return',
					new ReturnTagValueNode(
						$tag,
						''
					)
				));

				$this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($method);
			}
		}

		return $method;
	}

	public function augmentSetterWithDocBlocks(ClassMethod $method, Property $property): ClassMethod
	{
		if ($method->getDocComment()) {
			return $method;
		}

		if ($property->getDocComment()) {
			$phpDocInfo = $this->phpDocInfoFactory->createFromNode($property);
			if ($varType = $phpDocInfo?->getVarTagValueNode()) {
				$methodPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($method);
				$methodPhpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
					'@param',
					new ParamTagValueNode(
						$varType->type,
						false,
						'$'.$this->nodeNameResolver->getName($property),
						'',

					)
				));

				$this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($method);
			}

			return $method;
		}

		if ($this->propertyHelper->isDataCollection($property)) {
			if ($tag = $this->createDataCollectionDocType($property)) {
				$methodPhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($method);
				$methodPhpDocInfo->addPhpDocTagNode(new PhpDocTagNode(
					'@param',
					new ParamTagValueNode(
						$tag,
						false,
						'$' . $this->nodeNameResolver->getName($property),
						'',
					)
				));

				$this->docBlockUpdater->updateRefactoredNodeWithPhpDocInfo($method);
			}
		}

		return $method;
	}

	private function createGetterExpression(Property $property)
	{
		if ($property->type && $this->propertyHelper->typeHasTypes($property->type, ['Spatie\\LaravelData\\Optional'])) {
			$funcs = match (true) {
				$this->propertyHelper->isType($property->type, 'bool')   => ['is_bool', 'false'],
				$this->propertyHelper->isType($property->type, 'string') => ['is_string', 'null'],
				$this->propertyHelper->isType($property->type, 'int')    => ['is_numeric', 'null'],
				$this->propertyHelper->isType($property->type, 'float')  => ['is_numeric', 'null'],
				default                                                  => null,
			};

			if ($funcs) {
				return new Return_(
					new Ternary(
						new FuncCall(
							new Name($funcs[0]),
							[
								$this->argHelper->createArg(
									new PropertyFetch(
										new Variable('this'),
										$this->nodeNameResolver->getName($property)
									)
								)
							]
						),
						new PropertyFetch(
							new Variable('this'),
							$this->nodeNameResolver->getName($property)
						),
						new ConstFetch(new Name($funcs[1])),
					)
				);
			}
		}

		return new Return_(
			new PropertyFetch(
				new Variable('this'),
				$this->nodeNameResolver->getName($property)
			)
		);
	}

	public function createDataCollectionDocType(Property $property): ?GenericTypeNode
	{
		$type = $this->propertyHelper->getDataCollectionType($property);

		if (!$type) {
			return null;
		}

		return new GenericTypeNode(
			new IdentifierTypeNode('DataCollection'),
			[
				new IdentifierTypeNode('array-key'),
				new IdentifierTypeNode($type->class->getLast())
			],
		);
	}
}
