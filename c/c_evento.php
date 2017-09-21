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
            //strftime("%A, %d de %B de %Y", $miFecha)
            //$elemento['time'] = date('d \d\e F \d\e\l Y', strtotime($elemento['time']));
            $elemento['time'] = strftime('%d de %B de %Y', strtotime($elemento['time']));
        });
        
        
        //return var_dump($array);
        return json_encode($array);
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}
