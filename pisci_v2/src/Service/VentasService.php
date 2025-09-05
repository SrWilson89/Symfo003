<?php
// src/Service/VentasService.php

namespace App\Service;

use Doctrine\DBAL\Connection;
use DateTime;

class VentasService
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    //Devuelve el número total de ventas
    public function getTotalVentas(): int
    {
        $start = new DateTime();
        $start->setTime(0, 0, 0);

        $end = new DateTime();
        $end->setTime(23, 59, 59);

        $sql = 'SELECT SUM(vd.ctd) as total 
                FROM ventas_detalle AS vd 
                LEFT JOIN ventas AS v ON v.id_venta = vd.venta_id 
                WHERE v.fecha BETWEEN :start AND :end;';

        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery([
            'start' => $start->format("Y-m-d H:i:s"),
            'end' => $end->format("Y-m-d H:i:s")
        ]);

        $total = $result->fetchOne();

        return $total ? (int) $total : 0;
    }
}