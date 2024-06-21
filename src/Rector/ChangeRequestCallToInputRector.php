<?php

namespace BuckhamDuffy\CodingStandards\Rector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\NodeTraverser;
use PHPStan\Type\ObjectType;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\FuncCall;
use Rector\Rector\AbstractRector;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\PropertyFetch;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use BuckhamDuffy\CodingStandards\Rector\Support\ArgHelper;
use BuckhamDuffy\CodingStandards\Rector\Support\ArrayHelper;
use BuckhamDuffy\CodingStandards\Rector\Support\RectorHelper;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;

final class ChangeRequestCallToInputRector extends AbstractRector
{
	public function __construct(
		private RectorHelper $helper,
		private ArgHelper $args,
		private ArrayHelper $array
	)
	{
	}

	public function getNodeTypes(): array
	{
		return [
			ArrayDimFetch::class,
			PropertyFetch::class,
			MethodCall::class,
			Cast::class,
			StaticCall::class
		];
	}

	public function getRuleDefinition(): RuleDefinition
	{
		return new RuleDefinition('Replaces certain Laravel $request calls with proper methods', [
			new CodeSample(
				<<<'CODE_SAMPLE'
					function(Request $request) {
						echo (int)$request->get('foo', 'bar');
						echo (int)$request->foo;
						echo (float)$request->get('foo');
						echo (bool)$request->get('foo');
						echo $request->foo;
						echo $request->foo['bar'];
						echo Carbon::parse($request->foo);
						echo request()->foo;
					}
				CODE_SAMPLE,
				<<<'CODE_SAMPLE'
					function(Request $request) {
						echo $request->integer('foo', 'bar');
						echo $request->integer('foo');
						echo $request->float('foo');
						echo $request->boolean('foo');
						echo $request->input('foo');
						echo $request->input('foo.bar');
						echo $request->date('foo');
						echo request()->input('foo');
					}
				CODE_SAMPLE
			),
		]);
	}

	/**
	 * @param PropertyFetch $node
	 */
	public function refactor(Node $node): Node|int|null
	{
		if ($node instanceof ArrayDimFetch) {
			return $this->refactorArrayDimFetch($node);
		}

		if ($node instanceof PropertyFetch) {
			return $this->refactorRequestVariable($node);
		}

		if ($node instanceof MethodCall) {
			return $this->refactorRequestVariable($node);
		}

		if ($node instanceof Cast) {
			return $this->refactorCast($node);
		}

		if ($node instanceof StaticCall) {
			return $this->refactorCarbonRequests($node);
		}

		return null;
	}

	public function refactorArrayDimFetch(ArrayDimFetch $node): mixed
	{
		// Check if request is in the array chain at all
		if (!$this->array->arrayDimTreeHasNode($node, [$this, 'isRequest'])) {
			return null;
		}

		$node = $this->array->flattenArrayDim($node);
		$key = $node->dim->value;
		$node = $node->var;

		if (!$this->isRequest($node)) {
			return $node;
		}

		if ($node instanceof Expr\Variable) {
			return new MethodCall(
				$node,
				'input',
				[
					$this->args->createArg($key)
				],
				$this->helper->getAttributes($node),
			);
		}

		$node = $this->refactorRequestVariable($node);

		$node->args = $this->args->appendStringToArg($node, $key);

		$node = $this->convertRequestToMethod(
			$node
		);

		if ($this->args->hasCountArgs($node, 2)) {
			$secondRequest = $this->refactorRequestVariable($this->args->getArgVal($node, 1));
			if ($this->isRequestMethodCall($secondRequest)) {
				$secondRequest->args = $this->args->appendStringToArg($secondRequest, $key);

				$node = $this->args->replaceArgInNode($node, 1, fn () => $this->args->createArg($secondRequest));
			}
		}

		return $node;
	}

	/**
	 * Check if the Node is a request() or $request
	 */
	public function isRequest(Node $node, bool $recursive = true): bool
	{
		if ($node instanceof FuncCall) {
			return $this->isName($node, 'request');
		}

		if ($recursive && property_exists($node, 'var')) {
			if ($this->isRequest($node->var, false)) {
				return true;
			}
		}

		return $this->isObjectType($node, new ObjectType('Illuminate\Http\Request'));
	}

