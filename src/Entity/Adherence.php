<?php

namespace App\Entity;

use App\Repository\AdherenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdherenceRepository::class)]
class Adherence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adherences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Idea $concept = null;

    #[ORM\ManyToOne(inversedBy: 'adherences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $adherent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcept(): ?Idea
    {
        return $this->concept;
    }

    public function setConcept(?Idea $concept): static
    {
        $this->concept = $concept;

        return $this;
    }

    public function getAdherent(): ?User
    {
        return $this->adherent;
    }

    public function setAdherent(?User $adherent): static
    {
        $this->adherent = $adherent;

        return $this;
    }
}
