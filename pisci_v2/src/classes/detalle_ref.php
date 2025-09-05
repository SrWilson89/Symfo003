<?php
// src/classes/detalle_ref.php
namespace App\classes;

use PDO;
use App\classes\bd;

class DetalleRef
{
    public $id_detalle_ref;
    public $detalle_id;
    public $referencia;

    public function __construct(int $id = null)
    {
        if ($id != null) {
            $item = bd::getById("detalle_ref", $id);
            if ($item != null) {
                $this->id_detalle_ref = $item[0]["id_detalle_ref"];
                $this->detalle_id = $item[0]["detalle_id"];
                $this->referencia = $item[0]["referencia"];
            }
        }
    }

    public static function getAll()
    {
        return bd::getAll("detalle_ref");
    }

    public static function getById(int $id)
    {
        return bd::getById("detalle_ref", $id);
    }

    public static function getByDetalleId(int $detalleId)
    {
        $conn = bd::get();
        $sql = "SELECT * FROM detalle_ref WHERE detalle_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $detalleId, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $salida = [];
        if ($items != null) {
            foreach ($items as $item) {
                $obj = new DetalleRef();
                $obj->id_detalle_ref = $item["id_detalle_ref"];
                $obj->detalle_id = $item["detalle_id"];
                $obj->referencia = $item["referencia"];
                $salida[] = $obj;
            }
        }
        return $salida;
    }
}