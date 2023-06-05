<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: IdeaRepository::class)]
#[UniqueEntity('title')]
class Idea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Your idea need a name !')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Your service name must be less than {{ limit }} character'
    )]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'We need your service\'s name')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Your service name must be less than {{ limit }} character'
    )]
    private ?string $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }
}
