<?php

namespace App\Repository;

use App\Entity\Emballage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Emballage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emballage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emballage[]    findAll()
 * @method Emballage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmballageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Emballage::class);
    }

    // /**
    //  * @return Emballage[] Returns an array of Emballage objects
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
    public function findOneBySomeField($value): ?Emballage
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
