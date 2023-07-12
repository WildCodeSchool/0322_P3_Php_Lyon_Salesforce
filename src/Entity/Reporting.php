<?php

namespace App\Entity;

use App\Repository\ReportingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportingRepository::class)]
class Reporting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Idea $reportedIdea = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reportingUser = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $reportDate = null;

    #[ORM\Column(length: 255)]
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
