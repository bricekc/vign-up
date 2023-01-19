<?php

namespace App\Entity;

use App\Repository\ResultatQuestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatQuestionnaireRepository::class)]
class ResultatQuestionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $note = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(targetEntity: Questionnaire::class, inversedBy: 'resultatQuestionnaire')]
    private ?Questionnaire $questionnaire = null;

    #[ORM\ManyToOne(targetEntity: Viticulteur::class, inversedBy: 'resultatQuestionnaires')]
    private ?Viticulteur $viticulteur = null;

    #[ORM\ManyToMany(targetEntity: Reponse::class, mappedBy: 'resultatQuestionnaire')]
    #[ORM\JoinColumn(name: 'resultat_questionnaire_id', referencedColumnName: 'id')]
    private Collection $reponses;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getViticulteur(): ?Viticulteur
    {
        return $this->viticulteur;
    }

    public function setViticulteur(?Viticulteur $viticulteur): self
    {
        $this->viticulteur = $viticulteur;

        return $this;
    }

    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function setReponses(?Collection $reponses): self
    {
        $this->reponses = $reponses;

        return $this;
    }

    /**
     * @param Reponse $reponse
     *
     * @return self
     */
    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->addResultatQuestionnaire($this);
        }

        return $this;
    }
}
