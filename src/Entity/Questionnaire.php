<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
class Questionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule_questionnaire = null;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: ResultatQuestionnaire::class, orphanRemoval: true)]
    private Collection $resultatQuestionnaires;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: Question::class)]
    private Collection $questions;

    #[ORM\Column]
    private ?bool $public = true;

    #[ORM\ManyToMany(targetEntity: Thematique::class, inversedBy: 'questionnaires')]
    #[ORM\JoinColumn(nullable: true)]
    private $thematiques;

    #[ORM\OneToMany(mappedBy: 'questionnaire', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->resultatQuestionnaires = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->thematiques = new ArrayCollection();
    }

    /**
     * @param ArrayCollection|Collection $resultatQuestionnaires
     */
    public function setResultatQuestionnaires(ArrayCollection|Collection $resultatQuestionnaires): void
    {
        $this->resultatQuestionnaires = $resultatQuestionnaires;
    }

    /**
     * @param ArrayCollection|Collection $questions
     */
    public function setQuestions(ArrayCollection|Collection $questions): void
    {
        $this->questions = $questions;
    }

    /**
     * @param Collection|null $thematiques
     */
    public function setThematiques(?Collection $thematiques): void
    {
        $this->thematiques = $thematiques;
    }

    /**
     * @param ArrayCollection|Collection $commentaires
     */
    public function setCommentaires(ArrayCollection|Collection $commentaires): void
    {
        $this->commentaires = $commentaires;
    }

    /**
     * @return Collection
     */
    public function getThematiques(): Collection
    {
        return $this->thematiques;
    }

    /**
     * @return $this
     */
    public function addThematique(Thematique $thematique): self
    {
        if (!$this->thematiques->contains($thematique)) {
            $this->thematiques->add($thematique);
            $thematique->addQuestionnaire($this);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function removeThematique(Thematique $thematique): self
    {
        if ($this->thematiques->contains($thematique)) {
            $this->thematiques->removeElement($thematique);
            $thematique->removeQuestionnaire($this);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleQuestionnaire(): ?string
    {
        return $this->intitule_questionnaire;
    }

    public function setIntituleQuestionnaire(string $intitule_questionnaire): self
    {
        $this->intitule_questionnaire = $intitule_questionnaire;

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
            $resultatQuestionnaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeResultatQuestionnaire(ResultatQuestionnaire $resultatQuestionnaire): self
    {
        if ($this->resultatQuestionnaires->removeElement($resultatQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($resultatQuestionnaire->getQuestionnaire() === $this) {
                $resultatQuestionnaire->setQuestionnaire(null);
            }
        }

        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuestionnaire() === $this) {
                $question->setQuestionnaire(null);
            }
        }

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getQuestionnaire() === $this) {
                $commentaire->setQuestionnaire(null);
            }
        }

        return $this;
    }
}
