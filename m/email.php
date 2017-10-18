<?php

class email extends ddbb{
    
    public function obtenerEmailsRecibidos($id){
        return $this->seleccionar("SELECT M.id AS id, M.subject AS subject, 
        M.text AS text, UNIX_TIMESTAMP(M.date) AS date,
        U2.name as name_from, U2.surname as surname_from, 
        M.isread AS isread, M.important as important 
        
        FROM mails AS M 
        JOIN users as U1 ON M.id_to=U1.id 
        JOIN users as U2 ON M.id_from=U2.id
        WHERE M.id_to=$id", TRUE);
    }
    
    public function obtenerEmailsEnviados($id){
        return $this->seleccionar("SELECT M.id AS id, M.subject AS subject, 
        M.text AS text, UNIX_TIMESTAMP(M.date) AS date,
        U1.name as name_to, U1.surname as surname_to,
        M.important as important 
        
        FROM mails AS M 
        JOIN users as U1 ON M.id_to=U1.id 
        JOIN users as U2 ON M.id_from=U2.id
        WHERE M.id_from=$id", TRUE);
    }
    
    public function contarEmailsRecibidos($id){
        return $this->seleccionar("SELECT count(id) AS unread FROM mails WHERE id_to=$id AND isread=0", TRUE);
    }
    
    public function obtenerEmail($email_id, $id){
        return $this->seleccionar("SELECT M.id AS id, M.subject AS subject, 
        M.text AS text, UNIX_TIMESTAMP(M.date) AS date, 
        U2.name as name_from, U2.surname as surname_from, 
        U2.name as name_to, U2.surname as surname_to, 
        M.important as important 
        
        FROM mails AS M 
        JOIN users as U1 ON M.id_to=U1.id 
        JOIN users as U2 ON M.id_from=U2.id
        WHERE M.id_to=$id AND M.id=$email_id", TRUE);
    }
    
    public function marcarLeidoEmail($email_id){
        return $this->insertar("UPDATE mails SET isread=1 WHERE id=$email_id", TRUE);
    }
    
    public function enviarEmail($id, $toid, $important, $subject, $text){
        return $this->insertar("INSERT INTO mails (id_from, id_to, important, subject, text) VALUES ('$id', '$toid', '$important', '$subject', '$text')", TRUE);
    }
    
    public function obtenerPosiblesDestinatarios(){
        return $this->seleccionar("SELECT id, name, surname FROM users WHERE type!=2", TRUE);
    }
}
