<?php

namespace App\Entity;

use App\Repository\AdheranceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdheranceRepository::class)]
class Adherance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adherances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Idea $concept = null;

    #[ORM\ManyToOne(inversedBy: 'adherances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $adherant = null;

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

    public function getAdherant(): ?User
    {
        return $this->adherant;
    }

    public function setAdherant(?User $adherant): static
    {
        $this->adherant = $adherant;

        return $this;
    }
}
