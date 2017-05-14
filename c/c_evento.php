<?php

class c_evento {

    public function obtenerEventosFuturos() {
        $evento = new evento();
        $pdo = $evento->obtenerEventosFuturos();
        $return = json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
        echo $return;
    }

}
