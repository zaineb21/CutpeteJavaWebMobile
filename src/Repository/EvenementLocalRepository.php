<?php

namespace App\Repository;

use App\Entity\EvenementLocal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvenementLocal|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvenementLocal|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvenementLocal[]    findAll()
 * @method EvenementLocal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementLocalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvenementLocal::class);
    }


    /**
     * @return EvenementLocal[]
     */
    public function findAllGreaterThanPrice(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\EvenementLocal p
            WHERE p.id > :id
            '
        )->setParameter('id', $id);

        // returns an array of Product objects
        return $query->getResult();
    }

    // /**
    //  * @return EvenementLocal[] Returns an array of EvenementLocal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EvenementLocal
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
