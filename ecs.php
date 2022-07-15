<?php

use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
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
use ECSPrefix202207\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

/**
 * @var                      ContainerConfigurator $containerConfigurator
 * @phpstan-ignore-next-line
 */
return static function(ContainerConfigurator $containerConfigurator): void {
	$services = $containerConfigurator->services();

	$containerConfigurator->import(SetList::PSR_12);

	$services->set(ArraySyntaxFixer::class)
		->call('configure', [
			[
				'syntax' => 'short',
			],
		]);

	$services->set(UnconditionalIfStatementSniff::class);
	$services->set(JumbledIncrementerSniff::class);
	$services->set(EmptyStatementSniff::class);
	$services->set(SpaceAfterCastSniff::class);
	$services->set(OpeningFunctionBraceBsdAllmanSniff::class);
	$services->set(FunctionCallArgumentSpacingSniff::class);
	$services->set(ConstructorNameSniff::class);
	$services->set(UpperCaseConstantNameSniff::class);
	$services->set(DisallowShortOpenTagSniff::class);
	$services->set(LowerCaseConstantSniff::class);
	$services->set(LowerCaseKeywordSniff::class);
	$services->set(NoSilencedErrorsSniff::class);
	$services->set(SyntaxSniff::class);
	$services->set(UnnecessaryStringConcatSniff::class);
	$services->set(DisallowSpaceIndentSniff::class);
	$services->set(ClassDeclarationSniff::class);
	$services->set(ValidClassNameSniff::class);
	$services->set(ScopeClosingBraceSniff::class);
	$services->set(CamelCapsMethodNameSniff::class);
	$services->set(PropertyDeclarationSniff::class);
	$services->set(ArrayBracketSpacingSniff::class);
	$services->set(ControlSignatureSniff::class);
	$services->set(LowercaseDeclarationSniff::class);
	$services->set(DisallowSizeFunctionsInLoopsSniff::class);
	$services->set(LowercasePHPFunctionsSniff::class);
	$services->set(NonExecutableCodeSniff::class);
	$services->set(ControlStructureSpacingSniff::class);
	$services->set(LanguageConstructSpacingSniff::class);
	$services->set(LogicalOperatorSpacingSniff::class);
	$services->set(ObjectOperatorSpacingSniff::class)->property('ignoreNewlines', true);
	$services->set(OperatorSpacingSniff::class);
	$services->set(PropertyLabelSpacingSniff::class);
	$services->set(SemicolonSpacingSniff::class);
	$services->set(ScopeKeywordSpacingSniff::class);
	$services->set(BinaryOperatorSpacesFixer::class)
		->call('configure', [
			[
				'operators' => [
					'=>' => BinaryOperatorSpacesFixer::ALIGN_SINGLE_SPACE_MINIMAL,
				],
			],
		]);

	$services->set(FunctionDeclarationFixer::class)
		->call('configure', [
			['closure_function_spacing' => FunctionDeclarationFixer::SPACING_NONE],
		]);

	$services->set(ForbiddenFunctionsSniff::class)
		->property(
			'forbiddenFunctions',
			[
				'eval'            => null,
				'dd'              => null,
				'die'             => null,
				'var_dump'        => null,
				'size_of'         => 'count',
				'print'           => 'echo',
				'create_function' => null,
			]
		);

	$services->set(ExplicitStringVariableFixer::class);
	$services->set(SingleQuoteFixer::class);

	$services->set(CommentedOutCodeSniff::class);
	$services->set(NoUnusedImportsFixer::class);

	$services->set(OrderedImportsFixer::class)
		->call('configure', [
			[
				'imports_order' => [
					OrderedImportsFixer::IMPORT_TYPE_CONST,
					OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
					OrderedImportsFixer::IMPORT_TYPE_CLASS,
				],
				'sort_algorithm' => OrderedImportsFixer::SORT_LENGTH,
			],
		]);


	$services->remove(NoBlankLinesAfterClassOpeningFixer::class);
	$services->remove(BracesFixer::class);

	$parameters = $containerConfigurator->parameters();
	$parameters->set(Option::PATHS, [
		getcwd() . '/app',
		getcwd() . '/tests',
		getcwd() . '/database',
		getcwd() . '/config',
	]);
	$parameters->set(Option::INDENTATION, 'tab');
	$parameters->set(Option::SKIP, []);
};
