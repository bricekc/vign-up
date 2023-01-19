<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur extends User
{
    /*
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    */

    #[ORM\Column(length: 255, nullable: false)]
    private ?bool $verif = null;

    #[ORM\ManyToMany(targetEntity: TypeMateriel::class, inversedBy: 'fournisseurs')]
    private Collection $type_materiel_propose;

    #[ORM\ManyToMany(targetEntity: TypeService::class, inversedBy: 'fournisseurs')]
    private Collection $type_service_propose;

    public function __construct()
    {
        parent::__construct();
        $this->type_materiel_propose = new ArrayCollection();
        $this->type_service_propose = new ArrayCollection();
    }

    public function getVerif(): ?bool
    {
        return $this->verif;
    }

    public function setVerif(bool $verif): self
    {
        $this->verif = $verif;

        return $this;
    }

    /**
     * @return Collection<int, TypeMateriel>
     */
    public function getTypeMaterielPropose(): Collection
    {
        return $this->type_materiel_propose;
    }

    public function addTypeMaterielPropose(TypeMateriel $typeMaterielPropose): self
    {
        if (!$this->type_materiel_propose->contains($typeMaterielPropose)) {
            $this->type_materiel_propose->add($typeMaterielPropose);
        }

        return $this;
    }

    public function removeTypeMaterielPropose(TypeMateriel $typeMaterielPropose): self
    {
        $this->type_materiel_propose->removeElement($typeMaterielPropose);

        return $this;
    }

    /**
     * @return Collection<int, TypeService>
     */
    public function getTypeServicePropose(): Collection
    {
        return $this->type_service_propose;
    }

    public function addTypeServicePropose(TypeService $typeServicePropose): self
    {
        if (!$this->type_service_propose->contains($typeServicePropose)) {
            $this->type_service_propose->add($typeServicePropose);
        }

        return $this;
    }

    public function removeTypeServicePropose(TypeService $typeServicePropose): self
    {
        $this->type_service_propose->removeElement($typeServicePropose);

        return $this;
    }
}
