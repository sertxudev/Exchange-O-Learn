<?php

class carpeta extends ddbb{
    public function obtenerCarpetas($id){
        return $this->seleccionar("SELECT id, name, surname FROM users WHERE type!='2' AND id!=$id ORDER BY name", TRUE);
    }
    
    public function obtenerCarpeta($id, $type){
        return $this->seleccionar("SELECT name, owner, url, time, access FROM files WHERE owner=$id && access<=$type", TRUE);
    }
    
    public function obtenerCarpetaPersonal($id){
        return $this->seleccionar("SELECT name, owner, url, UNIX_TIMESTAMP(time) AS time, access FROM files WHERE owner=$id", TRUE);
    }
}
