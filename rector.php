<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PostRector\Rector\NameImportingPostRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();

    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    // Define what rule sets will be applied
    $rectorConfig->import(SetList::CODING_STYLE);
    $rectorConfig->import(SetList::CODE_QUALITY);
    $rectorConfig->import(SetList::DEAD_CODE);

    $rectorConfig->import(LevelSetList::UP_TO_PHP_81);
    $rectorConfig->import(DoctrineSetList::DOCTRINE_CODE_QUALITY);
    $rectorConfig->import(DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES);

    // get services (needed for register a single rule)
    $services = $rectorConfig->services();

    // register a single rule
    $services->set(TypedPropertyRector::class);
    $services->set(NewlineAfterStatementRector::class);
    $services->set(NameImportingPostRector::class);

    $rectorConfig->skip([
        RemoveUnusedPromotedPropertyRector::class => [
            __DIR__ . '/src/Controller/HomepageController.php',
        ],
        VarConstantCommentRector::class => [
            __DIR__ . '/src/Constant/*.php',
        ],

        UnSpreadOperatorRector::class => [
            __DIR__ . '/src/DataProvider/DataProviderFactory.php'
        ]
    ]);
};
