<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;
use Rector\Php70\Rector\List_\EmptyListRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Unset_\UnsetCastRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\Php71\Rector\BooleanOr\IsIterableRector;
use Rector\Php70\Rector\FuncCall\MultiDirnameRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php70\Rector\Assign\ListSplitStringRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use Rector\Php72\Rector\FuncCall\StringifyDefineRector;
use Rector\Php73\Rector\FuncCall\SensitiveDefineRector;
use Rector\Php72\Rector\While_\WhileEachToForeachRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector;
use Rector\Php74\Rector\Double\RealToFloatTypeCastRector;
use Rector\CodeQuality\Rector\Assign\CombinedAssignRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\Php70\Rector\ClassMethod\Php4ConstructorRector;
use Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use Rector\Php73\Rector\String_\SensitiveHereNowDocRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use RectorLaravel\Rector\Namespace_\FactoryDefinitionRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector;
use Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector;
use Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use BuckhamDuffy\CodingStandards\Rector\UseLaravelCarbonRector;
use Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector;
use Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector;
use Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector;
use Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector;
use Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector;
use RectorLaravel\Rector\FuncCall\FactoryFuncCallToStaticCallRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector;
use Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector;
use Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector;

return RectorConfig::configure()
	->withPaths([
		getcwd() . '/app'
	])
	->withPhpVersion(PhpVersion::PHP_82)
	->withImportNames()
	->withRules([
		// Code Quality
		AbsolutizeRequireAndIncludePathRector::class,
		AndAssignsToSeparateLinesRector::class,
		ArrayKeyExistsTernaryThenValueToCoalescingRector::class,
		ArrayMergeOfNonArraysToSimpleArrayRector::class,
		ChangeArrayPushToArrayAssignRector::class,
		CombineIfRector::class,
		CombinedAssignRector::class,
		CompactToVariablesRector::class,
		CompleteDynamicPropertiesRector::class,
		ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class,
		ExplicitBoolCompareRector::class,
		ForRepeatedCountToOwnVariableRector::class,
		ForeachToInArrayRector::class,
		JoinStringConcatRector::class,
		NewStaticToNewSelfRector::class,
		RemoveSoleValueSprintfRector::class,
		ShortenElseIfRector::class,
		SimplifyArraySearchRector::class,
		SimplifyForeachToCoalescingRector::class,
		SimplifyIfElseToTernaryRector::class,
		SimplifyIfNotNullReturnRector::class,
		SimplifyIfReturnBoolRector::class,
		SimplifyInArrayValuesRector::class,
		SimplifyRegexPatternRector::class,
		SimplifyStrposLowerRector::class,
		SimplifyUselessVariableRector::class,
		SingularSwitchToIfRector::class,
		ThrowWithPreviousExceptionRector::class,
		UnusedForeachValueToArrayKeysRector::class,

		// Coding Style
		CatchExceptionNameMatchingTypeRector::class,
		EncapsedStringsToSprintfRector::class,
		MakeInheritedMethodVisibilitySameAsParentRector::class,
		SeparateMultiUseImportsRector::class,
		SplitDoubleAssignRector::class,
		UseIncrementAssignRector::class,
		SymplifyQuoteEscapeRector::class,

		// Dead Code
		RemoveAlwaysTrueIfConditionRector::class,
		RemoveDeadConditionAboveReturnRector::class,
		RemoveDeadIfForeachForRector::class,
		RemoveDeadInstanceOfRector::class,
		RemoveDeadReturnRector::class,
		RemoveDeadStmtRector::class,
		RemoveDuplicatedCaseInSwitchRector::class,
		RemoveNonExistingVarAnnotationRector::class,
		RemoveParentCallWithoutParentRector::class,
		RemoveUnusedConstructorParamRector::class,
		RemoveUnusedForeachKeyRector::class,
		RemoveUnusedPrivateClassConstantRector::class,
		RemoveUnusedVariableAssignRector::class,
		RemoveUselessParamTagRector::class,
		RemoveUselessReturnTagRector::class,
		RemoveUselessVarTagRector::class,
		SimplifyIfElseWithSameContentRector::class,
		TernaryToBooleanOrFalseToBooleanAndRector::class,

		// Early Return
		ChangeIfElseValueAssignToEarlyReturnRector::class,
		ChangeNestedForeachIfsToEarlyContinueRector::class,
		ChangeNestedIfsToEarlyReturnRector::class,
		PreparedValueToEarlyReturnRector::class,
		RemoveAlwaysElseRector::class,
	])
	->withSets([
		SetList::TYPE_DECLARATION,
	])
	->withRules([
		// Php Version Upgrades

		// Php52
		VarToPublicPropertyRector::class,
		ContinueToBreakInSwitchRector::class,

		// Php53
		TernaryToElvisRector::class,
		DirNameFileConstantToDirConstantRector::class,
		ReplaceHttpServerVarsByServerRector::class,

		// Php55
		StringClassNameToClassConstantRector::class,
		ClassConstantToSelfClassRector::class,

		// Php70
		Php4ConstructorRector::class,
		TernaryToNullCoalescingRector::class,
		RandomFunctionRector::class,
		ExceptionHandlerTypehintRector::class,
		MultiDirnameRector::class,
		ListSplitStringRector::class,
		EmptyListRector::class,
		ReduceMultipleDefaultSwitchRector::class,
		StaticCallOnNonStaticToInstanceCallRector::class,
		ThisCallOnStaticMethodToStaticCallRector::class,
		BreakNotInLoopOrSwitchToReturnRector::class,

		// Php71
		IsIterableRector::class,
		MultiExceptionCatchRector::class,
		AssignArrayToStringRector::class,
		RemoveExtraParametersRector::class,
		BinaryOpBetweenNumberAndStringRector::class,

		// Php72
		WhileEachToForeachRector::class,
		ListEachRector::class,
		ReplaceEachAssignmentWithKeyCurrentRector::class,
		UnsetCastRector::class,
		GetClassOnNullRector::class,
		ParseStrWithResultArgumentRector::class,
		StringsAssertNakedRector::class,
		CreateFunctionToAnonymousFunctionRector::class,
		StringifyDefineRector::class,

		// Php73
		ArrayKeyFirstLastRector::class,
		SensitiveDefineRector::class,
		SensitiveConstantNameRector::class,
		SensitiveHereNowDocRector::class,
		StringifyStrNeedlesRector::class,

		// Php74
		ArrayKeyExistsOnPropertyRector::class,
		FilterVarToAddSlashesRector::class,
		ExportToReflectionFunctionRector::class,
		GetCalledClassToStaticClassRector::class,
		MbStrrposEncodingArgumentPositionRector::class,
		RealToFloatTypeCastRector::class,
		NullCoalescingOperatorRector::class,
		ClosureToArrowFunctionRector::class,
		AddLiteralSeparatorToNumberRector::class,
		RestoreDefaultNullToNullableTypePropertyRector::class,
		AddGenericReturnTypeToRelationsRector::class,
	])

	// Laravel
	->withRules([
		UseLaravelCarbonRector::class,
		EloquentWhereRelationTypeHintingParameterRector::class,
		EloquentOrderByToLatestOrOldestRector::class,
		EloquentMagicMethodToQueryBuilderRector::class,
		AssertStatusToAssertMethodRector::class,
		EloquentWhereTypeHintClosureParameterRector::class,
		FactoryDefinitionRector::class,
		FactoryFuncCallToStaticCallRector::class,
		MigrateToSimplifiedAttributeRector::class,
		ModelCastsPropertyToCastsMethodRector::class,
		OptionalToNullsafeOperatorRector::class,
		RemoveDumpDataDeadCodeRector::class,
		RemoveModelPropertyFromFactoriesRector::class,
		ReplaceFakerInstanceWithHelperRector::class,
		RequestStaticValidateToInjectRector::class,
		RouteActionCallableRector::class,
		SubStrToStartsWithOrEndsWithStaticMethodCallRector::class,
		UnifyModelDatesWithCastsRector::class,
		ValidationRuleArrayStringValueToArrayRector::class,
	])

	->withSets([
		LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
		LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
		LaravelSetList::LARAVEL_80,
		LaravelSetList::LARAVEL_90,
		LaravelSetList::LARAVEL_100,
		LaravelSetList::LARAVEL_110,
		LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
		LaravelSetList::LARAVEL_CODE_QUALITY,
	])
	->withPhpSets(
		php83: true,
	);
