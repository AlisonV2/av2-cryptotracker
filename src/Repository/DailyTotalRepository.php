<?php

namespace App\Repository;

use App\Entity\DailyTotal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DailyTotal|null find($id, $lockMode = null, $lockVersion = null)
 * @method DailyTotal|null findOneBy(array $criteria, array $orderBy = null)
 * @method DailyTotal[]    findAll()
 * @method DailyTotal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DailyTotalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DailyTotal::class);
    }


    // /**
    //  * @return DailyTotal[] Returns an array of DailyTotal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DailyTotal
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
