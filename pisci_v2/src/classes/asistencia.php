<?php
// src/classes/asistencia.php

namespace App\classes;

use PDO;
use App\classes\bd;

class asistencia
{
    public $id_asistencia;
    public $empleado_id;
    public $fecha_ini;
    public $fecha_fin;

    public function __construct(int $id = null)
    {
        if ($id != null) {
            $item = bd::getById("asistencia", $id);
            if ($item != null) {
                $this->id_asistencia = $item[0]["id_asistencia"];
                $this->empleado_id = $item[0]["empleado_id"];
                $this->fecha_ini = $item[0]["fecha_ini"];
                $this->fecha_fin = $item[0]["fecha_fin"];
            }
        }
    }

    public function save()
    {
        $conn = bd::get();
        if ($this->id_asistencia == null) {
            $sql = "INSERT INTO asistencia (empleado_id) VALUES (:empleado_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':empleado_id', $this->empleado_id);
        } else {
            $sql = "UPDATE asistencia SET fecha_fin = :fecha_fin WHERE id_asistencia = :id_asistencia";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_asistencia', $this->id_asistencia);
            $stmt->bindParam(':fecha_fin', $this->fecha_fin);
        }
        $stmt->execute();
    }

    public function close()
    {
        $now = new \DateTime();
        $this->fecha_fin = $now->format("Y-m-d H:i:s");
        $this->save();
    }

    public static function getCurrent()
    {
        $conn = bd::get();
        $sql = "SELECT * FROM asistencia WHERE fecha_fin IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $item = $stmt->fetch();
        if ($item == false) {
            return null;
        } else {
            $asistencia = new asistencia($item['id_asistencia']);
            return $asistencia;
        }
    }
}