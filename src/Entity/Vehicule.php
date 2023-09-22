<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $marque_type = null;

    #[ORM\Column(length: 50)]
    private ?string $numSerie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carosserie = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $puissance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEmission = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $usageVehicule = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $energie = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $place = null;

    #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Assurance::class)]
    private Collection $assurances;

    public function __construct()
    {
        $this->assurances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getMarqueType(): ?string
    {
        return $this->marque_type;
    }

    public function setMarqueType(string $marque_type)
    {
        $this->marque_type = $marque_type;

        return $this;
    }

    public function getNumSerie(): ?string
    {
        return $this->numSerie;
    }

    public function setNumSerie(string $numSerie)
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    public function getCarosserie(): ?string
    {
        return $this->carosserie;
    }

    public function setCarosserie(?string $carosserie)
    {
        $this->carosserie = $carosserie;

        return $this;
    }

    public function getPuissance(): ?string
    {
        return $this->puissance;
    }

    public function setPuissance(?string $puissance)
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeInterface $dateEmission)
    {
        $this->dateEmission = $dateEmission;

        return $this;
    }

    public function getUsageVehicule(): ?string
    {
        return $this->usageVehicule;
    }

    public function setUsageVehicule(?string $usageVehicule)
    {
        $this->usageVehicule = $usageVehicule;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(?string $energie)
    {
        $this->energie = $energie;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(int $place)
    {
        $this->place = $place;

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
            $assurance->setVehicule($this);
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance)
    {
        if ($this->assurances->removeElement($assurance)) {
            // set the owning side to null (unless already changed)
            if ($assurance->getVehicule() === $this) {
                $assurance->setVehicule(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getMatricule() . " -  " . $this->getMarqueType(); 
    }
}
