<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse = null;

    #[ORM\Column(nullable: false)]
    private int $note = 0;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    private ?Question $question = null;

    #[ORM\OneToOne(mappedBy: 'reponse', targetEntity: Commentaire::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Commentaire $commentaire;

    #[ORM\ManyToMany(targetEntity: ResultatQuestionnaire::class, inversedBy: 'reponses')]
    private ?collection $resultatQuestionnaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getResultatQuestionnaire(): ?Collection
    {
        return $this->resultatQuestionnaire;
    }

    public function setResultatQuestionnaire(?Collection $resultatQuestionnaire): void
    {
        $this->resultatQuestionnaire = $resultatQuestionnaire;
    }

    public function addResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if (!$this->resultatQuestionnaire->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaire[] = $resultatQuestionnaire;
            $resultatQuestionnaire->addReponse($this);
        }

        return $this;
    }

    public function removeResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if ($this->resultatQuestionnaire->contains($resultatQuestionnaire)) {
            $this->resultatQuestionnaire->removeElement($resultatQuestionnaire);
        }

        return $this;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }
}
