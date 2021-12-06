<?php
class VueloController
{
    private $vueloModel;
    private $printer;

    public function __construct($vueloModel, $printer)
    {
        $this->vueloModel = $vueloModel;
        $this->printer = $printer;
    }

    public function show()
    {
        $data["vuelo"] = $this->vueloModel->getVuelos();
        $data["tipo_role"] = $_SESSION["tipoUsuario"] == 2;
        echo $this->printer->render("view/vuelosView.html", $data); 
    }
}
