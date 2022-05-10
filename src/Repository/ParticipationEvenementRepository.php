<?php

namespace App\Repository;

use App\Entity\ParticipationEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParticipationEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipationEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipationEvenement[]    findAll()
 * @method ParticipationEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipationEvenement::class);
    }
    /**
     * @return ParticipationEvenement[]
     */
    public function findsimilar (int $iduser, int $ideve): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM FirstProject2\src/Entity\ParticipationEvenement p
            WHERE p.idUser > :iduser
            AND p.idEvent > :ideve'

        )->setParameter('idUser', $iduser)
        ->setParameter('idEvent', $ideve);

        // returns an array of Product objects
        return $query->getResult();

    }


    // /**
    //  * @return ParticipationEvenement[] Returns an array of ParticipationEvenement objects
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
    public function findOneBySomeField($value): ?ParticipationEvenement
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
