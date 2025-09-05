<?php

namespace App\Service;

use App\Repository\VentaRepository;
use Doctrine\DBAL\Connection;
use DateTime;

class VentasService
{
    private $ventaRepository;
    private $connection;

    public function __construct(VentaRepository $ventaRepository, Connection $connection)
    {
        $this->ventaRepository = $ventaRepository;
        $this->connection = $connection;
    }

    public function getTotalVentas(): float
    {
        $now = new DateTime();
        $start = $now->format('Y-m-d 00:00:00');
        $end = $now->format('Y-m-d 23:59:59');

        $sql = 'SELECT SUM(vd.total) as total
                FROM ventas_detalle AS vd
                LEFT JOIN ventas AS v ON v.id_venta = vd.venta_id
                WHERE v.fecha BETWEEN :start AND :end;';

        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery([
            'start' => $start,
            'end' => $end,
        ]);
        
        return (float) $result->fetchOne();
    }

    public function getVentasPorHora(): array
    {
        $now = new DateTime();
        $start = $now->format('Y-m-d 00:00:00');
        $end = $now->format('Y-m-d 23:59:59');

        $sql = 'SELECT DATE_FORMAT(v.fecha, \'%H:00\') as hora,
                       SUM(vd.total) as total
                FROM ventas_detalle AS vd
                LEFT JOIN ventas AS v ON v.id_venta = vd.venta_id
                WHERE v.fecha BETWEEN :start AND :end
                GROUP BY hora
                ORDER BY hora ASC;';

        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery([
            'start' => $start,
            'end' => $end,
        ]);

        return $result->fetchAllAssociative();
    }
}