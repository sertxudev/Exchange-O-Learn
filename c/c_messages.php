<?php

class c_messages {

    public function obtenerMessages() {
        if(_bloquear_ && $_SESSION['type'] == 0 ){
            echo 'Access Denied';
            exit;
        }
        
        $messages = new messages();
        $pdo = $messages->obtenerMessages();
        $return = $pdo->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode( array_reverse( $return ) );
    }
    
    public function sendMessage($post_text, $post_id) {
        $messages = new messages();        
        
        $text = $this->sanitizeString($post_text);
        $id = $this->sanitizeString($post_id);
        
        $time = date('Y-m-d H:i:s');
                
        $pdo = $messages->sendMessage($text, $id, $time);
        if($pdo){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
}
