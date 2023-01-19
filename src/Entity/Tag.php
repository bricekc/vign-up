<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: TypeMateriel::class)]
    private Collection $typeMateriels;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: TypeService::class)]
    private Collection $typeServices;

    public function __construct()
    {
        $this->typeMateriels = new ArrayCollection();
        $this->typeServices = new ArrayCollection();
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

    /**
     * @return Collection<int, TypeMateriel>
     */
    public function getTypeMateriels(): Collection
    {
        return $this->typeMateriels;
    }

    public function addTypeMateriel(TypeMateriel $typeMateriel): self
    {
        if (!$this->typeMateriels->contains($typeMateriel)) {
            $this->typeMateriels->add($typeMateriel);
            $typeMateriel->setTag($this);
        }

        return $this;
    }

    public function removeTypeMateriel(TypeMateriel $typeMateriel): self
    {
        if ($this->typeMateriels->removeElement($typeMateriel)) {
            // set the owning side to null (unless already changed)
            if ($typeMateriel->getTag() === $this) {
                $typeMateriel->setTag(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeService>
     */
    public function getTypeServices(): Collection
    {
        return $this->typeServices;
    }

    public function addTypeService(TypeService $typeService): self
    {
        if (!$this->typeServices->contains($typeService)) {
            $this->typeServices->add($typeService);
            $typeService->setTag($this);
        }

        return $this;
    }

    public function removeTypeService(TypeService $typeService): self
    {
        if ($this->typeServices->removeElement($typeService)) {
            // set the owning side to null (unless already changed)
            if ($typeService->getTag() === $this) {
                $typeService->setTag(null);
            }
        }

        return $this;
    }
}
