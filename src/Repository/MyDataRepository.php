<?php

namespace App\Repository;

use App\Entity\MyData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyData|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyData|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyData[]    findAll()
 * @method MyData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyData::class);
    }

    // /**
    //  * @return MyData[] Returns an array of MyData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MyData
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
