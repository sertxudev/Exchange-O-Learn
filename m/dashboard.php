<?php

class dashboard extends ddbb {
    
    public function obtenerAlumnos(){
        return $this->seleccionar("SELECT id, username, name, surname, birthday, color FROM users WHERE type=0", TRUE);
    }
    
    public function obtenerProfesores(){
        return $this->seleccionar("SELECT id, username, name, surname, birthday, color FROM users WHERE type=1", TRUE);
    }
    
    public function obtenerMensajes(){
        return $this->seleccionar("SELECT U.name AS name, U.surname AS surname, M.id AS id, M.text AS text, UNIX_TIMESTAMP(M.time) AS time FROM messages AS M JOIN users AS U ON M.author=U.id", TRUE);
    }
    
    public function obtenerEventos(){
        return $this->seleccionar("SELECT * FROM events", TRUE);
    }


}