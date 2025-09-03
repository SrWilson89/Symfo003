<?php
// src/Repository/VentaRepository.php

namespace App\Repository;

use App\Entity\Venta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Venta::class);
    }

    /**
     * @return float
     */
    public function findSalesToday(): float
    {
        $qb = $this->createQueryBuilder('v')
            ->select('SUM(vd.cantidad)')
            ->leftJoin('v.ventaDetalles', 'vd')
            ->where('v.fecha BETWEEN :start AND :end')
            ->setParameter('start', new \DateTime('today 00:00:00'))
            ->setParameter('end', new \DateTime('today 23:59:59'))
            ->getQuery();

        $result = $qb->getSingleScalarResult();

        return $result ?? 0;
    }

    /**
     * @return array
     */
    public function findSalesByHour(\DateTime $date): array
    {
        $qb = $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.fecha, 12, 2) AS hora, SUM(vd.cantidad) AS total')
            ->leftJoin('v.ventaDetalles', 'vd')
            ->where('v.fecha BETWEEN :start AND :end')
            ->setParameter('start', $date->format('Y-m-d 00:00:00'))
            ->setParameter('end', $date->format('Y-m-d 23:59:59'))
            ->groupBy('hora')
            ->orderBy('hora', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }
}