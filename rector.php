<?php

declare(strict_types=1);
use Rector\Set\ValueObject\SetList;
use Rector\Core\Configuration\Option;
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
use Rector\PostRector\Rector\NodeToReplacePostRector;
use Rector\CodeQuality\Rector\For_\ForToForeachRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php72\Rector\FuncCall\GetClassOnNullRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\Php72\Rector\FuncCall\StringifyDefineRector;
use Rector\Php73\Rector\FuncCall\SensitiveDefineRector;
use Rector\Php72\Rector\While_\WhileEachToForeachRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector;
use Rector\Php74\Rector\Double\RealToFloatTypeCastRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\CodeQuality\Rector\Assign\CombinedAssignRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\Php70\Rector\ClassMethod\Php4ConstructorRector;
use Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use Rector\Php73\Rector\String_\SensitiveHereNowDocRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Php74\Rector\Function_\ReservedFnFunctionRector;
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
use Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector;
use Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector;
use Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\CodeQuality\Rector\ClassMethod\NarrowUnionTypeDocRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector;
use Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector;
use Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector;
use Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector;
use Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector;
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
use Rector\EarlyReturn\Rector\Foreach_\ReturnAfterToEarlyOnBreakRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector;
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
use Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Restoration\Rector\Property\MakeTypedPropertyNullableIfCheckedRector;
use Rector\Carbon\Rector\MethodCall\ChangeCarbonSingularMethodCallToPluralRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector;
use Rector\CodeQuality\Rector\FuncCall\InArrayAndArrayKeysToArrayKeyExistsRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector;
use Rector\Restoration\Rector\ClassLike\UpdateFileNameByClassNameFileSystemRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector;
use Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use Rector\Privatization\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector;

/**
 * @phpstan-ignore-next-line
 */
