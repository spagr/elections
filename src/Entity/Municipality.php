<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MunicipalityRepository;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[ORM\Entity(repositoryClass: MunicipalityRepository::class)]
#[Type]
class Municipality
{
    #[ORM\Id]
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 512)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: District::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\District $region = null;

    #[ORM\ManyToOne(targetEntity: District::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?\App\Entity\District $district = null;

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    #[Field]
    public function getId(): int
    {
        return $this->id;
    }

    #[Field]
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    #[Field]
    public function getRegion(): District
    {
        return $this->region;
    }

    public function setRegion(?District $region): self
    {
        $this->region = $region;

        return $this;
    }

    #[Field]
    public function getDistrict(): District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }
}
