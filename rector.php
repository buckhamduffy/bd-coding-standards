<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Set\LaravelSetList;
use Rector\Php72\Rector\Assign\ListEachRector;
use Rector\Php72\Rector\Unset_\UnsetCastRector;
use Rector\Php56\Rector\FuncCall\PowToExpRector;
use Rector\Php70\Rector\If_\IfToSpaceshipRector;
use Rector\Php73\Rector\FuncCall\SetCookieRector;
use Rector\Php71\Rector\BooleanOr\IsIterableRector;
use Rector\Php70\Rector\FuncCall\MultiDirnameRector;
use Rector\Php73\Rector\BooleanOr\IsCountableRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\DeadCode\Rector\For_\RemoveDeadLoopRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php70\Rector\Assign\ListSplitStringRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\FunctionLike\MixedTypeRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\Php72\Rector\FuncCall\StringifyDefineRector;
use Rector\Php73\Rector\FuncCall\RegexDashEscapeRector;
use Rector\Php73\Rector\FuncCall\SensitiveDefineRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Rector\Php70\Rector\Assign\ListSwapArrayOrderRector;
use Rector\Php71\Rector\List_\ListToArrayDestructRector;
use Rector\Php72\Rector\While_\WhileEachToForeachRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\DeadCode\Rector\For_\RemoveDeadContinueRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\Php70\Rector\Ternary\TernaryToSpaceshipRector;
use Rector\Php71\Rector\Assign\AssignArrayToStringRector;
use Rector\Php73\Rector\FuncCall\ArrayKeyFirstLastRector;
use Rector\Php74\Rector\Double\RealToFloatTypeCastRector;
use Rector\CodeQuality\Rector\Assign\CombinedAssignRector;
use Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\Php70\Rector\ClassMethod\Php4ConstructorRector;
use Rector\Php72\Rector\FuncCall\StringsAssertNakedRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use RectorLaravel\Rector\Class_\AnonymousMigrationsRector;
use Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector;
use Rector\CodeQuality\Rector\Switch_\SwitchTrueToIfRector;
use Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector;
use Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector;
use Rector\DeadCode\Rector\If_\ReduceAlwaysFalseIfOrRector;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php54\Rector\Array_\LongArrayToShortArrayRector;
use Rector\Php71\Rector\TryCatch\MultiExceptionCatchRector;
use Rector\Php73\Rector\FuncCall\StringifyStrNeedlesRector;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector;
use Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector;
use Rector\Php55\Rector\FuncCall\PregReplaceEModifierRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use RectorLaravel\Rector\Namespace_\FactoryDefinitionRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;
use Rector\Php54\Rector\Break_\RemoveZeroBreakContinueRector;
use Rector\Php74\Rector\FuncCall\FilterVarToAddSlashesRector;
use Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector;
use Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector;
use Rector\CodeQuality\Rector\FuncCall\StrvalToTypeCastRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use Rector\Php55\Rector\Class_\ClassConstantToSelfClassRector;
use Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use Rector\CodeQuality\Rector\FuncCall\BoolvalToTypeCastRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\Php54\Rector\FuncCall\RemoveReferenceFromCallRector;
use Rector\Php73\Rector\ConstFetch\SensitiveConstantNameRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\FuncCall\FloatvalToTypeCastRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Php74\Rector\FuncCall\ArrayKeyExistsOnPropertyRector;
use Rector\Php74\Rector\Ternary\ParenthesizeNestedTernaryRector;
use Rector\CodeQuality\Rector\FuncCall\InlineIsAInstanceOfRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector;
use Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector;
use Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\If_\RemoveAlwaysTrueIfConditionRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\Php55\Rector\FuncCall\GetCalledClassToSelfClassRector;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Strict\Rector\If_\BooleanInIfConditionRuleFixerRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector;
use Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Php71\Rector\ClassConst\PublicConstantVisibilityRector;
use Rector\Php72\Rector\FuncCall\ParseStrWithResultArgumentRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector;
use Rector\CodeQuality\Rector\Identical\GetClassToInstanceOfRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\DeadCode\Rector\Property\RemoveUselessReadOnlyTagRector;
use Rector\Php55\Rector\FuncCall\GetCalledClassToStaticClassRector;
use Rector\Privatization\Rector\Class_\FinalizeTestCaseClassRector;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector;
use Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector;
use Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector;
use Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Plus\RemoveDeadZeroAndOneOperationRector;
use Rector\Php70\Rector\Break_\BreakNotInLoopOrSwitchToReturnRector;
use Rector\Php70\Rector\FunctionLike\ExceptionHandlerTypehintRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnUnionTypeRector;
use RectorLaravel\Rector\FuncCall\FactoryFuncCallToStaticCallRector;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\If_\CompleteMissingIfElseBracketRector;
use Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeNestedIfsToEarlyReturnRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php70\Rector\FuncCall\RenameMktimeWithoutArgsToTimeRector;
use RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector;
use RectorLaravel\Rector\MethodCall\JsonCallToExplicitJsonCallRector;
use Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector;
use Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\Php70\Rector\StmtsAwareInterface\IfIssetToCoalescingRector;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector;
use Rector\CodeQuality\Rector\Ternary\NumberCompareToMaxFuncCallRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\If_\RemoveTypedPropertyDeadInstanceOfRector;
use Rector\EarlyReturn\Rector\Return_\PreparedValueToEarlyReturnRector;
use Rector\Php55\Rector\ClassConstFetch\StaticToSelfOnFinalClassRector;
use RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector;
use Rector\CodeQuality\Rector\ClassMethod\InlineArrayReturnAssignRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php53\Rector\FuncCall\DirNameFileConstantToDirConstantRector;
use Rector\Php80\Rector\ClassConstFetch\ClassOnThisVariableObjectRector;
use RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector;
use RectorLaravel\Rector\Expr\AppEnvironmentComparisonToParameterRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
use Rector\CodeQuality\Rector\BooleanNot\ReplaceMultipleBooleanNotRector;
use Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector;
use Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector;
use Rector\CodingStyle\Rector\FuncCall\CallUserFuncArrayToVariadicRector;
use Rector\Instanceof_\Rector\Ternary\FlipNegatedTernaryInstanceofRector;
use Rector\Php72\Rector\Assign\ReplaceEachAssignmentWithKeyCurrentRector;
use Rector\Php72\Rector\FuncCall\CreateFunctionToAnonymousFunctionRector;
use Rector\TypeDeclaration\Rector\While_\WhileNullableToInstanceofRector;
use Rector\Visibility\Rector\ClassMethod\ExplicitPublicClassMethodRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedClassConstantsRector;
use Rector\CodingStyle\Rector\Stmt\RemoveUselessAliasInUseStatementRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\Php82\Rector\Encapsed\VariableInStringInterpolationFixerRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector;
use Rector\CodingStyle\Rector\ClassMethod\FuncGetArgsToVariadicParamRector;
use Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector;
use Rector\TypeDeclaration\Rector\Class_\ReturnTypeFromStrictTernaryRector;
use RectorLaravel\Rector\Class_\AddExtendsAnnotationToModelFactoriesRector;
use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use RectorLaravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector;
use Rector\Php70\Rector\MethodCall\ThisCallOnStaticMethodToStaticCallRector;
use Rector\Php74\Rector\ArrayDimFetch\CurlyToSquareBracketArrayStringRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictStringParamConcatRector;
use RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\EarlyReturn\Rector\If_\ChangeIfElseValueAssignToEarlyReturnRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector;
use RectorLaravel\Rector\MethodCall\UseComponentPropertyWithinCommandsRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByParentCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictParamRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictSetUpRector;
use Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector;
use Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnExprInConstructRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeFromPropertyTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\TypeDeclaration\Rector\Class_\PropertyTypeFromStrictSetterGetterRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\EarlyReturn\Rector\Foreach_\ChangeNestedForeachIfsToEarlyContinueRector;
use Rector\TypeDeclaration\Rector\Class_\AddTestsVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNativeCallRector;
use RectorLaravel\Rector\ClassMethod\AddParentRegisterToEventServiceProviderRector;
use Rector\CodeQuality\Rector\Class_\StaticToSelfStaticMethodCallOnFinalClassRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use Rector\CodeQuality\Rector\Ternary\TernaryEmptyArrayArrayDimFetchToCoalesceRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictFluentReturnRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedPropertyRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;
use Rector\CodeQuality\Rector\ClassConstFetch\ConvertStaticPrivateConstantToSelfRector;
use Rector\CodeQuality\Rector\NullsafeMethodCall\CleanupUnneededNullsafeOperatorRector;
use Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictBoolReturnExprRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictConstantReturnRector;
use Rector\TypeDeclaration\Rector\FunctionLike\AddReturnTypeDeclarationFromYieldsRector;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector;
use Rector\TypeDeclaration\Rector\Function_\AddFunctionVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromStrictScalarReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\NumericReturnTypeFromStrictScalarReturnsRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationBasedOnParentClassMethodRector;
use RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector;

