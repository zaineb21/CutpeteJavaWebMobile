<?php

namespace App\Repository;

use App\Entity\ParticipationVoyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticipationVoyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipationVoyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipationVoyage[]    findAll()
 * @method ParticipationVoyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationVoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipationVoyage::class);
    }

    // /**
    //  * @return ParticipationVoyage[] Returns an array of ParticipationVoyage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParticipationVoyage
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
