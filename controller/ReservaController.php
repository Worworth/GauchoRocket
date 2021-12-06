<?php
require('./public/fpdf/fpdf.php');
require('./public/phpqrcode/qrlib.php');

class ReservaController
{
    private $reservaModel;

    private $printer;

    public function __construct($reservaModel, $printer)
    {
        $this->reservaModel = $reservaModel;
        $this->printer = $printer;
    }

    public function show()
    {   
        $data["tipo_role"] = $_SESSION["tipoUsuario"] == 2;
        $id = $_SESSION["usuario_id"];
        $data["reserva"] = $this->reservaModel->getReserva($id);
        echo $this->printer->render("view/reservaView.html", $data);
    }

    public function buscar()
    {
        $id = $_SESSION["usuario_id"];
        $filtro = $_GET["busqueda"];
        $data["reservas"] = $this->reservaModel->getReservaByFilter($filtro);

        if (!empty($data["reservas"])) {
            $data["reservas"] = $this->reservaModel->getReserva($id);
            $data["error"] = true;
        }

        echo $this->printer->render("view/reservaView.html", $data);
    }

    public function cancelarReserva()
    {
        $id = $_POST["codigo_reserva"];
        $this->reservaModel->eliminarReserva($id);
        header("location:/Reserva");
        exit;
    }

    public function cargarReserva()
    {
        $array = $this->reservaModel->getEstadoMedico($_SESSION["usuario_id"]);
        if ($array) { 
            $pasajero = $_SESSION["usuario_id"];
            $permited_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTWXYZ';
            $codigoReserva = substr(str_shuffle($permited_chars), 0, 8);
            $servicio = $_POST["servicio"];
            $asiento = $_POST["cabina"];
            $origen = $_POST["origen"];
            $destino = $_POST["destino"];
            $fechaPartida = $_POST["fechaPartida"];
            $fechaRegreso = $_POST["fechaRegreso"];
            $id_vuelo = $_POST["codigoVuelo"];
            $this->reservaModel->insertarReserva($pasajero, $origen, $destino, $fechaPartida, $fechaRegreso, $id_vuelo, $asiento, $servicio, $codigoReserva);
            $this->reservaModel->updateAsiento($asiento);
            header('Location:/Reserva');

        } else {
            echo $this->printer->render("view/revisionTurnoView.html");
        }
    }

