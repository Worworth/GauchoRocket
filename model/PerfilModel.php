<?php

class PerfilModel{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }
    
    public function getDatos()
    {   
        $id=$_SESSION["usuario_id"];
        $sql=("SELECT * FROM usuario WHERE id='$id'");
       
    }
}