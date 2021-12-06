<?php

class InicioController
{

    private $inicioModel;
    private $printer;

    public function __construct($inicioModel, $printer)
    {
        $this->inicioModel = $inicioModel;
        $this->printer = $printer;
    }

    public function show()
    {
        $data["locaciones"] = $this->inicioModel->getOrigen();
        $data["destinos"] = $this->inicioModel->getDestino();
        $data["vuelo"] = $this->inicioModel->getVuelos();
        echo $this->printer->render("view/inicioView.html", $data);
    }

    function verVuelo()
    {
        $data["vuelo"] = $this->buscarVueloModel->getBuscarVuelo();
        echo $this->printer->render("view/inicioView.html", $data);
    }
}
