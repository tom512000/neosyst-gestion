<?php

namespace App\Repository;

use App\Entity\SAV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SAV>
 */
class SAVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SAV::class);
    }

    public function findBySearchQuery(?string $query)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.code LIKE :query')
            ->orWhere('s.representative LIKE :query')
            ->orWhere('s.breakdown LIKE :query')
            ->orWhere('s.repairedBy LIKE :query')
            ->orWhere('s.repairs LIKE :query')
            ->orWhere('s.comments LIKE :query')
            ->orWhere('s.charge LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }

    public function lastsCreatedSAVs()
    {
        return $this->createQueryBuilder('s')
            ->OrWhere('s.createdDate IS NOT NULL')
            ->orderBy('s.createdDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function lastsEditedSAVs()
    {
        return $this->createQueryBuilder('s')
            ->OrWhere('s.editedDate IS NOT NULL')
            ->orderBy('s.editedDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
