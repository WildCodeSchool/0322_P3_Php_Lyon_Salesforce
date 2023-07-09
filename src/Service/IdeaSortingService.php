<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

// class IdeaSortingService
// {
//     private $entityManager;

//     public function __construct(EntityManagerInterface $entityManager)
//     {
//         $this->entityManager = $entityManager;
//     }

//     public function sortIdeas($sortBy)
//     {
//         $repository = $this->entityManager->getRepository(Idea::class);
//         $queryBuilder = $repository->createQueryBuilder('i');

//         if ($sortBy === 'date') {
//             $queryBuilder->orderBy('i.publicationDate', 'DESC');
//         } elseif ($sortBy === 'popularity') {
//             $queryBuilder->orderBy('SIZE(i.adherents)', 'DESC');
//         } else {
//             $queryBuilder->orderBy('i.publicationDate', 'DESC');
//         }

//         $ideas = $queryBuilder->getQuery()->getResult();

//         return $ideas;
//     }
// }
