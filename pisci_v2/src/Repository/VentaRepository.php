<?php

namespace App\Repository;

use App\Entity\Venta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

/**
 * @extends ServiceEntityRepository<Venta>
 *
 * @method Venta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Venta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Venta[]    findAll()
 * @method Venta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Venta::class);
    }

    public function getTotalVentas(DateTime $fechaInicio, ?DateTime $fechaFin = null, bool $soloEfectivo = false): float
    {
        $qb = $this->createQueryBuilder('v')
            ->select('SUM(vd.total)')
            ->innerJoin('v.ventaDetalles', 'vd')
            ->where('v.fecha >= :fechaInicio')
            ->setParameter('fechaInicio', $fechaInicio);

        if ($fechaFin) {
            $qb->andWhere('v.fecha <= :fechaFin')
               ->setParameter('fechaFin', $fechaFin);
        }

        if ($soloEfectivo) {
            $qb->andWhere('v.metodoPago = :metodo')
               ->setParameter('metodo', 'Efectivo');
        }

        $result = $qb->getQuery()->getSingleScalarResult();

        return (float) $result;
    }
}
