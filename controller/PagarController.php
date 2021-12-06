<?php

require('./vendor/autoload.php');

class PagarController
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
        $id = $_SESSION["usuario_id"];
        $data["reserva"] = $this->reservaModel->getReserva($id);
        $data["preference"] = $this->pagarReserva();
        echo $this->printer->render("view/reservaView.html", $data);
    }

    public function pagarReserva()
    {
        $id = $_GET["id"];
        $tarifa = 0;
        $array = $this->reservaModel->getReservaPago($id);

        foreach ($array as $buscarArray) {
            $tarifa = $buscarArray["tarifa"];
        }

        // Agrega credenciales
        MercadoPago\SDK::setAccessToken('TEST-5664174026785053-111812-aa66282f2fee842cd0ac5f7e50efcede-28978189');
        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();
        $datos = array();

        // Crea un ítem en la preferencia
        for ($x = 0; $x < 10; $x++) {

            $item = new MercadoPago\Item();
            $item->title = 'Pantalon';
            $item->description = 'Vuelo Gaucho Rocket';
            $item->quantity = 1;
            $item->unit_price = $tarifa;
            $preference->back_urls = array(
                "success" => "http://localhost:8080/Pagar/confirmar"
            );
            $datos[] = $item;
        }

        $preference->items = $datos;
        $preference->save();
        $data["preference"] = $preference;
        echo $this->printer->render("view/pagarView.html", $data);
    }

    public function confirmar()
    {
        $_SESSION["usuario_id"];
        $pago = $_GET["status"];

        if ($pago == "approved") {
            $this->reservaModel->updateReserva($_SESSION["usuario_id"]);
            header('Location:/Reserva');
            exit;
        }
    }
}
