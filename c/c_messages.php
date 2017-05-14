<?php

class c_messages {

    public function obtenerMessages() {
        $messages = new messages();        
        $pdo = $messages->obtenerMessages();
        $return = json_encode($pdo->fetchAll(PDO::FETCH_ASSOC));
        echo $return;
    }
    
    public function sendMessage($post_text, $post_id) {
        $messages = new messages();        
        
        $text = $this->sanitizeString($post_text);
        $id = $this->sanitizeString($post_id);
        
        $pdo = $messages->sendMessage($text, $id);
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
