<?php

use PHPMailer\PHPMailer\PHPMailer;

class Configuration
{

    private $config;
    public function createPerfilController()
    {   
        require_once("controller/PerfilController.php");
        return new PerfilController($this->createPerfilModel(),$this->createPrinter(), $this->createSession());
    }
    public function createReporteController()
    {
        require_once("controller/ReporteController.php");
        return new ReporteController($this->createReporteModel(),$this->createPrinter(), $this->createSession());
    }

    public function createTurnoMedicoController()
    {
        require_once("controller/TurnoMedicoController.php");
        return new TurnoMedicoController($this->createMailController(), $this->createTurnoMedicoModel(), $this->createPrinter(), $this->createSession());
    }
    public function createVueloController()
    {
        require_once("controller/VueloController.php");
        return new VueloController($this->createVueloModel(), $this->createPrinter(), $this->createSession());
    }

    public  function createLoginController()
    {
        require_once("controller/LoginController.php");
        return new LoginController($this->createMailController(), $this->createLoginModel(), $this->getLogger(), $this->createPrinter());
    }

    public  function createValidarController()
    {
        require_once("controller/ValidarController.php");
        return new ValidarController($this->createValidarModel(), $this->getLogger(), $this->createPrinter());
    }

    public function createCerrarSesionController()
    {
        require_once("controller/CerrarSesionController.php");
        return new CerrarSesionController($this->createPrinter());
    }
    public function createInicioController()
    {
        require_once("controller/InicioController.php");
        return new InicioController($this->createInicioModel(), $this->createPrinter());
    }
    public function createReservaController()
    {
        require_once("controller/ReservaController.php");
        return new ReservaController($this->createReservaModel(), $this->createPrinter(), $this->createSession());
    }

    public function createPagarController()
    {
        require_once("controller/PagarController.php");
        return new PagarController($this->createReservaModel(), $this->createPrinter(), $this->createSession());
    }

    public function createBuscarVueloController()
    {
        require_once("controller/BuscarVueloController.php");
        return new BuscarVueloController($this->createBuscarVueloModel(), $this->createPrinter(), $this->createSession());
    }

    public function createErrorController()
    {
        require_once("controller/ErrorController.php");
        return new ErrorController($this->createPrinter());
    }

    public function createErrorValidacionController()
    {
        require_once("controller/ErrorValidacionController.php");
        return new ErrorValidacionController($this->createPrinter());
    }
    private function createPerfilModel()
    {
        require_once("model/PerfilModel.php");
        $database= $this->getDatabase();
        return new PerfilModel($database);
    }

    private function createReporteModel()
    {
        require_once("model/ReporteModel.php");
        $database= $this->getDatabase();
        return new ReporteModel($database);
    }
    private  function createBuscarVueloModel()
    {
        require_once("model/BuscarVueloModel.php");
        $database = $this->getDatabase();
        return new BuscarVueloModel($database);
    }

    private  function createReservaModel()
    {
        require_once("model/ReservaModel.php");
        $database = $this->getDatabase();
        return new ReservaModel($database);
    }

    private  function createTurnoMedicoModel()
    {
        require_once("model/TurnoMedicoModel.php");
        $database = $this->getDatabase();
        return new TurnoMedicoModel($database);
    }
    private  function createVueloModel()
    {
        require_once("model/VueloModel.php");
        $database = $this->getDatabase();
        return new VueloModel($database);
    }

    private  function createLoginModel()
    {
        require_once("model/LoginModel.php");
        $database = $this->getDatabase();
        return new LoginModel($database);
    }
    private  function createInicioModel()
    {
        require_once("model/InicioModel.php");
        $database = $this->getDatabase();
        return new InicioModel($database);
    }

    private  function createValidarModel()
    {
        require_once("model/ValidarModel.php");
        $database = $this->getDatabase();
        return new ValidarModel($database);
    }

    private  function getDatabase()
    {
        require_once("helpers/MyDatabase.php");
        $config = $this->getConfig();
        return new MyDatabase($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    }

    private  function getConfig()
    {
        if (is_null($this->config))
            $this->config = parse_ini_file("config/config.ini");

        return  $this->config;
    }

    private function getLogger()
    {
        require_once("helpers/Logger.php");
        return new Logger();
    }

    private function createMailController()
    {
        require_once("controller/MailController.php");
        require_once("helpers/PHPMailer.php");
        require_once("helpers/Exception.php");
        require_once("helpers/SMTP.php");

        return new MailController();
    }


    public function createRouter($defaultController, $defaultAction)
    {
        include_once("helpers/Router.php");

        return new Router($this, $defaultController, $defaultAction);
    }

    private function createPrinter()
    {
        require_once('third-party/mustache/src/Mustache/Autoloader.php');
        require_once("helpers/MustachePrinter.php");
        return new MustachePrinter("view/partials");
    }
    private function createSession(){
        require_once("helpers/session.php");
        return new Session();
    }
}
