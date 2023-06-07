<?php

namespace App\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use App\Entity\Idea;

class PerimeterExtension extends AbstractExtension
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function getDistinctPerimeters(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('DISTINCT idea.perimeter')
            ->from(Idea::class, 'idea')
            ->orderBy('idea.perimeter', 'ASC');

        $query = $queryBuilder->getQuery();
        $results = $query->getResult();

        return $results;
    }
}
