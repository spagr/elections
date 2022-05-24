<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Constant\CsvColumn;
use App\Entity\Party;
use App\Handler\FileHandler;
use App\Parser\CsvParser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;

class PartyFixtures extends Fixture
{
    public function __construct(
        private readonly FileHandler $fileHandler,
        private readonly CsvParser $csvParser,
        private readonly string $fileUrl,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        /** @var ClassMetadataInfo $metadata */
        $metadata = $manager->getClassMetaData(Party::class);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $rows = $this->csvParser->parseString(
            $this->fileHandler->getContent($this->fileUrl, FileHandler::TYPE_TEXT_CSV),
        );

        foreach ($rows as $key => $row) {
            $municipality = new Party();
            $municipality
                ->setId((int) $row[CsvColumn::PSRKL_KSTRANA])
                ->setName((string) $row[CsvColumn::PSRKL_NAZEVCELK])
                ->setAbbreviation((string) $row[CsvColumn::PSRKL_ZKRATKAK8])
            ;

            $manager->persist($municipality);

            if ($key % 1000 === 0) {
                $manager->flush();
                // prevent low memory issue
                $manager->clear();
            }
        }

        $manager->flush();
    }
}
