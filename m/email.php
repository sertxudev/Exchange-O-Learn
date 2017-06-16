<?php

class email extends ddbb{
    
    public function obtenerEmailsRecibidos($id){
        return $this->seleccionar("SELECT M.id AS id, M.subject AS subject, 
        M.text AS text, UNIX_TIMESTAMP(M.date) AS date, U1.name as name_to, U1.surname as surname_to, 
        U2.name as name_from, U2.surname as surname_from, 
        M.isread AS isread, M.status AS status, M.important as important 
        
        FROM mails AS M 
        JOIN users as U1 ON M.id_to=U1.id 
        JOIN users as U2 ON M.id_from=U2.id
        WHERE M.id_to=$id AND M.status=1", TRUE);
    }
    
}
