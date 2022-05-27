<?php

namespace App\Repository;

use App\Entity\SymfonyGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SymfonyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SymfonyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SymfonyGroup[]    findAll()
 * @method SymfonyGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SymfonyGroup::class);
    }

    // /**
    //  * @return Groups[] Returns an array of Groups objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Groups
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
