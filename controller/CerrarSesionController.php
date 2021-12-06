<?php

class CerrarSesionController{
   
    private $printer;
    
    public function __construct($printer)
    {
        $this->printer = $printer;
    }

    public function show()
    {
        echo $this->printer->render( "view/cerrarSesionView.html");
    }
    
    public function cerrarSesion()
    {   
        if(isset($_SESSION['usuario_id'])){
            
            session_unset();
            session_destroy();
            header("Location: /CerrarSesion");
            die();
            
        }else{
            header("Location: /Login");
            die();
        }
    }
}