<?php

namespace App\Entity;

use App\Repository\VigneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VigneRepository::class)]
class Vigne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $superficie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'vignes')]
    private ?Viticulteur $viticulteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(?int $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

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
}
