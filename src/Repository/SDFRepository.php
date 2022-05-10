<?php

namespace App\Repository;

use App\Entity\SDF;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SDF|null find($id, $lockMode = null, $lockVersion = null)
 * @method SDF|null findOneBy(array $criteria, array $orderBy = null)
 * @method SDF[]    findAll()
 * @method SDF[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SDFRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SDF::class);
    }

    // /**
    //  * @return SDF[] Returns an array of SDF objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SDF
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function TriParage()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.age','ASC ')
            ->getQuery()->getResult();
    }
}
