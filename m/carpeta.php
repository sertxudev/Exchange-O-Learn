<?php

class carpeta extends ddbb{
    public function obtenerCarpetas($id){
        return $this->seleccionar("SELECT id, name, surname FROM users WHERE type!='2' AND id!=$id ORDER BY name", TRUE);
    }
    
    public function obtenerCarpeta($id, $type){
        return $this->seleccionar("SELECT name, owner, type, url, UNIX_TIMESTAMP(time) AS time, access FROM files WHERE owner=$id && access<=$type", TRUE);
    }
    
    public function obtenerCarpetaPersonal($id){
        return $this->seleccionar("SELECT id, name, owner, type, url, UNIX_TIMESTAMP(time) AS time, access FROM files WHERE owner=$id", TRUE);
    }
    
    public function obtenerUrlArchivo($id){
        return $this->seleccionar("SELECT url FROM files WHERE id=$id", TRUE);
    }
    
    public function subirArchivo($name, $url, $ext, $id, $access, $time){
        return $this->insertar("INSERT INTO files (name, url, type, owner, access, time) VALUES ('$name', '$url', '$ext', '$id', '$access', '$time')", TRUE);
    }
    
    public function borrarArchivo($id, $owner){
        return $this->eliminar("DELETE FROM files WHERE id='$id' AND owner='$owner'", TRUE);
    }
    
    public function obtenerArchivo($id, $owner){
        return $this->seleccionar("SELECT id, name, owner, type, url, UNIX_TIMESTAMP(time) AS time, access FROM files WHERE id='$id' AND owner='$owner'", TRUE);
    }
    public function editarArchivo($id, $name, $access, $owner){
        return $this->actualizar("UPDATE files SET name='$name', access='$access' WHERE id='$id' AND owner='$owner'", TRUE);
    }
}