return RectorConfig::configure()
	->withPaths(
		array_filter(
			[
				getcwd() . '/src',
				getcwd() . '/app',
			],
			fn (string $path) => file_exists($path) || is_dir($path)
		)
	)
	->withPhpVersion(PhpVersion::PHP_83)
	->withImportNames(true, true, true, true)

	// Rector Rules
	->withRules([
		SplitDoubleAssignRector::class,
		PreparedValueToEarlyReturnRector::class,
		StringifyStrNeedlesRector::class,

		ChangeIfElseValueAssignToEarlyReturnRector::class,
		RemoveUnusedPrivateClassConstantRector::class,
		ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class,
		SimplifyInArrayValuesRector::class,
		AbsolutizeRequireAndIncludePathRector::class,
		AndAssignsToSeparateLinesRector::class,
		ArrayKeyExistsTernaryThenValueToCoalescingRector::class,
		ArrayMergeOfNonArraysToSimpleArrayRector::class,
		BooleanNotIdenticalToNotIdenticalRector::class,
		BoolvalToTypeCastRector::class,
		ChangeArrayPushToArrayAssignRector::class,
		CleanupUnneededNullsafeOperatorRector::class,
		CombinedAssignRector::class,
		CompactToVariablesRector::class,
		CompleteDynamicPropertiesRector::class,
		CompleteMissingIfElseBracketRector::class,
		ConvertStaticPrivateConstantToSelfRector::class,
		ExplicitReturnNullRector::class,
		FloatvalToTypeCastRector::class,
		ForRepeatedCountToOwnVariableRector::class,
		ForeachToInArrayRector::class,
		GetClassToInstanceOfRector::class,
		InlineArrayReturnAssignRector::class,
		InlineConstructorDefaultToPropertyRector::class,
		InlineIfToExplicitIfRector::class,
		InlineIsAInstanceOfRector::class,
		IntvalToTypeCastRector::class,
		JoinStringConcatRector::class,
		LogicalToBooleanRector::class,
		NewStaticToNewSelfRector::class,
		NumberCompareToMaxFuncCallRector::class,
		ReplaceMultipleBooleanNotRector::class,
		RemoveSoleValueSprintfRector::class,
		SetTypeToCastRector::class,
		ShortenElseIfRector::class,
		SimplifyArraySearchRector::class,
		SimplifyBoolIdenticalTrueRector::class,
		SimplifyConditionsRector::class,
		SimplifyDeMorganBinaryRector::class,
		SimplifyEmptyArrayCheckRector::class,
		SimplifyEmptyCheckOnEmptyArrayRector::class,
		SimplifyForeachToCoalescingRector::class,
		SimplifyFuncGetArgsCountRector::class,
		SimplifyIfElseToTernaryRector::class,
		SimplifyIfNotNullReturnRector::class,
		SimplifyIfReturnBoolRector::class,
		SimplifyRegexPatternRector::class,
		SimplifyStrposLowerRector::class,
		SimplifyTautologyTernaryRector::class,
		SimplifyUselessVariableRector::class,
		SingleInArrayToCompareRector::class,
		StaticToSelfStaticMethodCallOnFinalClassRector::class,
		StrlenZeroToIdenticalEmptyStringRector::class,
		StrvalToTypeCastRector::class,
		SwitchNegatedTernaryRector::class,
		SwitchTrueToIfRector::class,
		TernaryEmptyArrayArrayDimFetchToCoalesceRector::class,
		ThrowWithPreviousExceptionRector::class,
		UnnecessaryTernaryExpressionRector::class,
		UnusedForeachValueToArrayKeysRector::class,
		UnwrapSprintfOneArgumentRector::class,
		CallUserFuncArrayToVariadicRector::class,
		ConsistentImplodeRector::class,
		EncapsedStringsToSprintfRector::class,
		FuncGetArgsToVariadicParamRector::class,
		PostIncDecToPreIncDecRector::class,
		RemoveFinalFromConstRector::class,
		RemoveUselessAliasInUseStatementRector::class,
		SeparateMultiUseImportsRector::class,
		SplitGroupedClassConstantsRector::class,
		SplitGroupedPropertiesRector::class,
		SymplifyQuoteEscapeRector::class,
		TernaryConditionVariableAssignmentRector::class,
		UseClassKeywordForClassNameResolutionRector::class,
		UseIncrementAssignRector::class,
		RecastingRemovalRector::class,
		ReduceAlwaysFalseIfOrRector::class,
		RemoveAlwaysTrueIfConditionRector::class,
		RemoveAndTrueRector::class,
		RemoveConcatAutocastRector::class,
		RemoveDeadConditionAboveReturnRector::class,
		RemoveDeadContinueRector::class,
		RemoveDeadIfForeachForRector::class,
		RemoveDeadInstanceOfRector::class,
		RemoveDeadLoopRector::class,
		RemoveDeadReturnRector::class,
		RemoveDeadStmtRector::class,
		RemoveDeadTryCatchRector::class,
		RemoveDeadZeroAndOneOperationRector::class,
		RemoveDoubleAssignRector::class,
		RemoveDuplicatedArrayKeyRector::class,
		RemoveDuplicatedCaseInSwitchRector::class,
		RemoveEmptyClassMethodRector::class,
		RemoveNonExistingVarAnnotationRector::class,
		RemoveParentCallWithoutParentRector::class,
		RemoveTypedPropertyDeadInstanceOfRector::class,
		RemoveUnreachableStatementRector::class,
		RemoveUnusedConstructorParamRector::class,
		RemoveUnusedForeachKeyRector::class,
		RemoveUnusedNonEmptyArrayBeforeForeachRector::class,
		RemoveUnusedPrivateMethodParameterRector::class,
		RemoveUnusedPrivateMethodRector::class,
		RemoveUnusedPrivatePropertyRector::class,
		RemoveUnusedPromotedPropertyRector::class,
		RemoveUnusedVariableAssignRector::class,
		RemoveUselessParamTagRector::class,
		RemoveUselessReadOnlyTagRector::class,
		RemoveUselessReturnExprInConstructRector::class,
		RemoveUselessReturnTagRector::class,
		RemoveUselessVarTagRector::class,
		SimplifyIfElseWithSameContentRector::class,
		SimplifyMirrorAssignRector::class,
		TernaryToBooleanOrFalseToBooleanAndRector::class,
		ChangeAndIfToEarlyReturnRector::class,
		ChangeNestedForeachIfsToEarlyContinueRector::class,
		ChangeNestedIfsToEarlyReturnRector::class,
		ChangeOrIfContinueToMultiContinueRector::class,
		RemoveAlwaysElseRector::class,
		ReturnBinaryOrToEarlyReturnRector::class,
		ReturnEarlyIfVariableRector::class,
		FlipNegatedTernaryInstanceofRector::class,
		RenameForeachValueVariableToMatchExprVariableRector::class,
		RenameForeachValueVariableToMatchMethodCallReturnTypeRector::class,
		ContinueToBreakInSwitchRector::class,
		VarToPublicPropertyRector::class,
		DirNameFileConstantToDirConstantRector::class,
		TernaryToElvisRector::class,
		LongArrayToShortArrayRector::class,
		RemoveReferenceFromCallRector::class,
		RemoveZeroBreakContinueRector::class,
		ClassConstantToSelfClassRector::class,
		GetCalledClassToSelfClassRector::class,
		GetCalledClassToStaticClassRector::class,
		PregReplaceEModifierRector::class,
		StaticToSelfOnFinalClassRector::class,
		StringClassNameToClassConstantRector::class,
		PowToExpRector::class,
		BreakNotInLoopOrSwitchToReturnRector::class,
		ExceptionHandlerTypehintRector::class,
		IfIssetToCoalescingRector::class,
		IfToSpaceshipRector::class,
		ListSplitStringRector::class,
		ListSwapArrayOrderRector::class,
		MultiDirnameRector::class,
		Php4ConstructorRector::class,
		RandomFunctionRector::class,
		RenameMktimeWithoutArgsToTimeRector::class,
		StaticCallOnNonStaticToInstanceCallRector::class,
		TernaryToNullCoalescingRector::class,
		TernaryToSpaceshipRector::class,
		ThisCallOnStaticMethodToStaticCallRector::class,
		AssignArrayToStringRector::class,
		IsIterableRector::class,
		ListToArrayDestructRector::class,
		MultiExceptionCatchRector::class,
		PublicConstantVisibilityRector::class,
		CreateFunctionToAnonymousFunctionRector::class,
		ListEachRector::class,
		ParseStrWithResultArgumentRector::class,
		ReplaceEachAssignmentWithKeyCurrentRector::class,
		StringifyDefineRector::class,
		StringsAssertNakedRector::class,
		UnsetCastRector::class,
		WhileEachToForeachRector::class,
		ArrayKeyFirstLastRector::class,
		IsCountableRector::class,
		JsonThrowOnErrorRector::class,
		RegexDashEscapeRector::class,
		SensitiveConstantNameRector::class,
		SensitiveDefineRector::class,
		SetCookieRector::class,
		AddLiteralSeparatorToNumberRector::class,
		ArrayKeyExistsOnPropertyRector::class,
		CurlyToSquareBracketArrayStringRector::class,
		FilterVarToAddSlashesRector::class,
		NullCoalescingOperatorRector::class,
		ParenthesizeNestedTernaryRector::class,
		RealToFloatTypeCastRector::class,
		RestoreDefaultNullToNullableTypePropertyRector::class,
		AddParamBasedOnParentClassMethodRector::class,
		ChangeSwitchToMatchRector::class,
		ClassOnObjectRector::class,
		ClassOnThisVariableObjectRector::class,
		ClassPropertyAssignToConstructorPromotionRector::class,
		MixedTypeRector::class,
		RemoveUnusedVariableInCatchRector::class,
		SetStateToStaticRector::class,
		StrContainsRector::class,
		StrEndsWithRector::class,
		StrStartsWithRector::class,
		StringableForToStringRector::class,
		FirstClassCallableRector::class,
		VariableInStringInterpolationFixerRector::class,
		AddOverrideAttributeToOverriddenMethodsRector::class,
		AddTypeToConstRector::class,
		FinalizeTestCaseClassRector::class,
		DisallowedEmptyRuleFixerRector::class,
		AddClosureVoidReturnTypeWhereNoReturnRector::class,
		AddFunctionVoidReturnTypeWhereNoReturnRector::class,
		AddMethodCallBasedStrictParamTypeRector::class,
		AddParamTypeFromPropertyTypeRector::class,
		AddReturnTypeDeclarationBasedOnParentClassMethodRector::class,
		AddReturnTypeDeclarationFromYieldsRector::class,
		AddTestsVoidReturnTypeWhereNoReturnRector::class,
		ReturnNeverTypeRector::class,
		AddVoidReturnTypeWhereNoReturnRector::class,
		BoolReturnTypeFromStrictScalarReturnsRector::class,
		NumericReturnTypeFromStrictScalarReturnsRector::class,
		ParamTypeByMethodCallTypeRector::class,
		ParamTypeByParentCallTypeRector::class,
		PropertyTypeFromStrictSetterGetterRector::class,
		ReturnTypeFromReturnDirectArrayRector::class,
		ReturnTypeFromReturnNewRector::class,
		ReturnTypeFromStrictBoolReturnExprRector::class,
		ReturnTypeFromStrictConstantReturnRector::class,
		ReturnTypeFromStrictFluentReturnRector::class,
		ReturnTypeFromStrictNativeCallRector::class,
		ReturnTypeFromStrictNewArrayRector::class,
		ReturnTypeFromStrictParamRector::class,
		ReturnTypeFromStrictScalarReturnExprRector::class,
		ReturnTypeFromStrictTernaryRector::class,
		ReturnTypeFromStrictTypedCallRector::class,
		ReturnTypeFromStrictTypedPropertyRector::class,
		ReturnUnionTypeRector::class,
		StrictArrayParamDimFetchRector::class,
		StrictStringParamConcatRector::class,
		TypedPropertyFromStrictConstructorRector::class,
		TypedPropertyFromStrictSetUpRector::class,
		WhileNullableToInstanceofRector::class,
		ExplicitPublicClassMethodRector::class,
	])

	// Laravel Rules
	->withRules([
		EloquentWhereRelationTypeHintingParameterRector::class,
		EloquentOrderByToLatestOrOldestRector::class,
		AssertStatusToAssertMethodRector::class,
		EloquentWhereTypeHintClosureParameterRector::class,
		FactoryDefinitionRector::class,
		FactoryFuncCallToStaticCallRector::class,
		OptionalToNullsafeOperatorRector::class,
		RemoveDumpDataDeadCodeRector::class,
		RemoveModelPropertyFromFactoriesRector::class,
		ReplaceFakerInstanceWithHelperRector::class,
		RequestStaticValidateToInjectRector::class,
		RouteActionCallableRector::class,
		SubStrToStartsWithOrEndsWithStaticMethodCallRector::class,
		UnifyModelDatesWithCastsRector::class,
		ValidationRuleArrayStringValueToArrayRector::class,
		AddExtendsAnnotationToModelFactoriesRector::class,
		AddGenericReturnTypeToRelationsRector::class,
		AddParentBootToModelClassMethodRector::class,
		AddParentRegisterToEventServiceProviderRector::class,
		AnonymousMigrationsRector::class,
		AppEnvironmentComparisonToParameterRector::class,
		JsonCallToExplicitJsonCallRector::class,
		UseComponentPropertyWithinCommandsRector::class,
	])
	->withConfiguredRule(EloquentMagicMethodToQueryBuilderRector::class, [
		EloquentMagicMethodToQueryBuilderRector::EXCLUDE_METHODS => [
			'find',
			'findOrFail',
			'findMany',
			'findOrNew',
			'firstOrNew',
			'firstOrCreate',
			'createOrFirst',
			'updateOrCreate',
			'firstOrFail',
		]
	])

	// Custom Rules
	->withRules([
		//		UseLaravelCarbonRector::class,
		//		ChangeRequestCallToInputRector::class,
	])

	// Laravel Sets
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
	->withSkip([
		MigrateToSimplifiedAttributeRector::class,
		ModelCastsPropertyToCastsMethodRector::class,
		BooleanInIfConditionRuleFixerRector::class,
	]);
