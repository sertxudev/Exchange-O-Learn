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
        $return = "";
        foreach ($array_a as $a) {
            $return .= "<li><a href=" . $a['url'] . " download>" . $a['name'] . "</a> - " . $a['access'] . " </li>";
        }
        return $return;
    }

    public function obtenerCarpetaPersonal($post_id) {
        $folder = new carpeta();

        $id = $this->sanitizeString($post_id);

        $pdo = $folder->obtenerCarpetaPersonal($id);
        
        $array_a = $pdo->fetchAll(PDO::FETCH_ASSOC);
        
        
        /** Método Pro ... */
        
        /**
         * El caracter de &, sirve para pasar una variable por referencia, 
         * es decir le pasamos la variable en si, no el valor de esta.
         * 
         * Array_walk, que nos permite aplicar la función definida por el usuario
         * dada por callback a cada elemento del array dado por array.
         * 
         * Que dentro de un metodo, podemos usar funciones
         */
        function prepararDatos(&$elemento, $clave){
            $name = '<a href="' . $elemento['url'] . '" target="_BLANK">' . $elemento['name'] . '</a>';
            $fecha = date('d-m-Y', $elemento['time']);
//            switch ($elemento['access']){
//                case 0:
//                    $elemento['access'] = 'Público';
//                    break;
//                case 1:
//                    $elemento['access'] = 'Protegido';
//                    break;
//                case 2:
//                    $elemento['access'] = 'Privado';
//                    break;
//            }
            $access = $elemento['access'] == 0 ? 'Público' 
                    : $elemento['access'] == 1 ? 'Protegido' 
                    : 'Privado' ;
            
            $elemento['name'] = $name;
            $elemento['access'] = $access;
            $elemento['time'] = $fecha;
        }

        array_walk($array_a, 'prepararDatos');
        
        /** Más PRO entoavia
         * 
        array_walk($array_a, function (&$elemento, $clave){
            $elemento['time'] = date('d-m-Y', $elemento['time']);
            $elemento['access'] = $elemento['access'] == 0 ? 'Público' : $elemento['access'] == 1 ? 'Protegido' : 'Privado' ;
            });
         * 
         */
                
        return json_encode(array(
            "data" => $array_a
        ));
        
        

        /** Método artesano de contruir un JSON */
//        $i = 0;
//        $return = '{"data": [';
//
//        foreach ($array_a as $a) {
//            if($i == 0){
//                $return .= '{'
//                    . '"name": "'.$a['name'].'",'
//                    . '"time": "'.date('d-m-Y', $a['time']).'",'
//                    . '"access": "'.$a['access'].'"'
//                    . '}';
//                $i++;
//            }else{
//                $return .= ',{'
//                    . '"name": "'.$a['name'].'",'
//                    . '"time": "'.date('d-m-Y', $a['time']).'",'
//                    . '"access": "'.$a['access'].'"'
//                    . '}';
//            }
//            
//        }
//        
//        $return .= ']}';
//        return $return;
    }
    
    public function subirArchivo($post_name, $post_url, $post_ext, $post_id, $post_access) {
        $folder = new carpeta();

        $id     = $this->sanitizeString($post_id);
        $name   = $this->sanitizeString($post_name);
        $ext    = $this->sanitizeString($post_ext);
        $access = $this->sanitizeString($post_access);
        $url    = $this->sanitizeUrl($post_url);
        
        $time = date('Y-m-d');
       
        $folder->subirArchivo($name, $url, $ext, $id, $access, $time);
    }

    private function sanitizeString($string) {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
    
    private function sanitizeUrl($url) {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

}
