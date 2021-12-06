<?php
class BuscarVueloModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getNombre($id)
    {
        return $this->database->query("SELECT nombre FROM usuario WHERE id='$id'");
    }
    
    public function getBuscarVuelo($id_origen, $id_destino, $fecha_partida, $fecha_regreso)
    {
        return $this->database->query("SELECT h.hora AS horario ,h.h_fecha_partida AS fechaPartida,h.h_fecha_regreso AS fechaRegreso,v.id AS CodigoVuelo, l.descripcion AS origen,d.descripcion AS destino ,e.descripcion AS estado from vuelo v
        INNER JOIN locaciones l ON v.id_origen = l.id
        INNER JOIN destinos d ON v.id_destino = d.id 
        INNER JOIN estado_vuelo e ON v.id_estado = e.id
        INNER JOIN horarios_vuelo h ON v.id_horario = h.id WHERE h_fecha_partida >= '$fecha_partida' and h_fecha_regreso <= '$fecha_regreso'");
    }
    public function buscarFechaVuelo($fecha_partida, $fecha_regreso)
    {
        return $this->database->query("SELECT * FROM horarios_vuelo h 
        INNER JOIN vuelo v ON h.id = v.id_horario
        WHERE h.h_fecha_partida >= '$fecha_partida'AND h.h_fecha_regreso <='$fecha_regreso' ");
    }
    public function getVuelo()
    {
        return $this->database->query("SELECT * FROM `vuelo`");
    }
    public function getVueloById($id)
    {
        $query = "SELECT v.id as numero_vuelo, l.id as id_origen, d.id as id_destino, l.descripcion as origen, d.descripcion as destino, v.fecha_partida as fecha_partida, v.fecha_regreso as fecha_regreso, hv.dia as dia, hv.hora as hora
        from vuelo v
        inner join locaciones l on v.id_origen = l.id
        inner join destinos d on d.id = v.id
        inner join horarios_vuelo hv on v.id_horario = hv.id
        where v.id = $id";
        
        return $this->database->query($query);
    }

    public function getEstadoAsiento(){
        return $this->database->query("SELECT disponibilidad, nombre, id FROM `asientos`");
    }
}
