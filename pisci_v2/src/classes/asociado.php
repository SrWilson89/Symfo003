<?php
// src/classes/asociado.php
namespace App\classes;

use PDO;
use App\classes\bd;

class asociado
{
    public $id_asociado;
    public $nombre;
    public $apellidos;
    public $dni;
    public $notas;
    public $titular;
    public $fecha;
    public $cliente_id;

    public function __construct(int $id = null)
    {
        if ($id != null) {
            $item = bd::getById("asociados", $id);
            if ($item != null) {
                $this->id_asociado = $item[0]["id_asociado"];
                $this->nombre = $item[0]["nombre"];
                $this->apellidos = $item[0]["apellidos"];
                $this->dni = $item[0]["dni"];
                $this->notas = $item[0]["notas"];
                $this->titular = $item[0]["titular"];
                $this->fecha = $item[0]["fecha"];
                $this->cliente_id = $item[0]["cliente_id"];
            }
        }
    }

    public static function getAll()
    {
        return bd::getAll("asociados");
    }

    public static function getById(int $id)
    {
        return bd::getById("asociados", $id);
    }

    public function save()
    {
        $conn = bd::get();
        if ($this->id_asociado == null) {
            $sql = "INSERT INTO asociados (nombre, apellidos, dni, notas, titular, fecha, cliente_id) VALUES (:nombre, :apellidos, :dni, :notas, :titular, :fecha, :cliente_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':titular', $this->titular, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $this->fecha);
            $stmt->bindParam(':cliente_id', $this->cliente_id);
        } else {
            $sql = "UPDATE asociados SET nombre = :nombre, apellidos = :apellidos, dni = :dni, notas = :notas, titular = :titular WHERE id_asociado = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':dni', $this->dni);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':titular', $this->titular, PDO::PARAM_INT);
            $stmt->bindParam(':id', $this->id_asociado);
        }
        $stmt->execute();
    }

    public function delete()
    {
        return bd::deleteById("asociados", $this->id_asociado);
    }

    public function esTitular()
    {
        return $this->titular == 1;
    }
}