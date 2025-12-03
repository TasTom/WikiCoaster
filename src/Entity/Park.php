<?php

namespace App\Entity;

use App\Repository\ParkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParkRepository::class)]
class Park
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    private ?int $openingYeaar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getOpeningYeaar(): ?int
    {
        return $this->openingYeaar;
    }

    public function setOpeningYeaar(?int $openingYeaar): static
    {
        $this->openingYeaar = $openingYeaar;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }

}
