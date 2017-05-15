<?php

class c_carpeta {
    public function obtenerCarpetas() {
        $folder = new carpeta();
        $pdo = $folder->obtenerCarpetas();
        $return = json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
        echo $return;
    }
}
