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
        $array = array($pdo->fetch(PDO::FETCH_ASSOC));
        array_walk($array, function (&$elemento, $clave){
            $elemento['time'] = strftime('%d de %B de %Y', strtotime($elemento['time']));
        });
        return json_encode($array);
    }
    
    public function crearEvento($post_nombre, $post_descripcion, $post_fecha) {
        $evento = new evento();
        
        $nombre = $this->sanitizeString($post_nombre);
        $descripcion = $this->sanitizeString($post_descripcion);
        $fecha = $this->sanitizeString($post_fecha);
        
        return $evento->crearEvento($nombre, $descripcion, $fecha);
    }
    
    public function borrarEvento($post_id) {
        $evento = new evento();
        
        $id = $this->sanitizeString($post_id);
        
        return $evento->borrarEvento($id);
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}
