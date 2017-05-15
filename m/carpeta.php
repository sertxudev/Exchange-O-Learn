<?php

class carpeta extends ddbb {
    public function obtenerCarpetas(){
        return $this->seleccionar("SELECT name, surname FROM users WHERE type!='admin'");
    }
}
