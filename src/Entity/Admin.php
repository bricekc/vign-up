<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    #[ORM\ManyToMany(targetEntity: Rubrique::class, inversedBy: 'admins')]
    private Collection $rubrique;

    public function __construct()
    {
        parent::__construct();
        $this->rubrique = new ArrayCollection();
    }

    /*
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    */

    /**
     * @return Collection<int, Rubrique>
     */
    public function getRubrique(): Collection
    {
        return $this->rubrique;
    }

    public function addRubrique(Rubrique $rubrique): self
    {
        if (!$this->rubrique->contains($rubrique)) {
            $this->rubrique->add($rubrique);
        }

        return $this;
    }

    public function removeRubrique(Rubrique $rubrique): self
    {
        $this->rubrique->removeElement($rubrique);

        return $this;
    }
}
