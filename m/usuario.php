<?php

class usuario extends ddbb {
        
    public function actualizarPerfil($id, $username, $name, $surname, $birthday, $password = false){
        if(!empty($password)){
            $this->actualizar("UPDATE users SET "
                    . "username='$username', password='$password', name='$name', surname='$surname', birthday='$birthday' "
                    . "WHERE id='$id'", TRUE);
        }else{
            $this->actualizar("UPDATE users SET "
                    . "username='$username', name='$name', surname='$surname', birthday='$birthday' "
                    . "WHERE id='$id'", TRUE);
        }
    }
    
    public function login($username, $password){
        return $this->seleccionar("SELECT id, username, name, surname, birthday, color, background, type FROM users WHERE username='$username' AND password='$password'", TRUE);
    }
    
    public function obtener($id){
        return $this->seleccionar("SELECT name, surname FROM users WHERE id='$id'", TRUE);
    }
    
    public function obtenerPerfil($id){
        return $this->seleccionar("SELECT id, username, name, surname, birthday, color FROM users WHERE id='$id'", TRUE);
    }
    
    public function cambiarColor($color, $background, $id) {
        return $this->seleccionar("UPDATE users SET color='$color', background='$background' WHERE id='$id'", TRUE);
    }
    
}
