<?php

class logger {
    
    public static function guardar($texto) {
        if(_depurar_){
            $nombre = _RUTA_LOG_."Log_".date("d-m-Y").".txt";
            $fecha = date("d-m-Y H-i-s: ");
            $fopen = fopen($nombre, "a");
            fwrite($fopen, $fecha.$texto."\n");
            fclose($fopen);
        }
    }
    
    public static function recuperar($archivo) {
        echo file_get_contents($archivo);
    }
}
