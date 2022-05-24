<?php

declare(strict_types=1);

namespace App\Type;

use App\Entity\Municipality;
use App\Entity\Party;
use App\Repository\PartyRepository;
use App\Storage\ResultStorage;
use TheCodingMachine\GraphQLite\Annotations\ExtendType;
use TheCodingMachine\GraphQLite\Annotations\Field;

#[ExtendType(class: Municipality::class)]
class MunicipalityType
{
    public function __construct(
        private readonly ResultStorage $resultStorage,
        private readonly PartyRepository $partyRepository,
    ) {
    }

    #[Field]
    public function getTotalVotes(Municipality $municipality): int
    {
        return $this->resultStorage->getCountedTotalVotes()[$municipality->getId()];
    }

    #[Field]
    /**
     * @return Party[]
     */
    public function getPartiesVotes(Municipality $municipality): array
    {
        $totalVotes = $this->resultStorage->getCountedTotalVotes()[$municipality->getId()];
        $votes = $this->resultStorage->getCountedPartiesVotes()[$municipality->getId()];
        $parties = $this->partyRepository->findByIds(array_keys($votes));

        foreach ($parties as $party) {
            $party->setPercentageResult(round($votes[$party->getId()] / ($totalVotes / 100), 2));
        }

        usort($parties, fn (Party $a, Party $b) => $b->getPercentageResult() <=> $a->getPercentageResult());

        return $parties;
    }
}
