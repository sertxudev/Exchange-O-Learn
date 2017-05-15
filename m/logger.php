<?php

class logger {
    
    public static function guardar($texto) {
        if(_depurar_){
            if($texto != 'SELECT U.name AS name, U.surname AS surname, M.id AS id, M.text AS text, M.time AS time FROM messages AS M JOIN users AS U ON M.author=U.id'){
                $nombre = _RUTA_LOG_."Log_".date("d-m-Y").".txt";
                $fecha = date("d-m-Y H-i-s: ");
                $fopen = fopen($nombre, "a");
                fwrite($fopen, $fecha.$texto."\n");
                fclose($fopen);
            }            
        }
    }
    
    public static function recuperar($archivo) {
        echo file_get_contents($archivo);
    }
}
