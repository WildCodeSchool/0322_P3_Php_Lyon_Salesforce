<?php

namespace App\Repository;

use App\Entity\Reporting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reporting>
 *
 * @method Reporting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reporting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reporting[]    findAll()
 * @method Reporting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reporting::class);
    }

    public function save(Reporting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reporting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findOnlineIdeas(): array
    {
        return $this->createQueryBuilder('r')
            ->join('r.reportedIdea', 'i')
            ->where(('i.archived = :archived'))
            ->setParameter('archived', false)
            ->orderBy('i.title', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findIfAlreadyReported(int $ideaId, int $userId): array
    {
        return $this->createQueryBuilder('r')

            ->where('r.reportedIdea = :ideaId')
            ->andWhere('r.reportingUser = :userId')
            ->setParameter('ideaId', $ideaId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Reporting[] Returns an array of Reporting objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reporting
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
