<?php

class LoginModel{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getLogin(){
        return $this->database->query("SELECT * FROM usuario");
    }
    
    public function insertarLogin($nombre,$usuario,$email,$password,$apellido,$telefono,$tipoRole){
      return $this->database->execute("INSERT INTO `usuario` (`id`, `email`, `usuario`,`password`, `nombre`, `apellido`, `telefono`, `tipo_role`) VALUES (NULL, '$nombre', '$usuario', '$email', '$password', '$apellido', '$telefono','$tipoRole')");                                                                                     
    }

    public function insertarLoginSesion($email,$session_data){
        return $this->database->execute("INSERT INTO `sesion` (`email`,`valor`) VALUES ('$email','$session_data')");                                                                                          
    }

    public function insertarCliente($session_nombre,$session_apellido){
        return $this->database->execute("INSERT INTO `cliente` (`id`,`nombre`, `apellido`, `codigo_chequeo`, `nivel_vuelo_id`) VALUES (NULL, '$session_nombre', '$session_apellido', NULL, NULL)");                                                                                    
    }

    public function borrar($valor){
        $query = "DELETE FROM `sesion` WHERE `sesion`.`valor` = '$valor'";
        return $this->database->execute($query);
    }
}
