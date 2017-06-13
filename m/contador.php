<?php

class contador extends ddbb {
    public function contarAlumnos(){
        return $this->seleccionar("SELECT count(id) AS cantidad FROM users WHERE type=0", TRUE);
    }

    public function contarProfesores(){
        return $this->seleccionar("SELECT count(id) AS cantidad FROM users WHERE type=1", TRUE);
    }
    
    public function contarMensajes(){
        return $this->seleccionar("SELECT count(id) AS cantidad FROM messages", TRUE);
    }
    
    public function contarEventos(){
        return $this->seleccionar("SELECT count(id) AS cantidad FROM events", TRUE);
    }
}