<?php

use PhpCsFixer\Fixer\Basic\BracesFixer;
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
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Basic\CurlyBracesPositionFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
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
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
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
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
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

/**
 * @phpstan-ignore-next-line
 */
return static function(ECSConfig $config): void {
	$config->sets([SetList::PSR_12]);

	$config->ruleWithConfiguration(ArraySyntaxFixer::class, [
		'syntax' => 'short',
	]);

	$config->rule(UnconditionalIfStatementSniff::class);
	$config->rule(JumbledIncrementerSniff::class);
	$config->rule(EmptyStatementSniff::class);
	$config->rule(SpaceAfterCastSniff::class);
	$config->rule(OpeningFunctionBraceBsdAllmanSniff::class);
	$config->rule(FunctionCallArgumentSpacingSniff::class);
	$config->rule(ConstructorNameSniff::class);
	$config->rule(UpperCaseConstantNameSniff::class);
	$config->rule(DisallowShortOpenTagSniff::class);
	$config->rule(LowerCaseConstantSniff::class);
	$config->rule(LowerCaseKeywordSniff::class);
	$config->rule(NoSilencedErrorsSniff::class);
	$config->rule(SyntaxSniff::class);
	$config->rule(UnnecessaryStringConcatSniff::class);
	$config->rule(DisallowSpaceIndentSniff::class);
	$config->rule(ClassDeclarationSniff::class);
	$config->rule(ValidClassNameSniff::class);
	$config->rule(ScopeClosingBraceSniff::class);
	$config->rule(CamelCapsMethodNameSniff::class);
	$config->rule(PropertyDeclarationSniff::class);
	$config->rule(ArrayBracketSpacingSniff::class);
	$config->rule(ControlSignatureSniff::class);
	$config->rule(LowercaseDeclarationSniff::class);
	$config->rule(DisallowSizeFunctionsInLoopsSniff::class);
	$config->rule(LowercasePHPFunctionsSniff::class);
	$config->rule(NonExecutableCodeSniff::class);
	$config->rule(ControlStructureSpacingSniff::class);
	$config->rule(LanguageConstructSpacingSniff::class);
	$config->rule(LogicalOperatorSpacingSniff::class);
	$config->ruleWithConfiguration(ObjectOperatorSpacingSniff::class, [
		'ignoreNewlines' => true,
	]);
	$config->rule(OperatorSpacingSniff::class);
	$config->rule(PropertyLabelSpacingSniff::class);
	$config->rule(SemicolonSpacingSniff::class);
	$config->rule(ScopeKeywordSpacingSniff::class);

	$config->rules([

		NoSuperfluousPhpdocTagsFixer::class,
		FullyQualifiedStrictTypesFixer::class,
		GlobalNamespaceImportFixer::class,
		NoUnneededImportAliasFixer::class,
		SingleImportPerStatementFixer::class,
		PhpdocScalarFixer::class,
		NoUselessReturnFixer::class,
		UnaryOperatorSpacesFixer::class,
		NoSuperfluousElseifFixer::class,
		ModernizeStrposFixer::class,
		RandomApiMigrationFixer::class,
		NoMultilineWhitespaceAroundDoubleArrowFixer::class,
		NoWhitespaceBeforeCommaInArrayFixer::class,
		NormalizeIndexBraceFixer::class,
		TrimArraySpacesFixer::class,
		WhitespaceAfterCommaInArrayFixer::class,
		EncodingFixer::class,
		NoMultipleStatementsPerLineFixer::class,
		NoTrailingCommaInSinglelineFixer::class,
		NonPrintableCharacterFixer::class,
		ClassReferenceNameCasingFixer::class,
		ConstantCaseFixer::class,
		IntegerLiteralCaseFixer::class,
		LowercaseKeywordsFixer::class,
		MagicMethodCasingFixer::class,
		LowercaseCastFixer::class,
		ModernizeTypesCastingFixer::class,
		NoShortBoolCastFixer::class,
		NoUnsetCastFixer::class,
		ShortScalarCastFixer::class,
		NoNullPropertyInitializationFixer::class,
		SelfStaticAccessorFixer::class,
		SingleClassElementPerStatementFixer::class,
		CommentToPhpdocFixer::class,
		NoEmptyCommentFixer::class,
		NoTrailingWhitespaceInCommentFixer::class,
		SingleLineCommentSpacingFixer::class,
		SingleLineCommentStyleFixer::class,
		NativeConstantInvocationFixer::class,
		ControlStructureBracesFixer::class,
		ControlStructureContinuationPositionFixer::class,
		ElseifFixer::class,
		IncludeFixer::class,
		NoAlternativeSyntaxFixer::class,
		NoBreakCommentFixer::class,
		SimplifiedIfReturnFixer::class,
		SwitchCaseSemicolonToColonFixer::class,
		SwitchCaseSpaceFixer::class,
		SwitchContinueToBreakFixer::class,
		FunctionTypehintSpaceFixer::class,
		LambdaNotUsedImportFixer::class,
		NoSpacesAfterFunctionNameFixer::class,
		NullableTypeDeclarationForDefaultNullValueFixer::class,
		NoUselessSprintfFixer::class,
		ReturnTypeDeclarationFixer::class,
		VoidReturnFixer::class,
		CombineConsecutiveIssetsFixer::class,
		DeclareParenthesesFixer::class,
		SingleSpaceAfterConstructFixer::class,
		ListSyntaxFixer::class,
		BlankLineAfterNamespaceFixer::class,
		CleanNamespaceFixer::class,
		SingleBlankLineBeforeNamespaceFixer::class,
		AssignNullCoalescingToCoalesceEqualFixer::class,
		IncrementStyleFixer::class,
		NoSpaceAroundDoubleColonFixer::class,
		NoUselessConcatOperatorFixer::class,
		NoUselessNullsafeOperatorFixer::class,
		ObjectOperatorWithoutWhitespaceFixer::class,
		OperatorLinebreakFixer::class,
		TernaryOperatorSpacesFixer::class,
		TernaryToElvisOperatorFixer::class,
		TernaryToNullCoalescingFixer::class,
		BlankLineAfterOpeningTagFixer::class,
		FullOpeningTagFixer::class,
		NoClosingTagFixer::class,
		PhpUnitConstructFixer::class,
		PhpUnitDedicateAssertInternalTypeFixer::class,
		AlignMultilineCommentFixer::class,
		NoBlankLinesAfterPhpdocFixer::class,
		NoEmptyPhpdocFixer::class,
		PhpdocAlignFixer::class,
		PhpdocIndentFixer::class,
		PhpdocTagCasingFixer::class,
		PhpdocTrimConsecutiveBlankLineSeparationFixer::class,
		PhpdocTypesFixer::class,
		PhpdocTypesOrderFixer::class,
		ReturnAssignmentFixer::class,
		MultilineWhitespaceBeforeSemicolonsFixer::class,
		NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
		SpaceAfterSemicolonFixer::class,
		ArrayIndentationFixer::class,
		CompactNullableTypehintFixer::class,
		MethodChainingIndentationFixer::class,
		NoExtraBlankLinesFixer::class,
		NoSpacesAroundOffsetFixer::class,
		NoSpacesInsideParenthesisFixer::class,
		SingleBlankLineAtEofFixer::class,
		NoWhitespaceInBlankLineFixer::class,
		StatementIndentationFixer::class,
		PhpUnitMethodCasingFixer::class,
		FunctionToConstantFixer::class,
		ExplicitStringVariableFixer::class,
		ExplicitIndirectVariableFixer::class,
		NewWithBracesFixer::class,
		StandardizeIncrementFixer::class,
		MagicConstantCasingFixer::class,
		NoUselessElseFixer::class,
		SingleQuoteFixer::class,
		VisibilityRequiredFixer::class,
		OrderedTraitsFixer::class,
		OrderedInterfacesFixer::class,
	]);

	$config->ruleWithConfiguration(BinaryOperatorSpacesFixer::class, [
		'operators' => [
			'=>' => BinaryOperatorSpacesFixer::ALIGN_SINGLE_SPACE_MINIMAL,
		],
	]);

	$config->ruleWithConfiguration(FunctionDeclarationFixer::class, ['closure_function_spacing' => FunctionDeclarationFixer::SPACING_NONE]);

	$config->ruleWithConfiguration(ForbiddenFunctionsSniff::class, [
		'forbiddenFunctions' => [
			'eval'            => null,
			'dd'              => null,
			'die'             => null,
			'var_dump'        => null,
			'size_of'         => 'count',
			'print'           => 'echo',
			'create_function' => null,
		]
	]);

	$config->rule(ExplicitStringVariableFixer::class);
	$config->rule(SingleQuoteFixer::class);

	$config->rule(CommentedOutCodeSniff::class);
	$config->rule(NoUnusedImportsFixer::class);

	$config->ruleWithConfiguration(OrderedImportsFixer::class, [
		'imports_order'  => [
			OrderedImportsFixer::IMPORT_TYPE_CONST,
			OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
			OrderedImportsFixer::IMPORT_TYPE_CLASS,
		],
		'sort_algorithm' => OrderedImportsFixer::SORT_LENGTH,
	]);

	$config->paths([
		getcwd() . '/app',
		getcwd() . '/tests',
		getcwd() . '/database',
		getcwd() . '/config',
	]);

	$config->indentation('tab');
	$config->skip([NoBlankLinesAfterClassOpeningFixer::class, \PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\OpeningFunctionBraceBsdAllmanSniff::class]);
};
