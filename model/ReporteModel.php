<?php
class ReporteModel{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }
    public function getReservas(){
        /* return $this->database->query("SELECT distinct d.descripcion as destino, u.nombre as nombre
        FROM reservas r
        inner join usuario u on r.pasajero = u.id
        inner join locaciones l on r.id_origen = l.id
        inner join destinos d on r.id_destino = d.id
        inner join servicios s on r.servicio = s.id
        inner join vuelo v on r.id_vuelo = v.id"); */
        return $this->database->query("SELECT COUNT(id_destino)
        FROM reservas
        WHERE id_destino = 5;");
    }
    public function getReservas1(){
        return $this->database->query("SELECT distinct d.descripcion as destino1, u.nombre as nombre
        FROM reservas r
        inner join usuario u on r.pasajero = u.id
        inner join locaciones l on r.id_origen = l.id
        inner join destinos d on r.id_destino = d.id
        inner join servicios s on r.servicio = s.id
        inner join vuelo v on r.id_vuelo = v.id");
    }
    public function getSalidas(){
        return $this->database->query("SELECT COUNT(id_origen) as bs FROM reservas
        WHERE id_origen='1' ");
    }
    public function getDestino(){
        return $this->database->query("SELECT COUNT(id_destino) as ence FROM reservas
        WHERE id_destino='5' ");
    }

}