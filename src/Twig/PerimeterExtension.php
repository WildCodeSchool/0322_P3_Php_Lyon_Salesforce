<?php

namespace App\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Entity\Idea;

class PerimeterExtension extends AbstractExtension
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('perimeters', [$this, 'getPerimeters'])
        ];
    }

    public function getPerimeters(): array
    {
        return $this->entityManager->getRepository(Idea::class)->findBy([], ['perimeter' => 'ASC']);
    }
}
