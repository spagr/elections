<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Constant\CsvColumn;
use App\Entity\District;
use App\Entity\Municipality;
use App\Handler\FileHandler;
use App\Parser\CsvParser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Persistence\ObjectManager;
use OutOfBoundsException;

class MunicipalityFixtures extends Fixture implements DependentFixtureInterface
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
        $metadata = $manager->getClassMetaData(Municipality::class);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $rows = $this->csvParser->parseString(
            $this->fileHandler->getContent($this->fileUrl, FileHandler::TYPE_TEXT_CSV),
        );

        foreach ($rows as $key => $row) {
            try {
                /** @var District $region */
                $region = $this->getReference(DistrictFixtures::FIXTURE_REFERENCE . $row[CsvColumn::PSCOCO_KRAJ]);
                /** @var District $district */
                $district = $this->getReference(DistrictFixtures::FIXTURE_REFERENCE . $row[CsvColumn::PSCOCO_OKRES]);
            } catch (OutOfBoundsException) {
                continue;
            }

            $municipality = new Municipality();
            $municipality
                ->setId((int) $row[CsvColumn::PSCOCO_OBEC])
                ->setName((string) $row[CsvColumn::PSCOCO_NAZEVOBCE])
                ->setRegion($region)
                ->setDistrict($district)
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

    public function getDependencies()
    {
        return [
            DistrictFixtures::class,
        ];
    }
}
