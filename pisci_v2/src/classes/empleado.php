<?php
// src/classes/empleado.php

namespace App\classes;

use PDO;
use App\classes\bd;

class empleado {
    public $id_empleado;
    public $nombre;
    public $apellidos;
    public $telefono;
    public $dni;

    public function __construct(int $id = null) {
        if ($id != null) {
            $item = bd::getById("empleados", $id);
            if ($item != null) {
                $this->id_empleado = $item[0]["id_empleado"];
                $this->nombre = $item[0]["nombre"];
                $this->apellidos = $item[0]["apellidos"];
                $this->telefono = $item[0]["telefono"];
                $this->dni = $item[0]["dni"];
            }
        }
    }

    public static function getAll() {
        return bd::getAll("empleados");
    }

    public static function getById(int $id) {
        return bd::getById("empleados", $id);
    }

    public function save() {
        $conn = bd::get();
        if ($this->id_empleado == null) {
            $sql = "INSERT INTO empleados (nombre, apellidos, telefono, dni) VALUES (:nombre, :apellidos, :telefono, :dni)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':dni', $this->dni);
        } else {
            $sql = "UPDATE empleados SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono, dni = :dni WHERE id_empleado = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':id', $this->id_empleado);
        }
        $stmt->execute();
    }
}