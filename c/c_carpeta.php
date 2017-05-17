<?php

class c_carpeta {

    public function obtenerCarpetas($post_id) {
        $folder = new carpeta();

        $id = $this->sanitizeString($post_id);

        $pdo = $folder->obtenerCarpetas($id);
        return json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
    }

    public function obtenerCarpeta($post_id) {
        $folder = new carpeta();

        $id = $this->sanitizeString($post_id);

        $pdo = $folder->obtenerCarpeta($id);
        $array_a = $pdo->fetchAll(PDO::FETCH_ASSOC);
        $return = "";
        foreach ($array_a as $a) {
            $return .= "<li><a href=" . $a['url'] . " download>" . $a['name'] . "</a> - " . $a['access'] . " </li>";
        }
        return $return;
    }

    private function sanitizeString($string) {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}
