<?php

namespace App\Repository;

use App\Entity\Membership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<membership>
 *
 * @method Membership|null find($id, $lockMode = null, $lockVersion = null)
 * @method Membership|null findOneBy(array $criteria, array $orderBy = null)
 * @method Membership[]    findAll()
 * @method Membership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, membership::class);
    }

    public function save(Membership $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Membership $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getIfUserIsIdeaMember(int $conceptId, int $memberId): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.concept = ' . $conceptId)
            ->andWhere('a.member = ' . $memberId)
            ->getQuery()
            ->getResult();
    }

    public function getNumberOfMembership(int $conceptId): int
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.member)')
            ->where('a.concept = ' . $conceptId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    /**
    //     * @return Membership[] Returns an array of Membership objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Membership
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
