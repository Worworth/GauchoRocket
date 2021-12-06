<?php

class VueloModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getTurnoByFilter($filter){
        $query = "SELECT * FROM turno_medico WHERE cliente_id LIKE '%" . $filter . "%' OR centro_medico_id LIKE '%" . $filter . "%' OR resultado LIKE '%" . $filter . "%' ";
        return $this->database->query($query);
    }

    public function getVuelos(){
        return $this->database->query("SELECT l.id as id_origen, d.id as id_destino, h.hora AS horario ,v.id AS CodigoVuelo, l.descripcion AS origen,d.descripcion AS destino ,e.descripcion AS estado from vuelo v
            INNER JOIN locaciones l ON v.id_origen = l.id
            INNER JOIN destinos d ON v.id_destino = d.id 
            INNER JOIN estado_vuelo e ON v.id_estado = e.id
            INNER JOIN horarios_vuelo h ON v.id_horario = h.id");
    }
}