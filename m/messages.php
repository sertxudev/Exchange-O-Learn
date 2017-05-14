<?php

class messages extends ddbb{
    
    public function obtenerMessages() {
        return $this->seleccionar("SELECT U.name AS name, U.surname AS surname, M.id AS id, M.text AS text, M.time AS time "
                . "FROM messages AS M JOIN users AS U ON M.author=U.id");
    }
    
    public function sendMessage($text, $id, $time){
        return $this->insertar("INSERT INTO messages (text, author, time) VALUES ('$text', '$id', '$time')");
    }
}
