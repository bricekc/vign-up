<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\ManyToOne(targetEntity: Questionnaire::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: true)]
    private $questionnaire;

    #[ORM\OneToOne(inversedBy: 'commentaire', targetEntity: Reponse::class)]
    private ?Reponse $reponse;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private array $notes = [];

    #[ORM\ManyToOne(targetEntity: Thematique::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Thematique $thematique;

    public function __toString(): string
    {
        return $this->commentaire;
    }

    public function getThematique(): ?Thematique
    {
        return $this->thematique;
    }

    public function setThematique(?Thematique $thematique): void
    {
        $this->thematique = $thematique;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
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

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getNotes(): array
    {
        return $this->notes;
    }

    public function setNotes(array $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
