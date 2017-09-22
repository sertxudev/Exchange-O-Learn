<?php

class c_email {

    public function obtenerEmailsRecibidos($post_id){
        $email = new email();

        $id = $this->sanitizeString($post_id);

        $pdo = $email->obtenerEmailsRecibidos($id);
        $array = $pdo->fetchAll(PDO::FETCH_ASSOC);

        /*
            <tr>
                <td><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></td>
                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                </td>
                <td class="mailbox-attachment"></td>
                <td class="mailbox-date">5 mins ago</td>
            </tr>


            SELECT M.id AS id, M.subject AS subject, 
                M.text AS text, M.date AS date, U1.name as name_to, U1.surname as surname_to, 
                U2.name as name_from, U2.surname as surname_from, 
                M.isread AS isread, M.status AS status, M.important as important 


        */

        array_walk($array, function (&$elemento, $clave){

            $elemento['eliminar'] = '<button type="button" onClick="borrarEmail('.$elemento['id'].')" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>';
            $elemento['from'] = $elemento['name_from'].' '.$elemento['surname_from'];
            
            if($elemento['important']){
                $elemento['important'] = '<i class="fa fa-star text-yellow"></i>';
            }else{
                $elemento['important'] = '<i class="fa fa-star-o text-yellow"></i>';
            }
            
            if(!$elemento['isread']){
                $elemento['subject'] = '<b>'.$elemento['subject'].'</b>';
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
    
    public function obtenerEmail($post_id){

    }

    public function enviarEmails(){

    }

    public function obtenerEmails(){

    }

    private function sanitizeString($string){
        return filter_var($string, FILTER_SANITIZE_STRING);
    }
}