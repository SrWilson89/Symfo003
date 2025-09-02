<?php
// src/Repository/AforoRepository.php

namespace App\Repository;

use App\Entity\Aforo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AforoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aforo::class);
    }

    /**
     * @return array
     */
    public function findAforoByHour(\DateTime $date): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('SUBSTRING(a.fecha, 12, 2) AS hora, SUM(a.ctd) AS total')
            ->where('a.fecha BETWEEN :start AND :end')
            ->setParameter('start', $date->format('Y-m-d 00:00:00'))
            ->setParameter('end', $date->format('Y-m-d 23:59:59'))
            ->groupBy('hora')
            ->orderBy('hora', 'ASC')
            ->getQuery();

        return $qb->getResult();
    }
}