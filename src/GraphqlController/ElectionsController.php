<?php

declare(strict_types=1);

namespace App\GraphqlController;

use App\Entity\Municipality;
use App\Entity\Party;
use App\Facade\ElectionResultsFacade;
use App\Repository\MunicipalityRepository;
use App\Repository\PartyRepository;
use TheCodingMachine\GraphQLite\Annotations\Query;

class ElectionsController
{
    public function __construct(
        private readonly PartyRepository $partyRepository,
        private readonly MunicipalityRepository $municipalityRepository,
        private readonly ElectionResultsFacade $electionResultsFacade,
    ) {
    }

    #[Query]
    /**
     * @return Party[]
     */
    public function getParty(string $name): array
    {
        return $this->partyRepository->findByName($name);
    }

    #[Query]
    /**
     * @return Municipality[]
     */
    public function getMunicipality(string $name): array
    {
        $municipalities = $this->municipalityRepository->findByName($name);
        $this->electionResultsFacade->prepareMunicipalitiesTotalVotes($municipalities);
        $this->electionResultsFacade->prepareMunicipalitiesPartiesVotes($municipalities);

        return $municipalities;
    }
}
