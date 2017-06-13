<?php

class c_contador {

    public function contarAlumnos(){
        $count = new contador();
        $pdo = $count->contarAlumnos();
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }

    public function contarProfesores(){
        $count = new contador();
        $pdo = $count->contarProfesores();
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }

    public function contarMensajes(){
        $count = new contador();
        $pdo = $count->contarMensajes();
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }

    public function contarEventos(){
        $count = new contador();
        $pdo = $count->contarEventos();
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }
}