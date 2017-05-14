<?php

class messages extends ddbb{
    
    public function obtenerMessages() {
        return $this->seleccionar("SELECT U.name AS name, U.surname AS surname, M.id AS id, M.text AS text, M.time AS time "
                . "FROM messages AS M JOIN users AS U ON M.author=U.id ORDER BY time ASC");
    }
    
    public function sendMessage($text, $id){
        return $this->insertar("INSERT INTO messages (text, author) VALUES ('$text', '$id')");
    }
}
