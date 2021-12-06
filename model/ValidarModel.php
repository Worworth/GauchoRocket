<?php

class ValidarModel{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getLogin($email){
        return $this->database->query("SELECT email FROM sesion WHERE `email` = '$email'");
    }

    public function getUsuario($usuario){
        $SQL = "SELECT * FROM usuario WHERE email = '$usuario'";
        return $this->database->query($SQL);
    }
}    