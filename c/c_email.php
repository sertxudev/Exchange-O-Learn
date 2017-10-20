<?php

class c_email {

    public function obtenerEmailsRecibidos($post_id){
        $email = new email();

        $id = $this->sanitizeString($post_id);

        $pdo = $email->obtenerEmailsRecibidos($id);
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);

        array_walk($array, function (&$elemento, $clave){

            $elemento['from'] = $elemento['name_from'].' '.$elemento['surname_from'];
            
            if($elemento['important']){
                $elemento['important'] = '<i class="fa fa-star text-yellow"></i>';
            }else{
                $elemento['important'] = '<i class="fa fa-star-o text-yellow"></i>';
            }
            
            if((strlen(trim($elemento['subject'])) == 0)){
                if(!$elemento['isread']){
                    $elemento['subject'] = '<a onClick="viewMail('.$elemento['id'].', 0)"><b><i>(Sin Asunto)</i></b></a>';
                }else{
                    $elemento['subject'] = '<a onClick="viewMail('.$elemento['id'].', 0)"><i>(Sin Asunto)</i></a>';
                }
            }else{
                if(!$elemento['isread']){
                    $elemento['subject'] = '<a onClick="viewMail('.$elemento['id'].', 0)"><b>'.$elemento['subject'].'</b></a>';
                }else{
                    $elemento['subject'] = '<a onClick="viewMail('.$elemento['id'].', 0)">'.$elemento['subject'].'</a>';
                }
            }
            
            $elemento['date'] = date('d/m/Y', $elemento['date']) . '&nbsp;' . date('h:i', $elemento['date']) . '&nbsp;' . date('a', $elemento['date']);

        });
        
        return json_encode(array(
            "data" => $array
        ));
    }
    
    public function obtenerEmailsEnviados($post_id){
        $id = $this->sanitizeString($post_id);
        
        $email = new email();
        $pdo = $email->obtenerEmailsEnviados($id);
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);

        array_walk($array, function (&$elemento, $clave){

            $elemento['to'] = $elemento['name_to'].' '.$elemento['surname_to'];
            
            if($elemento['important']){
                $elemento['important'] = '<i class="fa fa-star text-yellow"></i>';
            }else{
                $elemento['important'] = '<i class="fa fa-star-o text-yellow"></i>';
            }
            
            if((strlen(trim($elemento['subject'])) == 0)){
                $elemento['subject'] = '<a onClick="viewMail('.$elemento['id'].', 1)"><i>(Sin Asunto)</i></a>';
            }else{
                $elemento['subject'] = '<a onClick="viewMail('.$elemento['id'].', 1)">'.$elemento['subject'].'</a>';

            }
            
            $elemento['date'] = date('d/m/Y', $elemento['date']) . '&nbsp;' . date('h:i', $elemento['date']) . '&nbsp;' . date('a', $elemento['date']);

        });
        
        return json_encode(array(
            "data" => $array
        ));
    }

    public function contarEmailsRecibidos($post_id) {
        $id = $this->sanitizeString($post_id);
        
        $email = new email();
        $pdo = $email->contarEmailsRecibidos($id);
        $return = $pdo->fetch(PDO::FETCH_ASSOC);
        
        return $return['unread'];
    }
    
    public function obtenerEmail($post_email_id, $post_flag, $post_id){
        $id = $this->sanitizeString($post_id);
        $email_id = $this->sanitizeString($post_email_id);
        $flag = $this->sanitizeString($post_flag);

        $email = new email();
        
        if($flag == 0){
            $email->marcarLeidoEmail($email_id);
        }

        $pdo = $email->obtenerEmail($email_id, $flag, $id);
        $array = array($pdo->fetch(PDO::FETCH_ASSOC));

        array_walk($array, function (&$elemento, $clave){
            $elemento['date'] = date('h:i a d/m/Y', $elemento['date']);
        });
        return json_encode($array[0]);
    }
    
    public function obtenerPosiblesDestinatarios(){
        $email = new email();
        $pdo = $email->obtenerPosiblesDestinatarios();
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);

        $result = '';
        foreach ($array as $key => $value) {
            $result .= '<option value="'.$value['id'].'">'.$value['name'].' '.$value['surname'].'</option>';
        }
        
        return $result;
    }
    
    public function enviarEmail($post_id, $post_toid, $post_important, $post_subject, $post_text){
        $id         = $this->sanitizeString($post_id);
        $toid       = $this->sanitizeString($post_toid);
        $important  = $this->sanitizeString($post_important);
        $subject    = $this->sanitizeString($post_subject);

        $email = new email();
        return $email->enviarEmail($id, $toid, $important, $subject, $post_text);
        
    }
    
    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
}