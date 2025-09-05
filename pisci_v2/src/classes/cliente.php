<?php
// src/classes/cliente.php
namespace App\classes;

use PDO;
use App\classes\bd;

class cliente
{
    public $id_cliente;
    public $notas;
    public $asociados;
    public $asociado_id; //El titular
    public $fecha;

    public function __construct(int $id = null)
    {
        $this->asociados = array();
        if ($id != null) {
            $item = bd::getById("clientes", $id);
            if ($item != null) {
                $this->id_cliente = $item[0]["id_cliente"];
                $this->notas = $item[0]["notas"];
                $this->fecha = $item[0]["fecha"];

                $conn = bd::get();
                $sql = "SELECT id_asociado FROM asociados WHERE cliente_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $this->id_cliente);
                $stmt->execute();
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($items as $item) {
                    $this->asociados[] = new asociado($item["id_asociado"]);
                }
            }
        }
    }

    public static function getAll()
    {
        $salida = array();
        $items = bd::getAll("clientes");
        if ($items != null) {
            foreach ($items as $item) {
                $salida[] = new cliente($item["id_cliente"]);
            }
        }
        return $salida;
    }

    public static function getById(int $id)
    {
        $salida = new cliente($id);
        return $salida;
    }

    public function save()
    {
        $conn = bd::get();
        if ($this->id_cliente == null) {
            $sql = "INSERT INTO clientes (notas, fecha) VALUES (:notas, :fecha)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':fecha', $this->fecha);
        } else {
            $sql = "UPDATE clientes SET notas = :notas WHERE id_cliente = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':notas', $this->notas);
            $stmt->bindParam(':id', $this->id_cliente);
        }
        $stmt->execute();
    }
}