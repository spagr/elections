<?php

declare(strict_types=1);

namespace App\Facade;

use App\Constant\CsvColumn;
use App\Entity\Municipality;
use App\Handler\FileHandler;
use App\Parser\CsvParser;
use App\Storage\ResultStorage;

class ElectionResultsFacade
{
    public function __construct(
        private readonly ResultStorage $resultStorage,
        private readonly FileHandler $fileHandler,
        private readonly CsvParser $csvParser,
        private readonly string $pst4FileUrl,
        private readonly string $pst4PFileUrl,
    ) {
    }

    /**
     * @param Municipality[] $municipalities
     */
    public function prepareMunicipalitiesTotalVotes(array $municipalities): void
    {
        $result = [];
        $ids = array_map(fn (Municipality $municipality): int => $municipality->getId(), $municipalities);

        foreach ($this->getTotalVotes() as $row) {
            if (in_array((int) $row[CsvColumn::T4_OBEC], $ids, true)) {
                $result[(int) $row[CsvColumn::T4_OBEC]][] = (int) $row[CsvColumn::T4_PL_HL_CELK];
            }
        }

        $this->resultStorage->setCountedTotalVotes(array_map(fn (array $votes): int => array_sum($votes), $result));
    }

    /**
     * @param Municipality[] $municipalities
     */
    public function prepareMunicipalitiesPartiesVotes(array $municipalities): void
    {
        $result = [];
        $ids = array_map(fn (Municipality $municipality): int => $municipality->getId(), $municipalities);

        foreach ($this->getPartiesVotes() as $row) {
            if (in_array((int) $row[CsvColumn::T4P_OBEC], $ids, true)) {
                $result[(int) $row[CsvColumn::T4P_OBEC]][(int) $row[CsvColumn::T4P_KSTRANA]][] = (int) $row[CsvColumn::T4P_POC_HLASU];
            }
        }

        dump($result);

        $this->resultStorage->setCountedPartiesVotes(
            array_map(
                fn (array $parties): array => array_map(fn (array $votes): int => array_sum($votes), $parties),
                $result,
            ),
        );

        dump($this->resultStorage->getCountedPartiesVotes());
    }

    private function getTotalVotes(): array
    {
        if ($this->resultStorage->hasTotalVotes()) {
            return $this->resultStorage->getTotalVotes();
        }

        $this->resultStorage->setTotalVotes($this->csvParser->parseString(
            $this->fileHandler->getContent($this->pst4FileUrl, FileHandler::TYPE_ZIP),
            true,
            CsvColumn::COLUMNS_FILTER_T4,
        ));

        return $this->resultStorage->getTotalVotes();
    }

    private function getPartiesVotes(): array
    {
        if ($this->resultStorage->hasPartiesVotes()) {
            return $this->resultStorage->getPartiesVotes();
        }

        $this->resultStorage->setPartiesVotes($this->csvParser->parseString(
            $this->fileHandler->getContent($this->pst4PFileUrl, FileHandler::TYPE_ZIP),
            true,
            CsvColumn::COLUMNS_FILTER_T4P,
        ));

        return $this->resultStorage->getPartiesVotes();
    }
}
