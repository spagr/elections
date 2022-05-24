<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PartyRepository;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
#[Type]
class Party
{
    #[ORM\Id]
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 512)]
    private string $name;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255, nullable: true)]
    private string $abbreviation;

    private float $percentageResult;

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Field]
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    #[Field]
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param mixed $abbreviation
     */
    public function setAbbreviation($abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    #[Field]
    public function getPercentageResult(): float
    {
        return $this->percentageResult;
    }

    public function setPercentageResult(float $percentageResult): void
    {
        $this->percentageResult = $percentageResult;
    }
}
