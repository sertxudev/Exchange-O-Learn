<?php

class c_carpeta {
    public function obtenerCarpetas($post_id) {
        $folder = new carpeta();
        $pdo = $folder->obtenerCarpetas($post_id);
        $return = json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
        echo $return;
    }
}
