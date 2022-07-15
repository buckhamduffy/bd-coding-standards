<?php

use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\SyntaxSniff;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\CommentedOutCodeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\NonExecutableCodeSniff;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\NoSilencedErrorsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\PHP\LowercasePHPFunctionsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\DisallowShortOpenTagSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Methods\CamelCapsMethodNameSniff;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\Classes\PropertyDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Arrays\ArrayBracketSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\OperatorSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\WhiteSpace\ScopeClosingBraceSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SemicolonSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeKeywordSpacingSniff;
use PHP_CodeSniffer\Standards\PEAR\Sniffs\NamingConventions\ValidClassNameSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\PropertyLabelSpacingSniff;
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
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\LowercaseDeclarationSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnconditionalIfStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\FunctionCallArgumentSpacingSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\OpeningFunctionBraceBsdAllmanSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;

/**
 * @phpstan-ignore-next-line
 */
return static function (ECSConfig $config): void {
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

	$config->ruleWithConfiguration(BinaryOperatorSpacesFixer::class, [
		'operators' => [
			'=>' => BinaryOperatorSpacesFixer::ALIGN_SINGLE_SPACE_MINIMAL,
		],
	]);

	$config->ruleWithConfiguration(FunctionDeclarationFixer::class, ['closure_function_spacing' => FunctionDeclarationFixer::SPACING_NONE]);

	$config->ruleWithConfiguration(ForbiddenFunctionsSniff::class, [
		'forbiddenFunctions' => [
			'eval' => null,
			'dd' => null,
			'die' => null,
			'var_dump' => null,
			'size_of' => 'count',
			'print' => 'echo',
			'create_function' => null,
		]
	]);

	$config->rule(ExplicitStringVariableFixer::class);
	$config->rule(SingleQuoteFixer::class);

	$config->rule(CommentedOutCodeSniff::class);
	$config->rule(NoUnusedImportsFixer::class);

	$config->ruleWithConfiguration(OrderedImportsFixer::class, [
		'imports_order' => [
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
	$config->skip([NoBlankLinesAfterClassOpeningFixer::class, BracesFixer::class]);
};