return static function(ContainerConfigurator $containerConfigurator): void {
	// get parameters
	$parameters = $containerConfigurator->parameters();
	$parameters->set(Option::PATHS, [getcwd() . '/app']);
	$parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);
	$parameters->set(Option::AUTO_IMPORT_NAMES, true);

	// get services (needed for register a single rule)
	$services = $containerConfigurator->services();

	// Code Quality
	$services->set(NarrowUnionTypeDocRector::class);
	$services->set(ChangeCarbonSingularMethodCallToPluralRector::class);
	$services->set(AbsolutizeRequireAndIncludePathRector::class);
	$services->set(AndAssignsToSeparateLinesRector::class);
	$services->set(ArrayKeyExistsTernaryThenValueToCoalescingRector::class);
	$services->set(ArrayKeysAndInArrayToArrayKeyExistsRector::class);
	$services->set(ArrayMergeOfNonArraysToSimpleArrayRector::class);
	$services->set(ChangeArrayPushToArrayAssignRector::class);
	$services->set(CombineIfRector::class);
	$services->set(CombinedAssignRector::class);
	$services->set(CompactToVariablesRector::class);
	$services->set(CompleteDynamicPropertiesRector::class);
	$services->set(ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class);
	$services->set(ExplicitBoolCompareRector::class);
	$services->set(FixClassCaseSensitivityNameRector::class);
	$services->set(ForRepeatedCountToOwnVariableRector::class);
	$services->set(ForToForeachRector::class);
	$services->set(ForeachToInArrayRector::class);
	$services->set(InArrayAndArrayKeysToArrayKeyExistsRector::class);
	$services->set(JoinStringConcatRector::class);
	$services->set(NewStaticToNewSelfRector::class);
	$services->set(RemoveAlwaysTrueConditionSetInConstructorRector::class);
	$services->set(RemoveSoleValueSprintfRector::class);
	$services->set(ShortenElseIfRector::class);
	$services->set(SimplifyForeachToArrayFilterRector::class);
	$services->set(SimplifyForeachToCoalescingRector::class);
	$services->set(SimplifyIfElseToTernaryRector::class);
	$services->set(SimplifyIfNotNullReturnRector::class);
	$services->set(SimplifyIfReturnBoolRector::class);
	$services->set(SimplifyInArrayValuesRector::class);
	$services->set(SimplifyRegexPatternRector::class);
	$services->set(SimplifyStrposLowerRector::class);
	$services->set(SimplifyUselessVariableRector::class);
	$services->set(SingularSwitchToIfRector::class);
	$services->set(SplitListAssignToSeparateLineRector::class);
	$services->set(ThrowWithPreviousExceptionRector::class);
	$services->set(UnusedForeachValueToArrayKeysRector::class);

	// Coding Style
	$services->set(AddArrayDefaultToArrayPropertyRector::class);
	$services->set(AddFalseDefaultToBoolPropertyRector::class);
	$services->set(BinarySwitchToIfElseRector::class);
	$services->set(CatchExceptionNameMatchingTypeRector::class);
	// $services->set(CountArrayToEmptyArrayComparisonRector::class);
	$services->set(EncapsedStringsToSprintfRector::class);
	$services->set(FollowRequireByDirRector::class);
	$services->set(MakeInheritedMethodVisibilitySameAsParentRector::class);
	// $services->set(PreslashSimpleFunctionRector::class);
	$services->set(SeparateMultiUseImportsRector::class);
	$services->set(SplitDoubleAssignRector::class);
	$services->set(SplitGroupedConstantsAndPropertiesRector::class);
	$services->set(UseIncrementAssignRector::class);
	$services->set(UseMessageVariableForSprintfInSymfonyStyleRector::class);
	$services->set(SymplifyQuoteEscapeRector::class);

	// // Dead Code
	// $services->set(RecastingRemovalRector::class);
	$services->set(RemoveAlwaysTrueIfConditionRector::class);
	$services->set(RemoveAssignOfVoidReturnFunctionRector::class);
	$services->set(RemoveCodeAfterReturnRector::class);
	$services->set(RemoveDeadConditionAboveReturnRector::class);
	$services->set(RemoveDeadConstructorRector::class);
	$services->set(RemoveDeadIfForeachForRector::class);
	$services->set(RemoveDeadInstanceOfRector::class);
	$services->set(RemoveDeadReturnRector::class);
	$services->set(RemoveDeadStmtRector::class);
	$services->set(RemoveDelegatingParentCallRector::class);
	$services->set(RemoveDuplicatedCaseInSwitchRector::class);
	$services->set(RemoveDuplicatedIfReturnRector::class);
	// $services->set(RemoveEmptyMethodCallRector::class);
	// $services->set(RemoveEmptyClassMethodRector::class);
	$services->set(RemoveNonExistingVarAnnotationRector::class);
	$services->set(RemoveOverriddenValuesRector::class);
	$services->set(RemoveParentCallWithoutParentRector::class);
	$services->set(RemoveUnusedAssignVariableRector::class);
	$services->set(RemoveUnusedConstructorParamRector::class);
	$services->set(RemoveUnusedForeachKeyRector::class);
	$services->set(RemoveUnusedPrivateClassConstantRector::class);
	// $services->set(RemoveUnusedPrivateMethodParameterRector::class);
	$services->set(RemoveUnusedVariableAssignRector::class);
	$services->set(RemoveUselessParamTagRector::class);
	$services->set(RemoveUselessReturnTagRector::class);
	$services->set(RemoveUselessVarTagRector::class);
	$services->set(SimplifyIfElseWithSameContentRector::class);
	$services->set(TernaryToBooleanOrFalseToBooleanAndRector::class);

	// Early Return
	$services->set(ChangeIfElseValueAssignToEarlyReturnRector::class);
	$services->set(ChangeNestedForeachIfsToEarlyContinueRector::class);
	$services->set(ChangeNestedIfsToEarlyReturnRector::class);
	$services->set(PreparedValueToEarlyReturnRector::class);
	$services->set(RemoveAlwaysElseRector::class);
	$services->set(ReturnAfterToEarlyOnBreakRector::class);
	//
	// // Naming
	// $services->set(RenameForeachValueVariableToMatchExprVariableRector::class);
	// $services->set(RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class);
	// $services->set(RenameParamToMatchTypeRector::class);
	// $services->set(RenamePropertyToMatchTypeRector::class);
	// $services->set(RenameVariableToMatchMethodCallReturnTypeRector::class);
	// $services->set(RenameVariableToMatchNewTypeRector::class);
	//
	// Typed
	$services->set(RestoreDefaultNullToNullableTypePropertyRector::class);
	$services->set(TypedPropertyRector::class);

	// // Privatization
	// $services->set(ChangeLocalPropertyToVariableRector::class);
	// $services->set(ChangeReadOnlyPropertyWithDefaultValueToConstantRector::class);
	// $services->set(PrivatizeLocalGetterToPropertyRector::class);

	// Restoration
	$services->set(MakeTypedPropertyNullableIfCheckedRector::class);
	// $services->set(UpdateFileNameByClassNameFileSystemRector::class);

	// Types
	$containerConfigurator->import(SetList::TYPE_DECLARATION);

	// Php Version Upgrades

	// Php52
	$services->set(VarToPublicPropertyRector::class);
	$services->set(ContinueToBreakInSwitchRector::class);

	// Php53
	$services->set(TernaryToElvisRector::class);
	$services->set(DirNameFileConstantToDirConstantRector::class);
	$services->set(ClearReturnNewByReferenceRector::class);
	$services->set(ReplaceHttpServerVarsByServerRector::class);

	// Php55
	$services->set(StringClassNameToClassConstantRector::class);
	$services->set(ClassConstantToSelfClassRector::class);

	// Php70
	$services->set(Php4ConstructorRector::class);
	$services->set(TernaryToNullCoalescingRector::class);
	$services->set(RandomFunctionRector::class);
	$services->set(ExceptionHandlerTypehintRector::class);
	$services->set(MultiDirnameRector::class);
	$services->set(ListSplitStringRector::class);
	$services->set(EmptyListRector::class);
	$services->set(ReduceMultipleDefaultSwitchRector::class);
	$services->set(StaticCallOnNonStaticToInstanceCallRector::class);
	$services->set(ThisCallOnStaticMethodToStaticCallRector::class);
	$services->set(BreakNotInLoopOrSwitchToReturnRector::class);

	// Php71
	$services->set(IsIterableRector::class);
	$services->set(MultiExceptionCatchRector::class);
	$services->set(AssignArrayToStringRector::class);
	// $services->set(\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
	$services->set(RemoveExtraParametersRector::class);
	$services->set(BinaryOpBetweenNumberAndStringRector::class);

	// Php72
	$services->set(WhileEachToForeachRector::class);
	$services->set(ListEachRector::class);
	$services->set(ReplaceEachAssignmentWithKeyCurrentRector::class);
	$services->set(UnsetCastRector::class);
	$services->set(GetClassOnNullRector::class);
	$services->set(IsObjectOnIncompleteClassRector::class);
	$services->set(ParseStrWithResultArgumentRector::class);
	$services->set(StringsAssertNakedRector::class);
	$services->set(CreateFunctionToAnonymousFunctionRector::class);
	$services->set(StringifyDefineRector::class);

	// Php73
	$services->set(ArrayKeyFirstLastRector::class);
	$services->set(SensitiveDefineRector::class);
	$services->set(SensitiveConstantNameRector::class);
	$services->set(SensitiveHereNowDocRector::class);
	$services->set(StringifyStrNeedlesRector::class);

	// Php74
	$services->set(TypedPropertyRector::class);
	$services->set(RenameFunctionRector::class)
		->call(
			'configure',
			[[RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
			'is_real'                => 'is_float',
			'apache_request_headers' => 'getallheaders',
			]]]
		);
	$services->set(ArrayKeyExistsOnPropertyRector::class);
	$services->set(FilterVarToAddSlashesRector::class);
	$services->set(ExportToReflectionFunctionRector::class);
	$services->set(GetCalledClassToStaticClassRector::class);
	$services->set(MbStrrposEncodingArgumentPositionRector::class);
	$services->set(RealToFloatTypeCastRector::class);
	$services->set(NullCoalescingOperatorRector::class);
	$services->set(ReservedFnFunctionRector::class);
	$services->set(ClosureToArrowFunctionRector::class);
	$services->set(ArraySpreadInsteadOfArrayMergeRector::class);
	$services->set(AddLiteralSeparatorToNumberRector::class);
	$services->set(ChangeReflectionTypeToStringToGetNameRector::class);
	$services->set(RestoreDefaultNullToNullableTypePropertyRector::class);

	// Post Rector
	$services->set(ClassRenamingPostRector::class);
	$services->set(NodeToReplacePostRector::class);
	$services->set(UseAddingPostRector::class);
};
