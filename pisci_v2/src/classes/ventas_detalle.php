<?php
// src/classes/ventas_detalle.php

namespace App\classes;

use PDO;
use App\classes\bd;

class VentasDetalle
{
    public $id_venta_detalle;
    public $venta_id;
    public $producto_id;
    public $precio;
    public $ctd;
    public $total;
    
    public function __construct(int $id = null)
    {
        if ($id != null) {
            $item = bd::getById("ventas_detalle", $id);
            if ($item != null) {
                $this->id_venta_detalle = $item[0]["id_venta_detalle"];
                $this->venta_id = $item[0]["venta_id"];
                $this->producto_id = $item[0]["producto_id"];
                $this->precio = $item[0]["precio"];
                $this->ctd = $item[0]["ctd"];
                $this->total = $item[0]["total"];
            }
        }
    }
    
    public static function getAll()
    {
        return bd::getAll("ventas_detalle");
    }

    public static function getById(int $id)
    {
        return bd::getById("ventas_detalle", $id);
    }
    
    public static function getByVentaId(int $ventaId)
    {
        $conn = bd::get();
        $sql = "SELECT * FROM ventas_detalle WHERE venta_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $ventaId, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $salida = [];
        if ($items != null) {
            foreach ($items as $item) {
                $obj = new VentasDetalle();
                $obj->id_venta_detalle = $item["id_venta_detalle"];
                $obj->venta_id = $item["venta_id"];
                $obj->producto_id = $item["producto_id"];
                $obj->precio = $item["precio"];
                $obj->ctd = $item["ctd"];
                $obj->total = $item["total"];
                $salida[] = $obj;
            }
        }
        return $salida;
    }
}
