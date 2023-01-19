<?php

namespace App\Entity;

use App\Repository\TypeServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeServiceRepository::class)]
class TypeService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intitule_service = null;

    #[ORM\ManyToMany(targetEntity: Fournisseur::class, mappedBy: 'type_service_propose')]
    private Collection $fournisseurs;

    #[ORM\ManyToOne(inversedBy: 'typeServices')]
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

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(?string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getIntituleService(): ?string
    {
        return $this->intitule_service;
    }

    public function setIntituleService(?string $intitule_service): self
    {
        $this->intitule_service = $intitule_service;

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
            $fournisseur->addTypeServicePropose($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->removeElement($fournisseur)) {
            $fournisseur->removeTypeServicePropose($this);
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
