<?php

class c_usuario {
    
    public function obtenerUsuario($post_id) {
        $user = new usuario();
        
        $id = $this->sanitizeString($post_id);

        $pdo = $user->obtener($id);
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }
    
    public function obtenerPerfil($post_id) {
        $user = new usuario();
        
        $id = $this->sanitizeString($post_id);

        $pdo = $user->obtenerPerfil($id);
        return json_encode($pdo->fetch(PDO::FETCH_ASSOC));
    }
    
    public function actualizarPerfil($post_id, $post_username, $post_name, $post_surname, $post_password = false){
        $user = new usuario();
        
        $id = $this->sanitizeString($post_id);
        $username = $this->sanitizeString($post_username);
        $name     = $this->sanitizeString($post_name);
        $surname  = $this->sanitizeString($post_surname);
        if(!empty($post_password)){
            $password = hash('sha512', $this->sanitizeString($post_password));
            if(!$user->actualizarPerfil($id, $username, $name, $surname, $password)){
                echo 1;
            }
        }else{
            if(!$user->actualizarPerfil($id, $username, $name, $surname)){
                echo 1;
            }
        }
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
        
            $_SESSION['id']             = $return['id'];
            $_SESSION['username']       = $return['username'];
            $_SESSION['name']           = $return['name'];
            $_SESSION['surname']        = $return['surname'];
            $_SESSION['color']          = $return['color'];
            $_SESSION['background']     = $return['background'];
            $_SESSION['type']           = $return['type'];
            
            echo 1;
        }
    }
    
    public function cambiarColor($post_color, $post_background, $post_id){
        $user = new usuario();
        
        $color      = $this->sanitizeString($post_color);
        $background = $this->sanitizeString($post_background);
        $id         = $this->sanitizeString($post_id);
        
        $pdo = $user->cambiarColor($color, $background, $id);
        
        $return = $pdo->fetch(PDO::FETCH_ASSOC) ? 0 : 1;
        
        $_SESSION['color']      = $color;
        $_SESSION['background'] = $background;
        
        return json_encode($return);
    }
    
    public function estadoUsuario($post_id, $post_estado, $post_session){
        $user = new usuario();
        
        $id         = $this->sanitizeString($post_id);
        $estado     = $this->sanitizeString($post_estado);
        $session    = $this->sanitizeString($post_session);
        if($session == $id){
            return 0;
        }
        $pdo = $user->estadoUsuario($id, $estado);
        $return = $pdo->fetch(PDO::FETCH_ASSOC) ? 0 : 1;
        
        if($return == 1){
            $messages = new messages();
            
            if($estado == 1){
                $text = '/banned/';
            }elseif($estado == 0){
                $text = '/unbanned/';
            }
            
            $time = date('Y-m-d H:i:s');
            $messages->sendMessage($text, $id, $time);
        }
        
        return json_encode($return);
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
    
     public function logout() {
        session_destroy();
    }
}
