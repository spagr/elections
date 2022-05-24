<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Constant\CsvColumn;
use App\Entity\District;
use App\Handler\FileHandler;
use App\Parser\CsvParser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;

class DistrictFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var string
     */
    final public const FIXTURE_REFERENCE = 'district-';

    public function __construct(
        private readonly FileHandler $fileHandler,
        private readonly CsvParser $csvParser,
        private readonly string $fileUrl,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        /** @var ClassMetadataInfo $metadata */
        $metadata = $manager->getClassMetaData(District::class);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $rows = $this->csvParser->parseString(
            $this->fileHandler->getContent($this->fileUrl, FileHandler::TYPE_TEXT_CSV),
        );

        foreach ($rows as $key => $row) {
            $municipality = new District();
            $municipality
                ->setId((int) $row[CsvColumn::CNUMNUTS_NUMNUTS])
                ->setCode((string) $row[CsvColumn::CNUMNUTS_NUTS])
                ->setName((string) $row[CsvColumn::CNUMNUTS_NAZEVNUTS])
                ->setCode2((int) $row[CsvColumn::CNUMNUTS_KODCIS])
            ;

            $manager->persist($municipality);
            $this->addReference(self::FIXTURE_REFERENCE . $municipality->getId(), $municipality);

            if ($key % 1000 === 0) {
                $manager->flush();
                // prevent low memory issue
                $manager->clear();
            }
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            'district',
        ];
    }
}
