<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DistrictRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[ORM\Entity(repositoryClass: DistrictRepository::class)]
#[Type]
class District
{
    public \Doctrine\Common\Collections\ArrayCollection $municipalities;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    private ?string $code = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    private ?int $code2 = null;

    public function __construct()
    {
        $this->municipalities = new ArrayCollection();
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    #[Field]
    public function getId(): ?int
    {
        return $this->id;
    }

    #[Field]
    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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
    public function getCode2(): ?int
    {
        return $this->code2;
    }

    public function setCode2(int $code2): self
    {
        $this->code2 = $code2;

        return $this;
    }
}
