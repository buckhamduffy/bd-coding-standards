<?php

declare(strict_types=1);

use Rector\Set\ValueObject\SetList;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\PostRector\Rector\UseAddingPostRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PostRector\Rector\ClassRenamingPostRector;
use Rector\PostRector\Rector\NodeToReplacePostRector;
use Rector\CodeQuality\Rector\For_\ForToForeachRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\CodeQuality\Rector\Assign\CombinedAssignRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector;
use Rector\Defluent\Rector\ClassMethod\NormalToFluentRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\CodeQuality\Rector\ClassMethod\NarrowUnionTypeDocRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedAssignVariableRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDuplicatedIfReturnRector;
use Rector\EarlyReturn\Rector\Foreach_\ReturnAfterToEarlyOnBreakRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToArrayFilterRector;
use Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector;
use Rector\Privatization\Rector\Class_\ChangeLocalPropertyToVariableRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
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
return static function (ContainerConfigurator $containerConfigurator): void {
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
	$services->set(\Rector\Php52\Rector\Property\VarToPublicPropertyRector::class);
	$services->set(\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class);

	// Php53
	$services->set(\Rector\Php53\Rector\Ternary\TernaryToElvisRector::class);
	$services->set(\Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector::class);
	$services->set(\Rector\Php53\Rector\AssignRef\ClearReturnNewByReferenceRector::class);
	$services->set(\Rector\Php53\Rector\Variable\ReplaceHttpServerVarsByServerRector::class);

	// Php55
	$services->set(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
	$services->set(\Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector::class);

	// Php70
	$services->set(\Rector\Php70\Rector\ClassMethod\Php4ConstructorRector::class);
	$services->set(\Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector::class);
	$services->set(\Rector\Php70\Rector\FuncCall\RandomFunctionRector::class);
	$services->set(\Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector::class);
	$services->set(\Rector\Php70\Rector\FuncCall\MultiDirnameRector::class);
	$services->set(\Rector\Php70\Rector\Assign\ListSplitStringRector::class);
	$services->set(\Rector\Php70\Rector\List_\EmptyListRector::class);
	$services->set(\Rector\Php70\Rector\Switch_\ReduceMultipleDefaultSwitchRector::class);
	$services->set(\Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector::class);
	$services->set(\Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector::class);
	$services->set(\Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector::class);

	// Php71
	$services->set(\Rector\Php71\Rector\BooleanOr\IsIterableRector::class);
	$services->set(\Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector::class);
	$services->set(\Rector\Php71\Rector\Assign\AssignArrayToStringRector::class);
	// $services->set(\Rector\Php71\Rector\FuncCall\CountOnNullRector::class);
	$services->set(\Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector::class);
	$services->set(\Rector\Php71\Rector\BinaryOp\BinaryOpBetweenNumberAndStringRector::class);

	// Php72
	$services->set(\Rector\Php72\Rector\While_\WhileEachToForeachRector::class);
	$services->set(\Rector\Php72\Rector\Assign\ListEachRector::class);
	$services->set(\Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector::class);
	$services->set(\Rector\Php72\Rector\Unset_\UnsetCastRector::class);
	$services->set(\Rector\Php72\Rector\FuncCall\GetClassOnNullRector::class);
	$services->set(\Rector\Php72\Rector\FuncCall\IsObjectOnIncompleteClassRector::class);
	$services->set(\Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector::class);
	$services->set(\Rector\Php72\Rector\FuncCall\StringsAssertNakedRector::class);
	$services->set(\Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector::class);
	$services->set(\Rector\Php72\Rector\FuncCall\StringifyDefineRector::class);

	// Php73
	$services->set(\Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector::class);
	$services->set(\Rector\Php73\Rector\FuncCall\SensitiveDefineRector::class);
	$services->set(\Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector::class);
	$services->set(\Rector\Php73\Rector\String_\SensitiveHereNowDocRector::class);
	$services->set(\Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector::class);

	// Php74
	$services->set(\Rector\Php74\Rector\Property\TypedPropertyRector::class);
	$services->set(\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::class)
		->call(
			'configure',
			[[\Rector\Renaming\Rector\FuncCall\RenameFunctionRector::OLD_FUNCTION_TO_NEW_FUNCTION => [
			// the_real_type
			// https://wiki.php.net/rfc/deprecations_php_7_4
			'is_real' => 'is_float',
			// apache_request_headers_function
			// https://wiki.php.net/rfc/deprecations_php_7_4
			'apache_request_headers' => 'getallheaders',
			]]]
		);
	$services->set(\Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector::class);
	$services->set(\Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector::class);
	$services->set(\Rector\Php74\Rector\StaticCall\ExportToReflectionFunctionRector::class);
	$services->set(\Rector\Php74\Rector\FuncCall\GetCalledClassToStaticClassRector::class);
	$services->set(\Rector\Php74\Rector\FuncCall\MbStrrposEncodingArgumentPositionRector::class);
	$services->set(\Rector\Php74\Rector\Double\RealToFloatTypeCastRector::class);
	$services->set(\Rector\Php74\Rector\Assign\NullCoalescingOperatorRector::class);
	$services->set(\Rector\Php74\Rector\Function_\ReservedFnFunctionRector::class);
	$services->set(\Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector::class);
	$services->set(\Rector\Php74\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector::class);
	$services->set(\Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector::class);
	$services->set(\Rector\Php74\Rector\MethodCall\ChangeReflectionTypeToStringToGetNameRector::class);
	$services->set(\Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector::class);

	// Post Rector
	$services->set(ClassRenamingPostRector::class);
	$services->set(NodeToReplacePostRector::class);
	$services->set(UseAddingPostRector::class);
};
