<?php

namespace App\Entity;

use App\Repository\ViticulteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViticulteurRepository::class)]
class Viticulteur extends User
{
    /*
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    */

    #[ORM\Column(length: 255, nullable: false)]
    private ?bool $verif = null;

    #[ORM\Column(length: 14, nullable: false)]
    private ?string $num_siret = null;

    #[ORM\OneToMany(mappedBy: 'viticulteur', targetEntity: Vigne::class)]
    private Collection $vignes;

    #[ORM\OneToMany(mappedBy: 'viticulteur', targetEntity: ResultatQuestionnaire::class, orphanRemoval: true)]
    private Collection $resultatQuestionnaires;

    public function __construct()
    {
        parent::__construct();
        $this->vignes = new ArrayCollection();
        $this->resultatQuestionnaires = new ArrayCollection();
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

    public function getNumSireT(): ?string
    {
        return $this->num_siret;
    }

    public function setNumSiret(string $num_cire): self
    {
        $this->num_siret = $num_cire;

        return $this;
    }

    /**
     * @return Collection<int, Vigne>
     */
    public function getVignes(): Collection
    {
        return $this->vignes;
    }

    public function addVigne(Vigne $vigne): self
    {
        if (!$this->vignes->contains($vigne)) {
            $this->vignes->add($vigne);
            $vigne->setViticulteur($this);
        }

        return $this;
    }

    public function removeVigne(Vigne $vigne): self
    {
        if ($this->vignes->removeElement($vigne)) {
            // set the owning side to null (unless already changed)
            if ($vigne->getViticulteur() === $this) {
                $vigne->setViticulteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ResultatQuestionnaire>
     */
    public function getResultatQuestionnaires(): Collection
    {
        return $this->resultatQuestionnaires;
    }

    public function addResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if (!$this->resultatQuestionnaires->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaires->add($resultatQuestionnaire);
            $resultatQuestionnaire->setViticulteur($this);
        }

        return $this;
    }

    public function removeResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if ($this->resultatQuestionnaires->removeElement($resultatQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($resultatQuestionnaire->getViticulteur() === $this) {
                $resultatQuestionnaire->setViticulteur(null);
            }
        }

        return $this;
    }
}
