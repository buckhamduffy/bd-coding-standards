<?php

declare(strict_types=1);
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use RectorLaravel\Set\LaravelSetList;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php70\Rector\List_\EmptyListRector;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Unset_\UnsetCastRector;
use Rector\PostRector\Rector\UseAddingPostRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\Php71\Rector\BooleanOr\IsIterableRector;
use Rector\Php70\Rector\FuncCall\MultiDirnameRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php70\Rector\Assign\ListSplitStringRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PostRector\Rector\ClassRenamingPostRector;
use Rector\CodeQuality\Rector\For_\ForToForeachRector;
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
use Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\CodeQuality\Rector\ClassMethod\NarrowUnionTypeDocRector;
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
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector;
use Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDuplicatedIfReturnRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector;
use Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToArrayFilterRector;
use Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector;

/**
 * @phpstan-ignore-next-line
 */
return static function(RectorConfig $config): void {
	$config->paths([
		getcwd() . '/app'
	]);

	$config->phpVersion(PhpVersion::PHP_82);
	$config->importNames();

	// Code Quality
	$config->rule(NarrowUnionTypeDocRector::class);
	$config->rule(AbsolutizeRequireAndIncludePathRector::class);
	$config->rule(AndAssignsToSeparateLinesRector::class);
	$config->rule(ArrayKeyExistsTernaryThenValueToCoalescingRector::class);
	$config->rule(ArrayKeysAndInArrayToArrayKeyExistsRector::class);
	$config->rule(ArrayMergeOfNonArraysToSimpleArrayRector::class);
	$config->rule(ChangeArrayPushToArrayAssignRector::class);
	$config->rule(CombineIfRector::class);
	$config->rule(CombinedAssignRector::class);
	$config->rule(CompactToVariablesRector::class);
	$config->rule(CompleteDynamicPropertiesRector::class);
	$config->rule(ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class);
	$config->rule(ExplicitBoolCompareRector::class);
	$config->rule(ForRepeatedCountToOwnVariableRector::class);
	$config->rule(ForToForeachRector::class);
	$config->rule(ForeachToInArrayRector::class);
	$config->rule(JoinStringConcatRector::class);
	$config->rule(NewStaticToNewSelfRector::class);
	$config->rule(RemoveAlwaysTrueConditionSetInConstructorRector::class);
	$config->rule(RemoveSoleValueSprintfRector::class);
	$config->rule(ShortenElseIfRector::class);
	$config->rule(SimplifyForeachToArrayFilterRector::class);
	$config->rule(SimplifyForeachToCoalescingRector::class);
	$config->rule(SimplifyIfElseToTernaryRector::class);
	$config->rule(SimplifyIfNotNullReturnRector::class);
	$config->rule(SimplifyIfReturnBoolRector::class);
	$config->rule(SimplifyInArrayValuesRector::class);
	$config->rule(SimplifyRegexPatternRector::class);
	$config->rule(SimplifyStrposLowerRector::class);
	$config->rule(SimplifyUselessVariableRector::class);
	$config->rule(SingularSwitchToIfRector::class);
	$config->rule(SplitListAssignToSeparateLineRector::class);
	$config->rule(ThrowWithPreviousExceptionRector::class);
	$config->rule(UnusedForeachValueToArrayKeysRector::class);

	// Coding Style
	$config->rule(AddArrayDefaultToArrayPropertyRector::class);
	$config->rule(AddFalseDefaultToBoolPropertyRector::class);
	$config->rule(BinarySwitchToIfElseRector::class);
	$config->rule(CatchExceptionNameMatchingTypeRector::class);
	// $config->rule(CountArrayToEmptyArrayComparisonRector::class);
	$config->rule(EncapsedStringsToSprintfRector::class);
	$config->rule(MakeInheritedMethodVisibilitySameAsParentRector::class);
	// $config->rule(PreslashSimpleFunctionRector::class);
	$config->rule(SeparateMultiUseImportsRector::class);
	$config->rule(SplitDoubleAssignRector::class);
	$config->rule(SplitGroupedConstantsAndPropertiesRector::class);
	$config->rule(UseIncrementAssignRector::class);
	$config->rule(SymplifyQuoteEscapeRector::class);

	// // Dead Code
	// $config->rule(RecastingRemovalRector::class);
	$config->rule(RemoveAlwaysTrueIfConditionRector::class);
	$config->rule(RemoveDeadConditionAboveReturnRector::class);
	// $config->rule(RemoveDeadConstructorRector::class);
	$config->rule(RemoveDeadIfForeachForRector::class);
	$config->rule(RemoveDeadInstanceOfRector::class);
	$config->rule(RemoveDeadReturnRector::class);
	$config->rule(RemoveDeadStmtRector::class);
	$config->rule(RemoveDelegatingParentCallRector::class);
	$config->rule(RemoveDuplicatedCaseInSwitchRector::class);
	$config->rule(RemoveDuplicatedIfReturnRector::class);
	// $config->rule(RemoveEmptyMethodCallRector::class);
	// $config->rule(RemoveEmptyClassMethodRector::class);
	$config->rule(RemoveNonExistingVarAnnotationRector::class);
	$config->rule(RemoveParentCallWithoutParentRector::class);
	$config->rule(RemoveUnusedConstructorParamRector::class);
	$config->rule(RemoveUnusedForeachKeyRector::class);
	$config->rule(RemoveUnusedPrivateClassConstantRector::class);
	// $config->rule(RemoveUnusedPrivateMethodParameterRector::class);
	$config->rule(RemoveUnusedVariableAssignRector::class);
	$config->rule(RemoveUselessParamTagRector::class);
	$config->rule(RemoveUselessReturnTagRector::class);
	$config->rule(RemoveUselessVarTagRector::class);
	$config->rule(SimplifyIfElseWithSameContentRector::class);
	$config->rule(TernaryToBooleanOrFalseToBooleanAndRector::class);

	// Early Return
	$config->rule(ChangeIfElseValueAssignToEarlyReturnRector::class);
	$config->rule(ChangeNestedForeachIfsToEarlyContinueRector::class);
	$config->rule(ChangeNestedIfsToEarlyReturnRector::class);
	$config->rule(PreparedValueToEarlyReturnRector::class);
	$config->rule(RemoveAlwaysElseRector::class);
	//
	// // Naming
	// $config->rule(RenameForeachValueVariableToMatchExprVariableRector::class);
	// $config->rule(RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
	// $config->rule(RenameParamToMatchTypeRector::class);
	// $config->rule(RenamePropertyToMatchTypeRector::class);
	// $config->rule(RenameVariableToMatchMethodCallReturnTypeRector::class);
	// $config->rule(RenameVariableToMatchNewTypeRector::class);
	//
	// Typed
	$config->rule(RestoreDefaultNullToNullableTypePropertyRector::class);
	$config->rule(TypedPropertyRector::class);

	// // Privatization
	// $config->rule(ChangeLocalPropertyToVariableRector::class);
	// $config->rule(ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
	// $config->rule(PrivatizeLocalGetterToPropertyRector::class);

	// Restoration
	$config->rule(MakeTypedPropertyNullableIfCheckedRector::class);
	// $config->rule(UpdateFileNameByClassNameFileSystemRector::class);

	// Types
	$config->sets([SetList::TYPE_DECLARATION]);

	// Php Version Upgrades

	// Php52
	$config->rule(VarToPublicPropertyRector::class);
	$config->rule(ContinueToBreakInSwitchRector::class);

	// Php53
	$config->rule(TernaryToElvisRector::class);
	$config->rule(DirNameFileConstantToDirConstantRector::class);
	$config->rule(ReplaceHttpServerVarsByServerRector::class);

	// Php55
	$config->rule(StringClassNameToClassConstantRector::class);
	$config->rule(ClassConstantToSelfClassRector::class);

	// Php70
	$config->rule(Php4ConstructorRector::class);
	$config->rule(TernaryToNullCoalescingRector::class);
	$config->rule(RandomFunctionRector::class);
	$config->rule(ExceptionHandlerTypehintRector::class);
	$config->rule(MultiDirnameRector::class);
	$config->rule(ListSplitStringRector::class);
	$config->rule(EmptyListRector::class);
	$config->rule(ReduceMultipleDefaultSwitchRector::class);
	$config->rule(StaticCallOnNonStaticToInstanceCallRector::class);
	$config->rule(ThisCallOnStaticMethodToStaticCallRector::class);
	$config->rule(BreakNotInLoopOrSwitchToReturnRector::class);

	// Php71
	$config->rule(IsIterableRector::class);
	$config->rule(MultiExceptionCatchRector::class);
	$config->rule(AssignArrayToStringRector::class);
	// $config->rule(\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
	$config->rule(RemoveExtraParametersRector::class);
	$config->rule(BinaryOpBetweenNumberAndStringRector::class);

	// Php72
	$config->rule(WhileEachToForeachRector::class);
	$config->rule(ListEachRector::class);
	$config->rule(ReplaceEachAssignmentWithKeyCurrentRector::class);
	$config->rule(UnsetCastRector::class);
	$config->rule(GetClassOnNullRector::class);
	$config->rule(IsObjectOnIncompleteClassRector::class);
	$config->rule(ParseStrWithResultArgumentRector::class);
	$config->rule(StringsAssertNakedRector::class);
	$config->rule(CreateFunctionToAnonymousFunctionRector::class);
	$config->rule(StringifyDefineRector::class);

	// Php73
	$config->rule(ArrayKeyFirstLastRector::class);
	$config->rule(SensitiveDefineRector::class);
	$config->rule(SensitiveConstantNameRector::class);
	$config->rule(SensitiveHereNowDocRector::class);
	$config->rule(StringifyStrNeedlesRector::class);

	// Php74
	$config->rule(TypedPropertyRector::class);
	$config->rule(ArrayKeyExistsOnPropertyRector::class);
	$config->rule(FilterVarToAddSlashesRector::class);
	$config->rule(ExportToReflectionFunctionRector::class);
	$config->rule(GetCalledClassToStaticClassRector::class);
	$config->rule(MbStrrposEncodingArgumentPositionRector::class);
	$config->rule(RealToFloatTypeCastRector::class);
	$config->rule(NullCoalescingOperatorRector::class);
	$config->rule(ClosureToArrowFunctionRector::class);
	$config->rule(ArraySpreadInsteadOfArrayMergeRector::class);
	$config->rule(AddLiteralSeparatorToNumberRector::class);
	$config->rule(ChangeReflectionTypeToStringToGetNameRector::class);
	$config->rule(RestoreDefaultNullToNullableTypePropertyRector::class);
	$config->rule(AddGenericReturnTypeToRelationsRector::class);

	// PHP8
	$config->sets([
		SetList::PHP_80,
		SetList::PHP_81,
		LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
		LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
		LaravelSetList::LARAVEL_80,
		LaravelSetList::LARAVEL_90,
	]);

	// Post Rector
	$config->rule(ClassRenamingPostRector::class);
	$config->rule(UseAddingPostRector::class);
};
