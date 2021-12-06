<?php

class Session{
    
    public function __construct(){
        if(!isset($_SESSION['usuario_id'])){
        header('Location: /Login');
        die();
        }
    }
}