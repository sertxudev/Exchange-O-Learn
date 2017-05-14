<?php

class evento extends ddbb {
    public function obtenerEventosFuturos(){
        $now = time();
        return $this->seleccionar("SELECT * FROM events WHERE time>='$now' ORDER BY time ASC");
    }
}
