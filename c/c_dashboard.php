<?php

class c_dashboard {

    public function obtenerAlumnos() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerAlumnos();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){

            $acciones = '<div class="btn-group" role="group" aria-label="...">
                            <button type="button" onClick="editarAlumno(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>
                            <button type="button" onClick="borrarAlumno(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                        </div>';
            
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function obtenerProfesores() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerProfesores();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){

            $acciones = '<div class="btn-group" role="group" aria-label="...">
                            <button type="button" onClick="editarProfesor(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>
                            <button type="button" onClick="borrarProfesor(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                        </div>';
            
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function obtenerMensajes() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerMensajes();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){

            $time = date('H:m d/m/Y', $elemento['time']);

            $acciones = '<div class="btn-group" role="group" aria-label="...">
                            <button type="button" onClick="borrarMensajes(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                        </div>';
            
            $elemento['time'] = $time;
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function obtenerEventos() {
        $dashboard = new dashboard();
        $pdo = $dashboard->obtenerEventos();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array, function (&$elemento, $clave){

            $acciones = '<div class="btn-group" role="group" aria-label="...">
                            <button type="button" onClick="borrarEventos(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                        </div>';
            
            $elemento['acciones'] = $acciones;
        });
        
        return json_encode(array(
            "data" => $array
        ));
    }


}