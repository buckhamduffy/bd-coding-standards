<?php

use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocLineSpanFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTagCasingFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\Comment\CommentToPhpdocFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Alias\RandomApiMigrationFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedTraitsFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedInterfacesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\Operator\NoUselessConcatOperatorFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\Basic\NoMultipleStatementsPerLineFixer;
use PhpCsFixer\Fixer\Basic\NoTrailingCommaInSinglelineFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\Operator\NoSpaceAroundDoubleColonFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\SyntaxSniff;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypehintFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\ControlStructure\SimplifiedIfReturnFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBetweenImportGroupsFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\CommentedOutCodeSniff;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\NonExecutableCodeSniff;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAfterConstructFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\NoSilencedErrorsSniff;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\Classes\ClassDeclarationSniff;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\LowercasePHPFunctionsSniff;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowShortOpenTagSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\PropertyDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Arrays\ArrayBracketSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\OperatorSpacingSniff;
use PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\WhiteSpace\ScopeClosingBraceSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SemicolonSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeKeywordSpacingSniff;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\NamingConventions\ValidClassNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators\ValidLogicalOperatorsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\PropertyLabelSpacingSniff;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\WhiteSpace\DisallowSpaceIndentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\DisallowSizeFunctionsInLoopsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ObjectOperatorSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\JumbledIncrementerSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Strings\UnnecessaryStringConcatSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LogicalOperatorSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ControlSignatureSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ControlStructureSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\ConstructorNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LanguageConstructSpacingSniff;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\LowercaseDeclarationSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnconditionalIfStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\FunctionCallArgumentSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\OpeningFunctionBraceBsdAllmanSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;

