<?php

namespace App\Repository;

use App\Entity\Main\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function findByPast($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.past = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByPastUsingMyDql($value)
    {
        $dql = 'SELECT user FROM App\Entity\User user WHERE user.past != ' . "'" . $value . "'";
        $dql = $this->getEntityManager()->createQuery($dql);
        return $dql->execute();
    }

    public function findByNotPast($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.past != :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByTerm($term)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.title LIKE :term  OR u.past LIKE :term and u.name LIKE :term')
            ->setParameter('term', '%' . $term . "%")
            ->getQuery()
            ->getResult();

    }

    public function  findAllWithDbID() : array
    {
         return $this->createQueryBuilder('u')
         ->where('u.dbid IS NOT NULL')
            ->getQuery()
            ->getResult();
    }


}
