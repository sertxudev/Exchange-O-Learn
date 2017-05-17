<?php

class c_usuario {
        
    public function obtenerUsuario($post_id) {
        $user = new usuario();
        
        $id = $this->sanitizeString($post_id);

        $pdo = $user->obtener($id);
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }
    
    public function crearUsuario($post_username, $post_password, $post_name, $post_surname, $post_birthday, $post_type){
        $user = new usuario();
        
        $username = $this->sanitizeString($post_username);
        $password = hash('sha512', $this->sanitizeString($post_password));
        $name     = $this->sanitizeString($post_name);
        $surname  = $this->sanitizeString($post_surname);
        $birthday = $this->sanitizeString($post_birthday);
        $type     = $this->sanitizeString($post_type);
        
        $user->crear($username, $password, $name, $surname, $birthday, $type);
    }
    
    public function editarUsuario($post_id, $post_username, $post_password, $post_name, $post_surname, $post_birthday, $post_type){
        $user = new usuario();
        
        $id = $this->sanitizeString($post_id);
        $username = $this->sanitizeString($post_username);
        $password = hash('sha512', $this->sanitizeString($post_password));
        $name     = $this->sanitizeString($post_name);
        $surname  = $this->sanitizeString($post_surname);
        $birthday = $this->sanitizeString($post_birthday);
        $type     = $this->sanitizeString($post_type);
        
        $user->editar($id, $username, $password, $name, $surname, $birthday, $type);
    }
    
    public function borrarUsuario($post_id) {
        $user = new usuario();
        
        $id = $this->sanitizeString($post_id);
        
        $user->borrar($id);
    }
    
    public function login($post_username, $post_password) {
        $user = new usuario();
        
        //$username = $this->sanitizeString($post_username);
        //$password = hash('sha512', $this->sanitizeString($post_password));
        $password = hash('sha512', $post_password);
        //$pdo = $user->login($username, $password);
        $pdo = $user->login($post_username, $password);
        $return = $pdo->fetch(PDO::FETCH_ASSOC);
        
        if($return == false){
            echo 0;
        }else{
        
            $_SESSION['id']       = $return['id'];
            $_SESSION['username'] = $return['username'];
            $_SESSION['name']     = $return['name'];
            $_SESSION['surname']  = $return['surname'];
            
            echo 1;
        }
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
}
