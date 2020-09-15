<?php

namespace App\Repository;

use App\Entity\QuackEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuackEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuackEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuackEntity[]    findAll()
 * @method QuackEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuackEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuackEntity::class);
    }

    // /**
    //  * @return QuackEntity[] Returns an array of QuackEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuackEntity
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