return ECSConfig::configure()
	->withPaths(
		array_filter(
			[
				getcwd() . '/src',
				getcwd() . '/app',
				getcwd() . '/config',
			],
			fn (string $path) => file_exists($path) || is_dir($path)
		)
	)
	->withConfiguredRule(ArraySyntaxFixer::class, [
		'syntax' => 'short',
	])
	->withRules([
		AlignMultilineCommentFixer::class,
		ArrayBracketSpacingSniff::class,
		ArrayIndentationFixer::class,
		AssignNullCoalescingToCoalesceEqualFixer::class,
		BlankLineAfterNamespaceFixer::class,
		BlankLineAfterOpeningTagFixer::class,
		CamelCapsMethodNameSniff::class,
		ClassDeclarationSniff::class,
		ClassReferenceNameCasingFixer::class,
		CleanNamespaceFixer::class,
		CombineConsecutiveIssetsFixer::class,
		CommentToPhpdocFixer::class,
		CompactNullableTypehintFixer::class,
		ConstantCaseFixer::class,
		ConstructorNameSniff::class,
		ControlSignatureSniff::class,
		ControlStructureBracesFixer::class,
		ControlStructureContinuationPositionFixer::class,
		ControlStructureSpacingSniff::class,
		DeclareParenthesesFixer::class,
		DisallowShortOpenTagSniff::class,
		DisallowSizeFunctionsInLoopsSniff::class,
		DisallowSpaceIndentSniff::class,
		ElseifFixer::class,
		EmptyStatementSniff::class,
		EncodingFixer::class,
		ExplicitIndirectVariableFixer::class,
		FullOpeningTagFixer::class,
		FullyQualifiedStrictTypesFixer::class,
		FunctionCallArgumentSpacingSniff::class,
		FunctionToConstantFixer::class,
		FunctionTypehintSpaceFixer::class,
		GlobalNamespaceImportFixer::class,
		IncludeFixer::class,
		IncrementStyleFixer::class,
		IntegerLiteralCaseFixer::class,
		JumbledIncrementerSniff::class,
		LambdaNotUsedImportFixer::class,
		LanguageConstructSpacingSniff::class,
		ListSyntaxFixer::class,
		LogicalOperatorSpacingSniff::class,
		LowerCaseConstantSniff::class,
		LowerCaseKeywordSniff::class,
		LowercaseCastFixer::class,
		LowercaseDeclarationSniff::class,
		LowercaseKeywordsFixer::class,
		LowercasePHPFunctionsSniff::class,
		MagicConstantCasingFixer::class,
		MagicMethodCasingFixer::class,
		MethodChainingIndentationFixer::class,
		ModernizeStrposFixer::class,
		ModernizeTypesCastingFixer::class,
		MultilineWhitespaceBeforeSemicolonsFixer::class,
		NativeConstantInvocationFixer::class,
		NativeFunctionInvocationFixer::class,
		NewWithBracesFixer::class,
		NoAlternativeSyntaxFixer::class,
		NoBlankLinesAfterPhpdocFixer::class,
		NoBreakCommentFixer::class,
		NoClosingTagFixer::class,
		NoEmptyCommentFixer::class,
		NoEmptyPhpdocFixer::class,
		NoExtraBlankLinesFixer::class,
		NoMultilineWhitespaceAroundDoubleArrowFixer::class,
		NoMultipleStatementsPerLineFixer::class,
		NoNullPropertyInitializationFixer::class,
		NoShortBoolCastFixer::class,
		NoSilencedErrorsSniff::class,
		NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
		NoSpaceAroundDoubleColonFixer::class,
		NoSpacesAfterFunctionNameFixer::class,
		NoSpacesAroundOffsetFixer::class,
		NoSpacesInsideParenthesisFixer::class,
		NoSuperfluousElseifFixer::class,
		NoSuperfluousPhpdocTagsFixer::class,
		NoTrailingCommaInSinglelineFixer::class,
		NoTrailingWhitespaceInCommentFixer::class,
		NoUnneededImportAliasFixer::class,
		NoUnsetCastFixer::class,
		NoUselessConcatOperatorFixer::class,
		NoUselessElseFixer::class,
		NoUselessNullsafeOperatorFixer::class,
		NoUselessReturnFixer::class,
		NoUselessSprintfFixer::class,
		NoWhitespaceBeforeCommaInArrayFixer::class,
		NoWhitespaceInBlankLineFixer::class,
		NonExecutableCodeSniff::class,
		NonPrintableCharacterFixer::class,
		NormalizeIndexBraceFixer::class,
		NullableTypeDeclarationForDefaultNullValueFixer::class,
		ObjectOperatorWithoutWhitespaceFixer::class,
		OpeningFunctionBraceBsdAllmanSniff::class,
		OperatorLinebreakFixer::class,
		OperatorSpacingSniff::class,
		OrderedInterfacesFixer::class,
		OrderedTraitsFixer::class,
		PhpUnitConstructFixer::class,
		PhpUnitDedicateAssertInternalTypeFixer::class,
		PhpUnitMethodCasingFixer::class,
		PhpdocIndentFixer::class,
		PhpdocScalarFixer::class,
		PhpdocTagCasingFixer::class,
		PhpdocTrimConsecutiveBlankLineSeparationFixer::class,
		PhpdocTypesFixer::class,
		PhpdocTypesOrderFixer::class,
		PropertyDeclarationSniff::class,
		PropertyLabelSpacingSniff::class,
		RandomApiMigrationFixer::class,
		ReturnAssignmentFixer::class,
		ReturnTypeDeclarationFixer::class,
		ScopeClosingBraceSniff::class,
		ScopeKeywordSpacingSniff::class,
		SelfStaticAccessorFixer::class,
		SemicolonSpacingSniff::class,
		ShortScalarCastFixer::class,
		SimplifiedIfReturnFixer::class,
		SingleBlankLineAtEofFixer::class,
		SingleBlankLineBeforeNamespaceFixer::class,
		SingleClassElementPerStatementFixer::class,
		SingleImportPerStatementFixer::class,
		SingleLineCommentSpacingFixer::class,
		SingleLineCommentStyleFixer::class,
		SingleQuoteFixer::class,
		SingleSpaceAfterConstructFixer::class,
		SpaceAfterCastSniff::class,
		SpaceAfterSemicolonFixer::class,
		StandardizeIncrementFixer::class,
		SwitchCaseSemicolonToColonFixer::class,
		SwitchCaseSpaceFixer::class,
		SwitchContinueToBreakFixer::class,
		SyntaxSniff::class,
		TernaryOperatorSpacesFixer::class,
		TernaryToElvisOperatorFixer::class,
		TernaryToNullCoalescingFixer::class,
		TrimArraySpacesFixer::class,
		UnaryOperatorSpacesFixer::class,
		UnconditionalIfStatementSniff::class,
		UnnecessaryStringConcatSniff::class,
		UpperCaseConstantNameSniff::class,
		ValidClassNameSniff::class,
		VisibilityRequiredFixer::class,
		VoidReturnFixer::class,
		WhitespaceAfterCommaInArrayFixer::class,
		BlankLineBeforeStatementFixer::class,
		BlankLineBetweenImportGroupsFixer::class,
		CommentedOutCodeSniff::class,
		ExplicitStringVariableFixer::class,
		IndentationTypeFixer::class,
		NoUnusedImportsFixer::class,
		PhpdocAlignFixer::class,
		StatementIndentationFixer::class,
		ValidLogicalOperatorsSniff::class,
	])
	->withConfiguredRule(BinaryOperatorSpacesFixer::class, [
		'operators' => [
			'=>' => BinaryOperatorSpacesFixer::ALIGN_SINGLE_SPACE_MINIMAL,
		],
	])
	->withConfiguredRule(FunctionDeclarationFixer::class, ['closure_function_spacing' => FunctionDeclarationFixer::SPACING_NONE])
	->withConfiguredRule(ForbiddenFunctionsSniff::class, [
		'forbiddenFunctions' => [
			'eval'            => null,
			'dd'              => null,
			'die'             => null,
			'var_dump'        => null,
			'size_of'         => 'count',
			'print'           => 'echo',
			'create_function' => null,
			'dump'            => null,
			'ray'             => null,
		]
	])
	->withConfiguredRule(ObjectOperatorSpacingSniff::class, [
		'ignoreNewlines' => true,
	])

	->withConfiguredRule(PhpdocLineSpanFixer::class, [
		'const'    => 'single',
		'property' => 'single',
		'method'   => 'multi',
	])
	->withConfiguredRule(OrderedImportsFixer::class, [
		'imports_order' => [
			OrderedImportsFixer::IMPORT_TYPE_CONST,
			OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
			OrderedImportsFixer::IMPORT_TYPE_CLASS,
		],
		'sort_algorithm' => OrderedImportsFixer::SORT_LENGTH,
	])
	->withConfiguredRule(ClassAttributesSeparationFixer::class, [
		'elements' => [
			'const'        => ClassAttributesSeparationFixer::SPACING_NONE,
			'method'       => ClassAttributesSeparationFixer::SPACING_ONE,
			'property'     => ClassAttributesSeparationFixer::SPACING_NONE,
			'trait_import' => ClassAttributesSeparationFixer::SPACING_NONE,
			'case'         => ClassAttributesSeparationFixer::SPACING_NONE
		]
	])
	->withSpacing(Option::INDENTATION_TAB)
	->withSkip([
		NoBlankLinesAfterClassOpeningFixer::class,
		OpeningFunctionBraceBsdAllmanSniff::class
	]);
