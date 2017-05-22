<?php

class evento extends ddbb {
    public function obtenerEventosFuturos(){
        $now = time();
        return $this->seleccionar("SELECT * FROM events WHERE time>='$now' ORDER BY time ASC", TRUE);
    }
    
    public function obtenerEvento($id){
        $now = time();
        return $this->seleccionar("SELECT * FROM events WHERE id='$id'", TRUE);
    }
}
