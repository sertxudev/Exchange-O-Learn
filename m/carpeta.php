<?php

class carpeta extends ddbb{
     public function obtenerCarpetas($id){
        return $this->seleccionar("SELECT id, name, surname FROM users WHERE type!='admin' AND id!=$id ORDER BY name");
    }
}
