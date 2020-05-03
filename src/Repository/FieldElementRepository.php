<?php

namespace App\Repository;

use App\Entity\FieldElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FieldElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method FieldElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method FieldElement[]    findAll()
 * @method FieldElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FieldElementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FieldElement::class);
    }

    // /**
    //  * @return FieldElement[] Returns an array of FieldElement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FieldElement
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