	public function convertRequestToMethod(Node $node, string $method = 'input', ?array $args = null): Node|int|null
	{
		$args = \is_array($args) ? array_filter($args) : $args;

		if ($this->helper->isCallable($node)) {
			if (!$this->isRequestMethodCall($node, $method) || \is_array($args)) {
				// Checking again because we can't rename input/get to $method
				if (!$this->isRequestMethodCall($node)) {
					return $node;
				}

				return new MethodCall(
					$node->var,
					$method,
					$args ?: $node->args,
					$this->helper->getAttributes($node),
				);
			}

			return $node;
		}

		return new MethodCall(
			$node->var,
			$method,
			$args ?: [
				$this->args->createArg($this->getName($node))
			],
			$this->helper->getAttributes($node),
		);
	}

	public function isRequestMethodCall(Node $node, string|array $methods = ['get', 'input']): bool
	{
		if (!$this->helper->isMethodCall($node, $methods)) {
			return false;
		}

		return $this->isRequest($node);
	}

	private function refactorRequestVariable(Node $node): Node|int|null
	{
		if ($node instanceof Expr\Variable) {
			if ($this->isRequest($node)) {
				return $this->convertRequestToMethod($node);
			}

			return null;
		}

		if ($node instanceof PropertyFetch) {
			if ($this->isRequest($node->var)) {
				return $this->convertRequestToMethod($node);
			}
		}

		if ($this->helper->isCallable($node)) {
			if ($this->isRequest($node->var)) {
				return $this->convertRequestToMethod($node);
			}
		}

		return null;
	}

	private function refactorCarbonRequests(StaticCall $node): Node|int|null
	{
		if (!$this->helper->isClassName($node, ['Carbon\Carbon', 'Illuminate\Support\Carbon'])) {
			return NodeTraverser::DONT_TRAVERSE_CHILDREN;
		}

		if ($this->isNames($node->name, ['parse', 'createFromFormat'])) {
			$parseIndex = $this->isName($node->name, 'parse') ? 0 : 1;

			$request = $this->args->getArgVal($node, $parseIndex);

			if (!$request) {
				return null;
			}

			// First arg isn't a request variable
			if (!$this->isRequest($request)) {
				return $node;
			}

			$request = $this->refactorRequestVariable($request);
			$requestNode = $this->convertCarbonToRequest($node, $request);

			if (!$requestNode) {
				return $node;
			}

			$default = $this->args->getArgVal($request, 1);
			if (!$default) {
				return $requestNode;
			}

			if (!$default instanceof Node\Scalar\String_) {
				return $node;
			}

			if (\in_array($default->value ?? null, ['today', 'now', 'yesterday', 'tomorrow'])) {
				$else = new StaticCall(
					$node->class,
					(string) $default->value,
					[
						$this->args->createArg($this->args->getArgVal($node, $parseIndex + 1))
					],
					$this->helper->getAttributes($node),
				);
			} else {
				$else = new StaticCall(
					$node->class,
					'parse',
					[
						$this->args->createArg($default),
						$this->args->createArg($this->args->getArgVal($node, $parseIndex + 1))
					],
					$this->helper->getAttributes($node),
				);
			}

			return new Expr\Ternary(
				$requestNode,
				null,
				$else,
				$this->helper->getAttributes($node, ['wrapped_in_parentheses' => true]),
			);
		}

		return NodeTraverser::DONT_TRAVERSE_CHILDREN;
	}

	public function convertCarbonToRequest(Node $node, Node $request): Node|Expr|null
	{
		if ($this->isName($node->name, 'parse')) {
			return $this->convertRequestToMethod(
				$request,
				'date',
				[
					$this->args->createArgFromExisting($request),
					$this->args->createNullIfExists($node, 2),
					$this->args->createArgFromExisting($node, 1)
				]
			);
		}

		if ($this->isName($node->name, 'createFromFormat')) {
			return $this->convertRequestToMethod(
				$request,
				'date',
				[
					$this->args->createArgFromExisting($request),
					$this->args->createArgFromExisting($node, 0),
					$this->args->createArgFromExisting($node, 2),
				]
			);
		}

		return null;
	}

	private function refactorCast(Cast $node): Node|int
	{
		if (!$this->isRequest($node->expr)) {
			return NodeTraverser::DONT_TRAVERSE_CHILDREN;
		}

		return match ($this->helper->getCastType($node)) {
			'int'   => $this->convertRequestToMethod($node->expr, 'integer'),
			'float' => $this->convertRequestToMethod($node->expr, 'float'),
			'bool'  => $this->convertRequestToMethod($node->expr, 'boolean'),
			default => NodeTraverser::DONT_TRAVERSE_CHILDREN,
		};
	}
}
