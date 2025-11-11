<?php
class saveTime_M extends Conexion{
    function __construct(){
        parent::__construct();
    }

    public function saveTime_M ($id_usuario){
        $tabla='usuarios';
        $where="WHERE id_usuario = $id_usuario";
        $values = "random = 1";
        $response = $this->db->update($tabla, $where, $values);
    }
    
}
?>