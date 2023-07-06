<?php

namespace App\Entity;

use App\Repository\IdeaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IdeaRepository::class)]
class Idea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Vous avez oublié d\'écrire votre idée !')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom de votre idée doit avoir maximum {{ limit }} caractères'
    )]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Vous devez préciser votre service')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le nom de votre service doit avoir maximum {{ limit }} caractères'
    )]

    #[Assert\Choice(
        choices: [
            "Global",
            "Agence",
            "Service",
        ],
        message: "Le service spécifié n'est pas valide"
    )]

    private ?string $perimeter = null;

    #[ORM\ManyToOne(inversedBy: 'ideas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $publicationDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Pensez à développer votre idée!')]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $archived = null;
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'supportingIdeas')]
    private Collection $supporters;
    public function __construct()
    {
        $this->supporters = new ArrayCollection();
    }

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

    public function getPerimeter(): ?string
    {
        return $this->perimeter;
    }

    public function setPerimeter(string $perimeter): self
    {
        $this->perimeter = $perimeter;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeImmutable $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): static
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSupporters(): Collection
    {
        return $this->supporters;
    }

    public function addSupporter(User $supporter): static
    {
        if (!$this->supporters->contains($supporter)) {
            $this->supporters->add($supporter);
            $supporter->addSupportingIdea($this);
        }

        return $this;
    }

    public function removeSupporter(User $supporter): static
    {
        if ($this->supporters->removeElement($supporter)) {
            $supporter->removeSupportingIdea($this);
        }

        return $this;
    }
}
