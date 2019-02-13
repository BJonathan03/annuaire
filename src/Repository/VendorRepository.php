<?php

namespace App\Repository;


use App\Entity\Vendor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vendor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vendor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vendor[]    findAll()
 * @method Vendor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vendor::class);
    }

//    /**
//     * @return Vendor[] Returns an array of Vendor objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    */

    /**
     * @return Vendor[]
     */

    public function findByNameCpCategory($searchName, $searchCategory, $searchLocality): array
    {

        $qb = $this->createQueryBuilder('v');

 /*
        $qb->leftJoin('v.logo', 'logo');
        $qb->addSelect('logo');

*/
        $string = '%'.$searchName.'%';

        if($searchName !== ''){
            $qb->andWhere('v.name LIKE :searchName');
            $qb->setParameter('searchName', $string);
        }
        if($searchCategory !== ''){
            $qb->leftJoin('v.service', 'service');
            $qb->addSelect('service');
            $qb->andWhere('service.name LIKE :searchCategory');
            $qb->setParameter('searchCategory', '%'.$searchCategory.'%');
        }
        if($searchLocality !== ''){
            $qb->leftJoin('v.locality', 'locality');
            $qb->addSelect('locality');
            $qb->andWhere('locality.locality LIKE :searchLocality');
            $qb->setParameter('searchLocality', $searchLocality);
        }
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /*
    public function findOneBySomeField($value): ?Vendor
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
