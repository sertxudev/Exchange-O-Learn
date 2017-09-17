<?php

class c_carpeta {

    public function obtenerCarpetas($post_id) {
        $folder = new carpeta();

        $id = $this->sanitizeString($post_id);

        $pdo = $folder->obtenerCarpetas($id);
        return json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
    }

    public function obtenerCarpeta($post_id, $post_type) {
        $folder = new carpeta();

        $id = $this->sanitizeString($post_id);
        $type = $this->sanitizeString($post_type);

        $pdo = $folder->obtenerCarpeta($id, $type);
        $array_a = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array_a, function (&$elemento, $clave){
            $fecha = date('d-m-Y', $elemento['time']);
            $access = $elemento['access'] == 0 ? 'Público' 
                    : ($elemento['access'] == 1 ? 'Protegido' : 'Privado') ;
            /*
           
             
             <div class="btn-group" role="group">
                <button type="button" onClick="editarArchivo(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>
                <button type="button" onClick="borrarArchivo(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
            </div>             
             
              <a class="btn btn-primary" href="' . $elemento['url'] . '" download="' . $elemento['name'] . '.' . $elemento['type'] . '">Descargar</a>
             */
            
            $acciones = '<div class="btn-group" role="group">
                            <a href="' . $elemento['url'] . '" target="_BLANK" class="btn btn-success">Visualizar</a>
                            <a href="' . $elemento['url'] . '" download="' . $elemento['name'] . '.' . $elemento['type'] . '" class="btn btn-primary">Descargar</a>
                        </div>';
            
            $elemento['access']     = $access;
            $elemento['time']       = $fecha;
            $elemento['acciones']   = $acciones;
        });
        
        return json_encode(array(
            "data" => $array_a
        ));
    }

    public function obtenerCarpetaPersonal($post_id) {
        $folder = new carpeta();

        $id = $this->sanitizeString($post_id);

        $pdo = $folder->obtenerCarpetaPersonal($id);
        
        $array_a = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        array_walk($array_a, function (&$elemento, $clave){
            $name = '<a href="' . $elemento['url'] . '" download="' . $elemento['name'] . '.' . $elemento['type'] . '">' . $elemento['name'] . '</a>';
            $fecha = date('d-m-Y', $elemento['time']);
            $access = $elemento['access'] == 0 ? 'Público' 
                    : ($elemento['access'] == 1 ? 'Protegido' : 'Privado') ;
            
            $acciones = '<div class="btn-group" role="group">
                            <button type="button" onClick="editarArchivo(' . $elemento['id'] . ')" class="btn btn-primary">Editar</button>
                            <button type="button" onClick="borrarArchivo(' . $elemento['id'] . ')" class="btn btn-danger">Eliminar</button>
                        </div>';
            
            $elemento['name']       = $name;
            $elemento['access']     = $access;
            $elemento['time']       = $fecha;
            $elemento['actions']    = $acciones;
        });
        
        return json_encode(array(
            "data" => $array_a
        ));
    }
    
    public function subirArchivo($post_name, $post_url, $post_ext, $post_id, $post_access) {
        $folder = new carpeta();

        $id     = $this->sanitizeString($post_id);
        $name   = $this->sanitizeString($post_name);
        $ext    = $this->sanitizeString($post_ext);
        $access = $this->sanitizeString($post_access);
        $url    = $this->sanitizeUrl($post_url);
        
        $time = date('Y-m-d');
       
        return $folder->subirArchivo($name, $url, $ext, $id, $access, $time) ? 0 : 1;
    }
    
    public function borrarArchivo($post_id, $post_owner) {
        $folder = new carpeta();
        
        $id     = $this->sanitizeString($post_id);
        $owner   = $this->sanitizeString($post_owner);
        
        $pdo = $folder->obtenerUrlArchivo($id);
        $return = $pdo->fetch(PDO::FETCH_ASSOC);
        return $folder->borrarArchivo($id, $owner) ? (@unlink($return['url']) ? 0 : 1) : 2 ;
    }
    
    public function obtenerArchivo($post_id, $post_owner) {
        $folder = new carpeta();
        
        $id     = $this->sanitizeString($post_id);
        $owner   = $this->sanitizeString($post_owner);
        
        $pdo = $folder->obtenerArchivo($id, $owner);
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }
    
    public function editarArchivo($post_id, $post_name, $post_access, $post_owner) {
        $folder = new carpeta();

        $id       = $this->sanitizeString($post_id);
        $owner    = $this->sanitizeString($post_owner);
        $name     = $this->sanitizeString($post_name);
        $access   = $this->sanitizeString($post_access);
        
        return $folder->editarArchivo($id, $name, $access, $owner) ? 0 : 1;
    }

    private function sanitizeString($string) {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
    
    private function sanitizeUrl($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

}
