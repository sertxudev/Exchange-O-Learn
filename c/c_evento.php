<?php

class c_evento {

    public function obtenerEventosFuturos() {
        $evento = new evento();
        $pdo = $evento->obtenerEventosFuturos();
        $return = json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
        echo $return;
    }
    
    public function obtenerEvento($post_id) {
        $evento = new evento();
        
        $id = $this->sanitizeString($post_id);
        
        $pdo = $evento->obtenerEvento($id);
        $return = json_encode($pdo->fetch(PDO::FETCH_ASSOC));
        echo $return;
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}
