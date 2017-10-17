<?php

    setlocale(LC_TIME, 'es_ES.UTF-8');

/* Logger */
    define("_RUTA_LOG_", "logs/");

/* Depurar */
if(file_exists(_RUTA_LOG_."depurando")){
    define("_depurar_", true);
    if(_depurar_){
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }
}else{
    define("_depurar_", false);
}

/* Bloquear */
if(file_exists(_RUTA_LOG_."bloqueado")){
    define("_bloquear_", true);
}else{
    define("_bloquear_", false);
}

/* BBDD */
    define("_HOST_", "localhost");
    define("_BBDD_", "eol");
    define("_USER_", "root");
    define("_PASS_", "root");
    define("_TIPO_", "mysql");
    
/* CONFIG */
//    define('_USR_ALUMNO_',0);
//    define('_USR_PROFESOR_',1);
//    define('_USR_ADMIN_',2);
//    
//    define('_FILE_PUBLIC_',0);
//    define('_FILE_PROTECTED_',1);
//    define('_FILE_PRIVATE_',2);
//    
    
/* Autoloader */
    spl_autoload_register(function ($clase) {
        if(strstr($clase, 'c_')) {
            include 'c/' . $clase . '.php';
        } else {
            include 'm/' . $clase . '.php';
        }
    });
