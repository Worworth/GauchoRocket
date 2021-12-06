<?php

class TurnoMedicoModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }
    public function getTurnoByFilter($filter){
        $query = "SELECT * FROM turno_medico WHERE cliente_id LIKE '%" . $filter . "%' OR centro_medico_id LIKE '%" . $filter . "%' OR resultado LIKE '%" . $filter . "%' ";
        return $this->database->query($query);
    }
    public function getTurnos(){
        return $this->database->query("SELECT * FROM turno_medico");
    }
    public function getTurnoDiarioBuenosAires(){
        return $this->database->query("SELECT COUNT(id) as turnoDiario FROM `turno_medico` WHERE `centro_medico_id` = 1001");
    }
    public function getTurnoDiarioAnkara(){
        return $this->database->query("SELECT COUNT(id) as turnoDiario FROM `turno_medico` WHERE `centro_medico_id` = 1002");
    }
    public function getTurnoDiarioShanghai(){
        return $this->database->query("SELECT COUNT(id) as turnoDiario FROM `turno_medico` WHERE `centro_medico_id` = 1003");
    }
    
    public function getTurno($id){
        $SQL = "SELECT u.id,u.nombre,u.apellido , t.fecha, t.resultado , cm.descripcion FROM usuario u 
        INNER JOIN turno_medico t ON u.id = t.usuario_id 
        INNER JOIN centro_medico cm ON cm.id = t.centro_medico_id WHERE u.id = $id ";
        return $this->database->query($SQL);
    }
    public function getMail($id){
        return $this->database->query("SELECT email FROM usuario WHERE id='$id'");
    }
    public function getNombre($id){
        return $this->database->query("SELECT nombre FROM usuario WHERE id='$id'");
    }
    public function insertarTurno($id,$fecha,$country,$cliente){
       $SQL = ("INSERT INTO `turno_medico` (`usuario_id`, `fecha`, `centro_medico_id`, `resultado`) VALUES ('$id', '$fecha', $country,'$cliente')");
       return $this->database->insert($SQL);
    }
    public function cantidadTurno(){
        $SQL = ("SELECT COUNT(centro_medico_id) AS cantidadTurno from turno_medico WHERE `centro_medico_id` = 1002");
        return $this->database->execute($SQL);
    }
    public function listarTurno(){
        $SQL = ("SELECT u.id,u.nombre,u.apellido , t.fecha, t.resultado , cm.descripcion FROM usuario u 
        INNER JOIN turno_medico t ON u.id = t.usuario_id 
        INNER JOIN centro_medico cm ON cm.id = t.centro_medico_id");
        return $this->database->query($SQL);
    }
}