    public function generarComprobante(){
        
        $id = $_GET["id"];
        $usuario=$_SESSION["usuario_id"];
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetY(30);
        $pdf->Image('public/logogauchorocket.png',85,15,40);
        $pdf->Cell(0, 8, 'GAUCHO ROCKET', 0, 0, 'C');
        $pdf->Ln(25);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(173, 173, 173);
        $pdf->Cell(1);
        $pdf->Cell(190, 10, 'Comprobante de  reserva-GAUCHO ROCKET', 0, 0, 'L',1);
        $pdf->Ln(10);
        $pdf->SetFillColor(33, 150, 243);
        $pdf->Cell(1);
        $pdf->Cell(190, 10, 'El estado de su reserva es: CONFIRMADA', 0, 0, 'C',1);
        $pdf->Ln(10);
        $pdf->Cell(1);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(190, 30, 'Su numero de reserva es:', 0, 0, 'L',1);
        $pdf->SetX(100);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetTextColor( 255, 255, 255);
        $datos= $this->reservaModel->getReservaById($id);
        foreach ($datos as $datosReserva){

            $pdf->Cell(0, 30, $datosReserva["codigo_reserva"], 0, 0, 'L',1);
            $pdf->Ln(10);
            $pdf->Cell(1);
        }
        $pdf->Ln(30);
        $pdf->SetFont('Arial', '', 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetX(150);
        $pdf->Ln(5);
        $pdf->SetX(150);
        $pdf->SetFont('Arial', '', 20);
        $pdf->SetX(10);
        $pdf->Cell(50, 10, 'Datos empresa', 0, 0, 'L');
        $pdf->Cell(90);
        $pdf->Cell(50, 10, 'Tarifa:', 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20, 10, 'Nombre:', 0, 0, 'L');
        $pdf->Cell(20, 10, 'GauchoRocket SA', 0, 0, 'L');
        $pdf->Cell(100);
        $pdf->SetFont('Arial', '', 16);
        $pdf->Cell(50, 20, '$5000', 0, 0, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(15, 10, 'Email:', 0, 0, 'L',1);
        $pdf->Cell(20, 10, 'gauchorocketviajes@gmail.com', 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->Cell(20, 10, 'Telefono:', 0, 0, 'L');
        $pdf->Cell(20, 10, '4664-5569', 0, 0, 'L');
        $pdf->Ln(10);
        $pdf->Cell(25, 10, 'Pagina Web:', 0, 0, 'L');
        $pdf->Cell(20, 10, 'www.gauchorocket.com', 0, 0, 'L');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 20);
        $pdf->Cell(190, 10, 'Datos cliente', 0, 0, 'L');
        $datos=$this->reservaModel->getUsuarioById($usuario);
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(255, 255, 255);
        foreach ($datos as $datosUsuario) {

            $pdf->Cell(20, 10, 'Nombre:', 0, 0, 'L',1);
            $pdf->Cell(30, 10, $datosUsuario["nombre"], 0, 0, 'C');
            $pdf->Ln(10);
            $pdf->Cell(20, 10, 'Apellido', 0, 0, 'L',1);
            $pdf->Cell(30, 10, $datosUsuario["apellido"], 0, 0, 'C');
            $pdf->Ln(10);
            $pdf->Cell(20, 10, 'Email:', 0, 0, 'L',1);
            $pdf->Cell(60, 10, $datosUsuario["email"], 0, 0, 'C');
            $pdf->Ln(10);
            $pdf->Cell(20, 10, 'Telefono:', 0, 0, 'L',1);
            $pdf->Cell(30, 10, $datosUsuario["telefono"], 0, 0, 'C');
        
        }
        $pdf->Ln(20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(173, 173, 173);
        $pdf->Cell(1);
        $pdf->Cell(30, 10, 'ORIGEN', 0, 0, 'C', 1);
        $pdf->Cell(40, 10, 'DESTINO', 0, 0, 'C', 1);
        $pdf->Cell(60, 10, 'FECHA SALIDA', 0, 0, 'C', 1);
        $pdf->Cell(60, 10, 'FECHA REGRESO', 0, 0, 'C', 1);
        $pdf->Ln(10);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(1);
        $datos= $this->reservaModel->getReservaById($id);
        foreach ($datos as $datosReserva) {

            $pdf->Cell(30, 10, $datosReserva["origen"], 1, 0, 'C', 1);
            $pdf->Cell(40, 10, $datosReserva["destino"], 1, 0, 'C', 1);
            $pdf->Cell(60, 10, $datosReserva["fecha_partida"], 1, 0, 'C', 1);
            $pdf->Cell(60, 10, $datosReserva["fecha_regreso"], 1, 0, 'C', 1);
            $pdf->Ln(10);
            $pdf->Cell(1);
        }     
        $pdf->Output("Reporte.pdf", 'I');  
    }

    public function generarBoarding()
    {
        $id = $_GET["id"];
        $codigo_reserva="";
        $datos = $this->reservaModel->getReservaById($id);
        
        foreach ($datos as $buscarArray) {
            $codigo_reserva = $buscarArray["codigo_reserva"];
        }

        $dir = 'public/temp/';
        if (!file_exists($dir))
            mkdir($dir);

        $filename = $dir . $codigo_reserva . '.png';
        $tamanio = 10;
        $level = 'M';
        $frameSize = 3;
        $contenido = $codigo_reserva;

        QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetY(30);
        $pdf->Cell(0, 8, 'BOARDING PASS', 0, 0, 'C');
        $pdf->Ln(60);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Ln(10);
        $pdf->SetFillColor(16, 121, 176);
        $pdf->SetDrawColor(163, 163, 163);
        $pdf->Cell(1);
        $pdf->Cell(30, 10, 'NOMBRE', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'APELLIDO', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'ORIGEN', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'DESTINO', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'FECHA SALIDA', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'FECHA REGRESO', 1, 0, 'C', 1);
        $pdf->Ln(10);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(1);
        foreach ($datos as $datosReserva) {

            $pdf->Cell(30, 10, $datosReserva["nombre"], 1, 0, 'C', 1);
            $pdf->Cell(30, 10, $datosReserva["apellido"], 1, 0, 'C', 1);
            $pdf->Cell(30, 10, $datosReserva["origen"], 1, 0, 'C', 1);
            $pdf->Cell(35, 10, $datosReserva["destino"], 1, 0, 'C', 1);
            $pdf->Cell(35, 10, $datosReserva["fecha_partida"], 1, 0, 'C', 1);
            $pdf->Cell(35, 10, $datosReserva["fecha_regreso"], 1, 0, 'C', 1);
            $pdf->Ln(10);
            $pdf->Cell(1);
        }

        $pdf->Ln(10);
        $pdf->Image($filename, 80, 40, 50, 50);
        $pdf->Output();
    }
}
