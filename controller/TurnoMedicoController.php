<?php

class TurnoMedicoController{
    private $turnoMedicoModel;
    private $printer;
    private $mail;

    public function __construct($mail,$turnoMedicoModel,$printer)
    {
        $this->turnoMedicoModel = $turnoMedicoModel;
        $this->printer = $printer;
        $this->mail = $mail;
    }

    public function show(){   

        $data["turno_medico"] = $this->turnoMedicoModel->listarTurno();
        $data["turno_diario"] = $this->turnoMedicoModel->getTurnoDiarioBuenosAires();
        $data["turno_ankara"] = $this->turnoMedicoModel->getTurnoDiarioAnkara();
        $data["turno_Shanghai"] = $this->turnoMedicoModel->getTurnoDiarioShanghai();
        
        $data["tipo_role"] = $_SESSION["tipoUsuario"] == 2;
        $data["nombre"]= $this->turnoMedicoModel->getNombre($_SESSION["usuario_id"]);
        echo $this->printer->render( "view/turnoMedicoView.html", $data);
    }

    public function getDetail(){
        $id = $_GET["id"];
        $data ["turno_medico"] = $this->turnoMedicoModel->getTurno($id);
        echo $this->printer->render("view/resultadoMedicoView.html", $data);
    }

    public function registrarTurno(){
        $array=$this->turnoMedicoModel->getMail($_SESSION["usuario_id"]);
         
        foreach ($array as $buscarMail) {
            $mailUsuario=$buscarMail["email"];
        }
        if(!empty($_POST["name"]) && !empty($_POST["country"]) && !empty($_POST["fechaTurno"])){
            $_SESSION["country"] = $_POST["country"];
            $testMedico=mt_rand(1,100);            
            if ($testMedico >= 60) {

                $cliente = "Tipo 3";
            } elseif($testMedico >10 && $testMedico <30) {
               
                $cliente = "Tipo 2";
            }else{
                $cliente = "Tipo 1";
            }
               
            switch ($_SESSION["country"]) {
            
                case 1001:
                    //$_SESSION["country"] = "Buenos Aires";
                    $centroMedico="Buenos Aires";
                    $this->turnoMedicoModel->insertarTurno($_SESSION["usuario_id"],$_POST["fechaTurno"],$_SESSION["country"],$cliente);
                    $this->mail->enviarTurnoMedico($mailUsuario,$_POST["name"],$centroMedico,$_POST["fechaTurno"],$cliente);
                    echo $this->printer->render( "view/registroMedicoView.html");              
                      break;
                case 1002:
                    //$_SESSION["country"] = "Ankara";
                    $centroMedico="Ankara";
                    $this->turnoMedicoModel->insertarTurno($_SESSION["usuario_id"],$_POST["fechaTurno"],$_SESSION["country"],$cliente);
                    $this->mail->enviarTurnoMedico($mailUsuario,$_POST["name"],$centroMedico,$_POST["fechaTurno"],$cliente);
                    echo $this->printer->render( "view/registroMedicoView.html");
                    
                    break;
                case 1003:
                    //$_SESSION["country"] = "Shanghai";
                    $centroMedico="Shanghái";
                    $this->turnoMedicoModel->insertarTurno($_SESSION["usuario_id"],$_POST["fechaTurno"],$_SESSION["country"],$cliente);
                    $this->mail->enviarTurnoMedico($mailUsuario,$_POST["name"],$centroMedico,$_POST["fechaTurno"],$cliente);
                    echo $this->printer->render( "view/registroMedicoView.html");   

                    break;
            }    
        }
    }

    public function controlTurno()
    {
        $data ["turno"] = $this->turnoMedicoModel->cantidadTurno();
        echo $this->printer->render("view/resultadoMedicoView.html", $data);
    }

}