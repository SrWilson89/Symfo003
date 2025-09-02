<?php
// src/Repository/ProductoRepository.php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    /**
     * @return Producto[] Returns an array of Producto objects
     */
    public function findTodayProducts(): array
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('p')
            ->andWhere('p.fecha_ini <= :today')
            ->andWhere('p.fecha_fin >= :today')
            ->setParameter('today', $today->format('Y-m-d'))
            ->orderBy('p.nombre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}