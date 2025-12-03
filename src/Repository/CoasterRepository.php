<?php

namespace App\Repository;

use App\Entity\Coaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Coaster>
 */
class CoasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coaster::class);
    }

    public function findFiltered(
        string $parkId = '', 
        string $categoryId = '',
        int $page = 1, 
        int $count = 3,
    ): Paginator
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.park', 'p')
            ->leftJoin('c.categories', 'cat')
        ;

        if ($parkId !== '') {
            $qb->andWhere('p.id = :parkId')
                ->setParameter('parkId', (int)$parkId)
            ;
        }

        if ($categoryId !== '') {
            $qb->andWhere('cat.id = :categoryId')
                ->setParameter('categoryId', (int)$categoryId)
            ;
        }
        $begin = ($page - 1) * $count;

        $qb->setFirstResult($begin) //offset
            ->setMaxResults($count) //limit
            ->orderBy('c.id', 'ASC');
        

        return new Paginator($qb->getQuery(), true);
    }

    //    /**
    //     * @return Coaster[] Returns an array of Coaster objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Coaster
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
