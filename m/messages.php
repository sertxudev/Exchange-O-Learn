<?php

class messages extends ddbb{
    
    public function obtenerMessages() {
        $pdo = $this->seleccionar("SELECT count(id) FROM messages", false);
        $array = $pdo->fetch(PDO::FETCH_ASSOC);
        foreach ($array as $n){
            $max_count = $n;
            if($n <= 15){
                $min_count = 0;
            }else{
                $min_count = $n - 15;
            }
        }
        
        return $this->seleccionar("SELECT U.name AS name, U.surname AS surname, M.id AS id, M.text AS text, UNIX_TIMESTAMP(M.time) AS time "
                . "FROM messages AS M JOIN users AS U ON M.author=U.id LIMIT $min_count, $max_count", false);
    }
    
    public function sendMessage($text, $id, $time){
        //var_dump($tim)
        return $this->insertar("INSERT INTO messages (text, author, time) VALUES ('$text', '$id', '$time')", true);
    }
}
