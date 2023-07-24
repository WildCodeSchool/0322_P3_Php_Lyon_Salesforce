<?php

namespace App\Entity;

use App\Repository\ReportingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReportingRepository::class)]
class Reporting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ideas', targetEntity: Idea::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Idea $reportedIdea = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reportingUser = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $reportDate = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Motif obligatoire')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le motif doit avoir {{ limit }} caractères maximum'
    )]
    #[Assert\Choice(
        choices: [
            "Inapproprié",
            "Spam",
            "Violence",
            "Informations privées",
        ],
        message: "Le motif spécifié n'est pas valide"
    )]
    private ?string $motive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportedIdea(): ?Idea
    {
        return $this->reportedIdea;
    }

    public function setReportedIdea(?Idea $reportedIdea): static
    {
        $this->reportedIdea = $reportedIdea;

        return $this;
    }

    public function getReportingUser(): ?User
    {
        return $this->reportingUser;
    }

    public function setReportingUser(?User $reportingUser): static
    {
        $this->reportingUser = $reportingUser;

        return $this;
    }

    public function getReportDate(): ?\DateTimeImmutable
    {
        return $this->reportDate;
    }

    public function setReportDate(\DateTimeImmutable $reportDate): static
    {
        $this->reportDate = $reportDate;

        return $this;
    }

    public function getMotive(): ?string
    {
        return $this->motive;
    }

    public function setMotive(string $motive): static
    {
        $this->motive = $motive;

        return $this;
    }
}
