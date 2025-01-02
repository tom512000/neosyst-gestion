<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findBySearchQuery(?string $query): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.code LIKE :query OR a.name LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }

    public function lastsCreatedClients(): array
    {
        return $this->createQueryBuilder('a')
            ->orWhere('a.createdDate IS NOT NULL')
            ->andWhere('a.spreadsheetName IS NULL')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function lastsEditedClients(): array
    {
        return $this->createQueryBuilder('a')
            ->orWhere('a.editedDate IS NOT NULL')
            ->andWhere('a.spreadsheetName IS NULL')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
