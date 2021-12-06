<?php

class BuscarVueloController
{
  private $buscarVueloModel;
  private $printer;

  public function __construct($buscarVueloModel, $printer)
  {
    $this->buscarVueloModel = $buscarVueloModel;
    $this->printer = $printer;
  }

  public function show()
  {
    $data["tipo_role"] = $_SESSION["tipoUsuario"] == 2;
    $data["nombre"] = $this->buscarVueloModel->getNombre($_SESSION["usuario_id"]);
    echo $this->printer->render("view/buscarVueloView.html", $data);
  }

  function procesarVuelo()
  {
    if (!empty($_POST["origen"]) && !empty($_POST["destino"])) {
      $data["vuelo"] = $this->buscarVueloModel->getBuscarVuelo($_POST["origen"], $_POST["destino"], $_POST["partida"], $_POST["regreso"]);
      echo $this->printer->render("view/vueloEncotradoView.html", $data);
    } 
    else {
      echo "usuario no registrado";
    }
  }

  function detalleVuelo()
  {
    $id = $_GET["id"];
    $data["vuelo"] = $this->buscarVueloModel->getVueloById($id);
    $data["asientos"] = $this->buscarVueloModel->getEstadoAsiento();
    echo $this->printer->render("view/reservaDetalleView.html", $data);
  }
}
