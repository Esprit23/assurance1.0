<?php

namespace App\Entity;

use App\Repository\AssuranceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssuranceRepository::class)]
class Assurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $numOrdre = null;

    #[ORM\Column(length: 100)]
    private ?string $numPolice = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEffet = null;

    #[ORM\Column]
    private ?int $mois = null;

    #[ORM\ManyToOne(inversedBy: 'assurances')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'assurances')]
    private ?Vehicule $vehicule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumOrdre(): ?string
    {
        return $this->numOrdre;
    }

    public function setNumOrdre(string $numOrdre)
    {
        $this->numOrdre = $numOrdre;

        return $this;
    }

    public function getNumPolice(): ?string
    {
        return $this->numPolice;
    }

    public function setNumPolice(string $numPolice)
    {
        $this->numPolice = $numPolice;

        return $this;
    }

    public function getDateEffet(): ?\DateTimeInterface
    {
        return $this->dateEffet;
    }

    public function setDateEffet(\DateTimeInterface $dateEffet)
    {
        $this->dateEffet = $dateEffet;

        return $this;
    }

    public function getMois(): ?int
    {
        return $this->mois;
    }

    public function setMois(int $mois)
    {
        $this->mois = $mois;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client)
    {
        $this->client = $client;

        return $this;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule)
    {
        $this->vehicule = $vehicule;

        return $this;
    }
}
