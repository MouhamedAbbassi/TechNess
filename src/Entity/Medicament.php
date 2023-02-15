<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicamentRepository::class)]
class Medicament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'medicament', targetEntity: OrdonnanceMedicament::class)]
    private Collection $ordonnanceMedicaments;



    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
        $this->ordonnanceMedicaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): self
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }

    /**
     * @return Collection<int, OrdonnanceMedicament>
     */
    public function getOrdonnanceMedicaments(): Collection
    {
        return $this->ordonnanceMedicaments;
    }

    public function addOrdonnanceMedicament(OrdonnanceMedicament $ordonnanceMedicament): self
    {
        if (!$this->ordonnanceMedicaments->contains($ordonnanceMedicament)) {
            $this->ordonnanceMedicaments->add($ordonnanceMedicament);
            $ordonnanceMedicament->setMedicament($this);
        }

        return $this;
    }

    public function removeOrdonnanceMedicament(OrdonnanceMedicament $ordonnanceMedicament): self
    {
        if ($this->ordonnanceMedicaments->removeElement($ordonnanceMedicament)) {
            // set the owning side to null (unless already changed)
            if ($ordonnanceMedicament->getMedicament() === $this) {
                $ordonnanceMedicament->setMedicament(null);
            }
        }

        return $this;
    }


}
