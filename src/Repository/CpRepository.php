<?php

namespace App\Repository;

use App\Entity\Cp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cp[]    findAll()
 * @method Cp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cp::class);
    }

//    /**
//     * @return Cp[] Returns an array of Cp objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cp
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
