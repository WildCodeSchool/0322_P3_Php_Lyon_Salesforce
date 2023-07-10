<?php

namespace App\Repository;

use App\Entity\Idea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Idea>
 *
 * @method Idea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Idea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Idea[]    findAll()
 * @method Idea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Idea::class);
    }

    public function save(Idea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Idea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    public function getIdeasByUserOffice(int $officeId): array
    {
        return $this->createQueryBuilder('i')
            ->select(
                'i.id',
                'i.title',
                'i.content',
                'o.location',
                'i.publicationDate',
                'u.lastname',
                'u.firstname',
                'u.pictureFileName'
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->where('o.id = :officeId')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('officeId', $officeId)
            ->orderBy('i.publicationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getIdeasByUserDepartment(int $officeId, string $departmentName): array
    {
        return $this->createQueryBuilder('i')
            ->select(
                'i.id',
                'i.title',
                'i.content',
                'o.location',
                'i.publicationDate',
                'u.lastname',
                'u.firstname',
                'u.pictureFileName'
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->where('o.id = :officeId')
            ->andWhere('u.department = :departmentName')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('officeId', $officeId)
            ->setParameter('departmentName', $departmentName)
            ->orderBy('i.publicationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getActiveUserIdeas(int $userId): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.id', 'i.title', 'i.publicationDate', 'i.perimeter', 'i.content')
            ->where('i.author = :userId')
            ->andWhere('i.archived = :archived')
            ->setParameter('userId', $userId)
            ->setParameter('archived', false)
            ->orderBy('i.publicationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countSupporters(int $ideaId): int
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(u.id)')
            ->leftJoin('i.supporters', 'u')
            ->where('i.id = :idea')
            ->setParameter('idea', $ideaId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getSupportersSlackId(int $ideaId): array
    {
        return $this->createQueryBuilder('i')
            ->select('u.slackId')
            ->leftJoin('i.supporters', 'u')
            ->where('i.id = :ideaId')
            ->setParameter('ideaId', $ideaId)
            ->getQuery()
            ->getResult();
    }

    public function findBySearch(string $search, int $userId): array
    {
        return $this->createQueryBuilder('i')
            ->where('i.title LIKE :search')
            ->andWhere('i.author = :userId')
            ->andWhere('i.archived = :archived')
            ->orWhere(':userId MEMBER OF i.supporters')
            ->setParameter('search', '%' . $search . '%')
            ->setParameter('userId', $userId)
            ->setParameter('archived', false)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}

    //    /**
    //     * @return Idea[] Returns an array of Idea objects
    //     */

    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Idea
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
