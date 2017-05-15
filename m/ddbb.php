<?php

class ddbb {

    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(_TIPO_ . ":dbname=" . _BBDD_ . ";host=" . _HOST_, _USER_, _PASS_);
            $this->conexion->query("SET NAMES 'utf8'");
            logger::guardar("Conectado a la DDBB");
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
            logger::guardar("Error al conectar a la DDBB: " . $e->getMessage());
        }
    }

    public function insertar($sql) {
        logger::guardar("Insertar: " . $sql);
        return $this->conexion->exec($sql);
    }

    public function loop($sql) {
        return $this->conexion->query($sql);
    }
    
    public function seleccionar($sql) {
        logger::guardar("Seleccionar: " . $sql);
        return $this->conexion->query($sql);
    }

    public function actualizar($sql) {
        logger::guardar("Actualizar: " . $sql);
        return $this->conexion->exec($sql);
    }

    public function eliminar($sql) {
        logger::guardar("Eliminar: " . $sql);
        return $this->conexion->exec($sql);
    }

}
