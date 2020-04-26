<?php

namespace App\Repository;

use App\Entity\EtapeCircuit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtapeCircuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtapeCircuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtapeCircuit[]    findAll()
 * @method EtapeCircuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeCircuitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtapeCircuit::class);
    }

    // /**
    //  * @return EtapeCircuit[] Returns an array of EtapeCircuit objects
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
    public function findOneBySomeField($value): ?EtapeCircuit
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
