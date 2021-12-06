<?php

class ValidarController
{
    private $validarModel;
    private $printer;

    public function __construct($validarModel, $printer)
    {
        $this->validarModel = $validarModel;
        $this->printer = $printer;
    }
    public function show()
    {
        echo $this->printer->render("view/validarView.html");
    }

    function controlarSesion()
    {
        if(!empty($_POST["usuario"]) && !empty($_POST["password"])){

            $array = $this->validarModel->getLogin($_POST["usuario"]);           
            
            if($array){ 
               header('Location: /ErrorValidacion'); 
               exit();         
            }
            elseif ($this->validarModel->getUsuario($_POST["usuario"]) && !empty($_POST["password"])) {
                $validacion = $this->validarModel->getUsuario($_POST["usuario"]);
                foreach ($validacion as $buscarArray) {
                    $_SESSION['usuario_id'] = $buscarArray["id"];
                    $_SESSION['tipoUsuario'] = $buscarArray["tipo_role"];
                    
                    if (password_verify($_POST["password"], $buscarArray["password"])) {
                        switch ($_SESSION['tipoUsuario']) {
                            case 2:
                               header('Location: /TurnoMedico');
                               exit;
                                break;
                            case 3:
                                header('Location: /TurnoMedico');
                                exit;
                                break;
                        }
                    }
                    else {
                       header('Location: /Error');
                       exit;
                    }
                }
            }
            else {
               header('Location: /Error');
               exit;
            }
        }
    } 

}
