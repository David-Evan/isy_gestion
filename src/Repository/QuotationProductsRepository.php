<?php

namespace App\Repository;

use App\Entity\QuotationProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuotationProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuotationProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuotationProducts[]    findAll()
 * @method QuotationProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotationProductsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuotationProducts::class);
    }

//    /**
//     * @return QuotationProducts[] Returns an array of QuotationProducts objects
//     */
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
    public function findOneBySomeField($value): ?QuotationProducts
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
