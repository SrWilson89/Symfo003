<?php

namespace App\classes;

use PDO;
use PDOException;

class bd {
    //Parámetros de la BD
    public static $servername = "localhost";
    public static $username = "root";
    public static $password = "";
    public static $db = "pisci_v2";

    //1) Comprobar que se puede realizar la conexión
    public static function check() : bool {
        try {
            self::get(false);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    //2) Crear la BD y las tablas si NO esta creada
    public static function init() {
        try {
            //Obtenemos el conector
            $conn = self::get(false);
            //Ejecutamos los sql
            $sql = "CREATE DATABASE IF NOT EXISTS ".self::$db;
            $conn->exec($sql);

            $conn = self::get();

            // Para empezar de cero, borramos las tablas si existen
            $conn->exec("DROP TABLE IF EXISTS arqueos;");
            $conn->exec("DROP TABLE IF EXISTS asistencias;");
            $conn->exec("DROP TABLE IF EXISTS detalle_ref;");
            $conn->exec("DROP TABLE IF EXISTS ventas_detalle;");
            $conn->exec("DROP TABLE IF EXISTS ventas;");
            $conn->exec("DROP TABLE IF EXISTS asociados;");
            $conn->exec("DROP TABLE IF EXISTS clientes;");
            $conn->exec("DROP TABLE IF EXISTS productos;");
            $conn->exec("DROP TABLE IF EXISTS empleados;");
            $conn->exec("DROP TABLE IF EXISTS aforos;");
            
            $sql = "CREATE TABLE IF NOT EXISTS empleados (
                id_empleado INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                apellidos VARCHAR(30) NOT NULL,
                telefono VARCHAR(9),
                dni VARCHAR(10)
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS aforos (
                id_aforo INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                ctd INT(10) DEFAULT 1,
                fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE IF NOT EXISTS clientes (
                id_cliente INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                notas VARCHAR(500) DEFAULT '',
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS productos (
                id_producto INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                precio DECIMAL(10,2) NOT NULL,
                notas VARCHAR(500) DEFAULT '',
                tipo TINYINT(1) DEFAULT 0,
                ref_ini INT(10) NOT NULL,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                fecha_ini TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                fecha_fin TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS ventas (
                id_venta INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                cliente_id INT(10) UNSIGNED,
                empleado_id INT(10) UNSIGNED,
                metodo_pago VARCHAR(25),
                total DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (cliente_id) REFERENCES clientes (id_cliente) ON DELETE SET NULL ON UPDATE NO ACTION,
                FOREIGN KEY (empleado_id) REFERENCES empleados (id_empleado) ON DELETE SET NULL ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS asociados (
                id_asociado INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(30) NOT NULL,
                apellidos VARCHAR(30),
                dni VARCHAR(10),
                notas VARCHAR(500) DEFAULT '',
                titular TINYINT(1) DEFAULT 0,
                fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                cliente_id INT(10) UNSIGNED,
                FOREIGN KEY (cliente_id) REFERENCES clientes (id_cliente) ON DELETE CASCADE ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS ventas_detalle (
                id_venta_detalle INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                venta_id INT(10) UNSIGNED,
                producto_id INT(10) UNSIGNED,
                precio DECIMAL(10,2) NOT NULL,
                ctd INT(10) NOT NULL DEFAULT 0,
                total DECIMAL(10,2) NOT NULL,
                FOREIGN KEY (venta_id) REFERENCES ventas (id_venta) ON DELETE CASCADE ON UPDATE NO ACTION,
                FOREIGN KEY (producto_id) REFERENCES productos (id_producto) ON DELETE SET NULL ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS detalle_ref (
                id_detalle_ref INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                detalle_id INT(10) UNSIGNED NOT NULL,
                referencia INT(10) NOT NULL,
                FOREIGN KEY (detalle_id) REFERENCES ventas_detalle (id_venta_detalle) ON DELETE CASCADE ON UPDATE NO ACTION
            )";
            $conn->exec($sql);
            
            $sql = "CREATE TABLE IF NOT EXISTS asistencias (
                id_asistencia INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                empleado_id INT(10) UNSIGNED,
                fecha_ini TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                fecha_fin TIMESTAMP NULL DEFAULT NULL,
                CONSTRAINT fk1_empleado_id FOREIGN KEY (empleado_id) REFERENCES empleados (id_empleado) ON DELETE SET NULL ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS arqueos (
                id_arqueo INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                empleado_id INT(10) UNSIGNED,
                fondo DOUBLE(10, 2) DEFAULT 0,
                ventas DOUBLE(10, 2) DEFAULT 0,
                descuadre DOUBLE(10, 2) DEFAULT 0,
                fecha_ini TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                fecha_fin TIMESTAMP NULL DEFAULT NULL,
                `1cto` INT,
                `2cto` INT,
                `5cto` INT,
                `10cto` INT,
                `20cto` INT,
                `50cto` INT,
                `1euro` INT,
                `2euro` INT,
                `5euro` INT,
                `10euro` INT,
                `20euro` INT,
                `50euro` INT,
                CONSTRAINT fk3_empleado_id FOREIGN KEY (empleado_id) REFERENCES empleados (id_empleado) ON DELETE SET NULL ON UPDATE NO ACTION
            )";
            $conn->exec($sql);

            return true;
        } catch(PDOException $e) {
            throw new PDOException("Error! Conexión fallida: " . $e->getMessage());
        }
    }

    //3) Obtener conector
    public static function get(bool $isBd = true) {
        $dsn = "mysql:host=" . self::$servername;
        if ($isBd) {
            $dsn .= ";dbname=" . self::$db . ";charset=utf8mb4";
        } else {
            $dsn .= ";charset=utf8mb4";
        }
    
        try {
            $conn = new PDO($dsn, self::$username, self::$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function getAll(string $table) {
        $sql = 'SELECT * FROM '.$table;

        try {
            $conn = bd::get();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function getById(string $table, int $id) {
        $sql = 'SELECT * FROM '.$table.' WHERE '.self::getTipo($table).' = :id';

        try {
            $conn = bd::get();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function deleteById(string $table, int $id) : bool {
        $sql = 'DELETE FROM '.$table.' WHERE '.self::getTipo($table).' = :id';

        try {
            $conn = bd::get();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAll(string $table) {
        $sql = 'DELETE FROM '.$table;

        try {
            $conn = bd::get();
            $stmt = $conn->prepare($sql);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function getTables() {
        $sql = 'SELECT table_name FROM information_schema.tables WHERE table_type="BASE TABLE" AND table_schema = "'.self::$db.'"';

        try {
            $conn = bd::get();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $salida = array();
            foreach ($items as $item) {
                $salida[] = $item["table_name"];
            }
            return $salida;
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function getTipo(string $table) {
        $id_tipo = "";
        switch ($table) {
            case 'asociados':
                $id_tipo = "id_asociado";
                break;
            case 'clientes':
                $id_tipo = "id_cliente";
                break;
            case 'detalle_ref':
                $id_tipo = "id_detalle_ref";
                break;
            case 'empleados':
                $id_tipo = "id_empleado";
                break;
            case 'productos':
                $id_tipo = "id_producto";
                break;
            case 'ventas_detalle':
                $id_tipo = "id_venta_detalle";
                break;
            case 'ventas':
                $id_tipo = "id_venta";
                break;
            case 'aforos':
                $id_tipo = "id_aforo";
                break;
            case 'asistencias':
                $id_tipo = "id_asistencia";
                break;
            case 'arqueos':
                $id_tipo = "id_arqueo";
                break;
        }
        return $id_tipo;
    }
}
