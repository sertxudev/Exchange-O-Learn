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
}
