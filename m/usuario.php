<?php

class usuario extends ddbb {
    
    public function crear($username, $password, $name, $surname, $birthday, $type){
        $this->insertar("INSERT INTO users "
                . "(username, password, name, surname, birthday, type) VALUES "
                . "('$username', '$password', '$name', '$surname', '$birthday', '$type')", TRUE);
    }
    
    public function editar($id, $username, $password, $name, $surname, $birthday, $type){
        $this->actualizar("UPDATE users SET "
                . "username='$username', password='$password', name='$name', surname='$surname', birthday='$birthday', type='$type' "
                . "WHERE id='$id'", TRUE);
    }
    
    public function borrar($id){
        $this->eliminar("DELETE FORM users WHERE id='$id'", TRUE);
    }
    
    public function login($username, $password){
        return $this->seleccionar("SELECT id, username, name, surname, birthday, color, background, type FROM users WHERE username='$username' AND password='$password'", TRUE);
    }
    
    public function obtener($id){
        return $this->seleccionar("SELECT name, surname FROM users WHERE id='$id'", TRUE);
    }
    
    public function cambiarColor($color, $background, $id) {
        return $this->seleccionar("UPDATE users SET color='$color', background='$background' WHERE id='$id'", TRUE);
    }
    
}
