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

    public function getIdeasGlobal(): array
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
                'u.pictureFileName',
                'o.location',
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->where('i.perimeter = :global')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('global', 'Global')
            ->orderBy('i.publicationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAscIdeasGlobal(): array
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
                'u.pictureFileName',
                'o.location',
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->where('i.perimeter = :global')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('global', 'Global')
            ->orderBy('i.publicationDate', 'ASC')
            ->getQuery()
            ->getResult();
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
            ->andWhere('i.perimeter = :agence')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('officeId', $officeId)
            ->setParameter('agence', 'Agence')
            ->orderBy('i.publicationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAscIdeasByUserOffice(int $officeId): array
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
            ->andWhere('i.perimeter = :agence')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('officeId', $officeId)
            ->setParameter('agence', 'Agence')
            ->orderBy('i.publicationDate', 'ASC')
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
            ->andWhere('i.perimeter = :service')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('officeId', $officeId)
            ->setParameter('service', 'Service')
            ->setParameter('departmentName', $departmentName)
            ->orderBy('i.publicationDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAscIdeasByUserDepartment(int $officeId, string $departmentName): array
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
            ->andWhere('i.perimeter = :service')
            ->andWhere('i.archived = :archived')
            ->setParameter('archived', false)
            ->setParameter('officeId', $officeId)
            ->setParameter('service', 'Service')
            ->setParameter('departmentName', $departmentName)
            ->orderBy('i.publicationDate', 'ASC')
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

    public function getSupportersSlackId(int $ideaId): array
    {
        return $this->createQueryBuilder('i')
            ->select('u.slackId')
            ->leftJoin('i.supporters', 'u')
            ->where('i.id = :ideaId')
            ->andWhere('u.slackId IS NOT NULL')
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
            ->andWhere('i.archived = :archived')
            ->setParameter('search', '%' . $search . '%')
            ->setParameter('userId', $userId)
            ->setParameter('archived', false)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getSupportersSortIdea(bool $archived = false): array
    {
        $query = $this->createQueryBuilder('i')
            ->select(
                'i',
                'COUNT(s) as supportersCount',
                'o.location',
                'u.lastname',
                'u.firstname',
                'u.pictureFileName'
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->leftJoin('i.supporters', 's')
            ->where('i.archived = :archived')
            ->andWhere('i.perimeter = :global')
            ->setParameter('archived', $archived)
            ->setParameter('global', 'Global')
            ->groupBy('i.id')
            ->orderBy('supportersCount', 'DESC')
            ->getQuery();

        $results = $query->getResult();

        $ideas = [];
        foreach ($results as $result) {
            $idea = $result[0];
            $supportersCount = $result['supportersCount'];
            $idea->supportersCount = $supportersCount;
            $idea->location = $result['location'];
            $idea->lastname = $result['lastname'];
            $idea->firstname = $result['firstname'];
            $idea->pictureFileName = $result['pictureFileName'];
            $ideas[] = $idea;
        }
        return $ideas;
    }

    public function getSupportersSortIdeaForOffice(int $officeId, bool $archived = false): array
    {
        $query = $this->createQueryBuilder('i')
            ->select(
                'i',
                'COUNT(s) as supportersCount',
                'o.location',
                'u.lastname',
                'u.firstname',
                'u.pictureFileName'
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->leftJoin('i.supporters', 's')
            ->where('i.archived = :archived')
            ->andWhere('o.id = :officeId')
            ->andWhere('i.perimeter = :officePerimeter')
            ->setParameter('archived', $archived)
            ->setParameter('officeId', $officeId)
            ->setParameter('officePerimeter', 'Agence')
            ->groupBy('i.id')
            ->orderBy('supportersCount', 'DESC')
            ->getQuery();

        $results = $query->getResult();

        $ideas = [];
        foreach ($results as $result) {
            $idea = $result[0];
            $supportersCount = $result['supportersCount'];
            $idea->supportersCount = $supportersCount;
            $idea->location = $result['location'];
            $idea->lastname = $result['lastname'];
            $idea->firstname = $result['firstname'];
            $idea->pictureFileName = $result['pictureFileName'];
            $ideas[] = $idea;
        }

        return $ideas;
    }

    public function getSupportersSortIdeaForDepartment(
        int $officeId,
        string $departmentName,
        bool $archived = false
    ): array {
        $query = $this->createQueryBuilder('i')
            ->select(
                'i',
                'COUNT(s) as supportersCount',
                'o.location',
                'u.lastname',
                'u.firstname',
                'u.pictureFileName'
            )
            ->innerJoin('i.author', 'u')
            ->innerJoin('u.workplace', 'o')
            ->leftJoin('i.supporters', 's')
            ->where('i.archived = :archived')
            ->andWhere('o.id = :officeId')
            ->andWhere('u.department = :departmentName')
            ->andWhere('i.perimeter = :service')
            ->setParameter('archived', $archived)
            ->setParameter('officeId', $officeId)
            ->setParameter('departmentName', $departmentName)
            ->setParameter('service', 'Service')
            ->groupBy('i.id')
            ->orderBy('supportersCount', 'DESC')
            ->getQuery();

        $results = $query->getResult();

        $ideas = [];
        foreach ($results as $result) {
            $idea = $result[0];
            $supportersCount = $result['supportersCount'];
            $idea->supportersCount = $supportersCount;
            $idea->location = $result['location'];
            $idea->lastname = $result['lastname'];
            $idea->firstname = $result['firstname'];
            $idea->pictureFileName = $result['pictureFileName'];
            $ideas[] = $idea;
        }

        return $ideas;
    }


    public function getReportedIdeas(): array
    {
        return $this->createQueryBuilder('i')
            ->select(
                'i.id as reportedIdea',
                'i.title',
                'i.archived',
                'r.motive',
                'r.reportDate',
                'u.id as reportingUser',
                'u.firstname',
                'u.lastname'
            )
            ->join('i.reportings', 'r')
            ->join('r.reportingUser', 'u')
            ->addOrderBy('r.reportDate', 'DESC')
            ->addOrderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult();
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
