<?php

namespace App\Repository;

use App\Entity\Arqueo; // Asegúrate de que esta línea apunte a tu clase de entidad "Arqueo".
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Arqueo>
 *
 * @method Arqueo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arqueo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arqueo[]    findAll()
 * @method Arqueo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArqueoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arqueo::class);
    }

//    /**
//     * @return Arqueo[] Returns an array of Arqueo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Arqueo
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
