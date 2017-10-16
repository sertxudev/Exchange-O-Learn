<?php

class evento extends ddbb {
    public function obtenerEventosFuturos(){
        $now = date('Y-m-d');
        return $this->seleccionar("SELECT * FROM events WHERE time>='$now' ORDER BY time ASC", TRUE);
    }
    
    public function obtenerEvento($id){
        $now = time();
        return $this->seleccionar("SELECT * FROM events WHERE id='$id'", TRUE);
    }
    
    public function crearEvento($nombre, $descripcion, $fecha){
        return $this->insertar("INSERT INTO events (title, description, time) VALUES ('$nombre', '$descripcion', '$fecha')", TRUE);
    }
    
    public function borrarEvento($id){
        return $this->insertar("DELETE FROM events WHERE id='$id'", TRUE);
    }
}
