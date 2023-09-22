<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $numCompte = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPrenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Assurance::class)]
    private Collection $assurances;

    public function __construct()
    {
        $this->assurances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCompte(): ?string
    {
        return $this->numCompte;
    }

    public function setNumCompte(string $numCompte)
    {
        $this->numCompte = $numCompte;

        return $this;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom)
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Assurance>
     */
    public function getAssurances(): Collection
    {
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance)
    {
        if (!$this->assurances->contains($assurance)) {
            $this->assurances->add($assurance);
            $assurance->setClient($this);
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance)
    {
        if ($this->assurances->removeElement($assurance)) {
            // set the owning side to null (unless already changed)
            if ($assurance->getClient() === $this) {
                $assurance->setClient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNumCompte() . " -  " . $this->getNomPrenom(); 
    }
}
