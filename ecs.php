<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $parameters = $ecsConfig->parameters();
    $services = $ecsConfig->services();

    $ecsConfig->import(SetList::ARRAY);
    $ecsConfig->import(SetList::CLEAN_CODE);
    $ecsConfig->import(SetList::COMMON);
    $ecsConfig->import(SetList::COMMENTS);
    $ecsConfig->import(SetList::CONTROL_STRUCTURES);
    $ecsConfig->import(SetList::DOCBLOCK);
    $ecsConfig->import(SetList::DOCTRINE_ANNOTATIONS);
    $ecsConfig->import(SetList::NAMESPACES);
    $ecsConfig->import(SetList::PHP_CS_FIXER);
    $ecsConfig->import(SetList::PHPUNIT);
    $ecsConfig->import(SetList::PSR_12);
    $ecsConfig->import(SetList::SPACES);
    $ecsConfig->import(SetList::STRICT);
    $ecsConfig->import(SetList::SYMFONY);

    $parameters->set(Option::PARALLEL, true);

    $parameters->set(Option::SKIP, [
        YodaStyleFixer::class,
        ArrayListItemNewlineFixer::class => [
            __DIR__ . '/src/DataFixtures/*Fixtures.php'
        ]
    ]);

    $services->set(PhpdocTypesOrderFixer::class)
        ->call('configure', [[
            'null_adjustment' => 'always_last', 'sort_algorithm' => 'none'
        ]]);
    $services->set(LineLengthFixer::class)
        ->call('configure', [[
            LineLengthFixer::INLINE_SHORT_LINES => false,
        ]]);
    $services->set(TrailingCommaInMultilineFixer::class)
        ->call('configure', [[
            'elements' => ['arrays', 'arguments', 'parameters']
        ]]);
    $services->set(ConcatSpaceFixer::class)
        ->call('configure', [[
            'spacing' => 'one',
        ]]);
};