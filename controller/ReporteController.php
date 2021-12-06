<?php
class ReporteController{
    private $reporteModel;
    private $printer;

    public function __construct($reporteModel, $printer)
    {
        $this->reporteModel = $reporteModel;
        $this->printer = $printer;
    }

    public function show()
    {   
        $data["tipo_role"] = $_SESSION["tipoUsuario"] == 2;
        $data["reserva"] = $this->reporteModel->getReservas();
       /* $data["reserva"]= $this->reporteModel->getSalidas();
        $data["reserva"]= $this->reporteModel->getDestino();*/
        echo $this->printer->render("view/reporteView.html",$data);
        
    }
}