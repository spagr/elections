<?php

declare(strict_types=1);

namespace App\Storage;

class ResultStorage
{
    private array $totalVotes = [];

    private array $partiesVotes = [];

    private array $countedTotalVotes = [];

    private array $countedPartiesVotes = [];

    public function hasTotalVotes(): bool
    {
        return $this->totalVotes !== [];
    }

    public function getTotalVotes(): array
    {
        return $this->totalVotes;
    }

    public function setTotalVotes(array $totalVotes): void
    {
        $this->totalVotes = $totalVotes;
    }

    public function hasPartiesVotes(): bool
    {
        return $this->partiesVotes !== [];
    }

    public function getPartiesVotes(): array
    {
        return $this->partiesVotes;
    }

    public function setPartiesVotes(array $partiesVotes): void
    {
        $this->partiesVotes = $partiesVotes;
    }

    public function getCountedTotalVotes(): array
    {
        return $this->countedTotalVotes;
    }

    public function setCountedTotalVotes(array $countedTotalVotes): void
    {
        $this->countedTotalVotes = $countedTotalVotes;
    }

    public function getCountedPartiesVotes(): array
    {
        return $this->countedPartiesVotes;
    }

    public function setCountedPartiesVotes(array $countedPartiesVotes): void
    {
        $this->countedPartiesVotes = $countedPartiesVotes;
    }
}
