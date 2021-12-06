<?php
class ReservaModel{
    private $database;

    public function __construct($database){
        $this->database = $database;
    
    }
    public function getNombre($id){
        return $this->database->query("SELECT nombre FROM usuario WHERE id='$id'");
    }
    public function insertarReserva($pasajero, $origen, $destino, $fechaPartida, $fechaRegreso, $id_vuelo, $asiento, $servicio, $codigoReserva){
            return $this->database->execute("INSERT INTO `reservas` (`pasajero`, `cantidad`, `tarifa`, `id_origen`, `id_destino`, `fecha_partida`, `fecha_regreso`, `id_vuelo`, `id_asiento`, `id_reserva_tour`, `servicio`, `codigoReserva`, `estadoReserva`, `descripcion`) VALUES ('$pasajero', '1', '500', '$origen', '$destino', '$fechaPartida', '$fechaRegreso', '$id_vuelo', '$asiento', '1', '$servicio', '$codigoReserva', '1', 'vigente')");
    }

    public function getReserva($id){
        return $this->database->query("SELECT r.id as numero_reserva, u.nombre as nombre, u.apellido as apellido, l.descripcion as origen, d.descripcion as destino, v.id as numero_vuelo, v.fecha_partida as fecha_partida, v.fecha_regreso as fecha_regreso, s.tipo as servicio, r.codigoReserva as codigo_reserva, er.descripcion as estado
        FROM reservas r
        inner join usuario u on r.pasajero = u.id
        inner join locaciones l on r.id_origen = l.id
        inner join destinos d on r.id_destino = d.id
        inner join servicios s on r.servicio = s.id
        inner join vuelo v on r.id_vuelo = v.id
        inner join estado_reserva er on r.estadoReserva = er.id
        where r.pasajero = $id");
    }

    public function getReservaById($id){
        return $this->database->query("SELECT r.id as numero_reserva, u.nombre as nombre, u.apellido as apellido, l.descripcion as origen, d.descripcion as destino, v.id as numero_vuelo, v.fecha_partida as fecha_partida, v.fecha_regreso as fecha_regreso, s.tipo as servicio, r.codigoReserva as codigo_reserva
        FROM reservas r
        inner join usuario u on r.pasajero = u.id
        inner join locaciones l on r.id_origen = l.id
        inner join destinos d on r.id_destino = d.id
        inner join servicios s on r.servicio = s.id
        inner join vuelo v on r.id_vuelo = v.id
        where r.id = $id");
    }

    public function getReservas(){
        return$this->database->query("SELECT * FROM reservas");
    }

    public function getReservaByFilter($filter){
        $query = "SELECT * FROM reservas r WHERE r.codigoReserva LIKE '%" . $filter . "%'";
        return $this->database->query($query);
    }

    public function getFechaReserva($pasajero){
        return $this->database->query("SELECT * FROM reservas WHERE pasajero = '$pasajero'");
    }

    public function getTipoCabina(){
        return $this->database->query("SELECT descripcion FROM tipo_cabina WHERE id='1'");
    }

    public function getTipoServicio(){
        return $this->database->query("SELECT descripcion FROM tipo_servicio WHERE id='2'");
    }

    public function getCodigoReserva($code){
        return $this->database->query("SELECT codigoReserva FROM reservas WHERE codigoReserva='$code'");
    }

    public function cambiaEstadoReserva($codRese){
        return $this->database->query("UPDATE `reservas` SET estadoReserva = '1' WHERE codigoReserva='$codRese'");
    }

    public function eliminarReserva($codRese){   
    return $this->database->execute("DELETE FROM `reservas` WHERE codigoReserva='$codRese'");
    }
    
    public function verEstado($codigo){
        $SQL=("SELECT estadoReserva FROM reservas WHERE codigoReserva='$codigo'");
        return $this->database->query($SQL);
    }

    public function getEstadoMedico($id){
        return $this->database->query("SELECT * FROM turno_medico WHERE `usuario_id` = '$id' ");
    }

    public function getReservaPago($id){
        return $this->database->query("SELECT r.id , r.tarifa as tarifa
        FROM reservas r
        where r.id = '$id' ");
    }

    public function updateReserva($id){
        return $this->database->execute("UPDATE `reservas` rs SET `estadoReserva` = '2' WHERE `pasajero` = '$id'");
    }

    public function updateAsiento($asiento){
        return $this->database->execute("UPDATE `asientos` SET `disponibilidad` = 'disabled' WHERE `id` = '$asiento'");
    }

    public function getUsuarioById($id){
        return $this->database->query("SELECT * FROM usuario WHERE id='$id'");
    }
}