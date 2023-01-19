<?php

namespace App\Entity;

use App\Repository\TypeMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeMaterielRepository::class)]
class TypeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_materiel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intitule_materiel = null;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'type_materiel_propose')]
    private Collection $fournisseurs;

    #[ORM\ManyToOne(inversedBy: 'typeMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tag $tag = null;

    public function __construct()
    {
        $this->fournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionMateriel(): ?string
    {
        return $this->description_materiel;
    }

    public function setDescriptionMateriel(?string $description_materiel): self
    {
        $this->description_materiel = $description_materiel;

        return $this;
    }

    public function getIntituleMateriel(): ?string
    {
        return $this->intitule_materiel;
    }

    public function setIntituleMateriel(?string $intitule_materiel): self
    {
        $this->intitule_materiel = $intitule_materiel;

        return $this;
    }

    /**
     * @return Collection<int, Fournisseur>
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->add($fournisseur);
            $fournisseur->addTypeMaterielPropose($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeTypeMaterielPropose($this);
        }

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
