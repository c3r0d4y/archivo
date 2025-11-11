<?php
class Logs_M extends Conexion{
    function __construct(){
        parent::__construct();

     }
    function getLogs_m($usuario, $documento, $fecha){
        $column="*";
        $tabla="logs";
        
        if($usuario!=""){
            $where=" WHERE usuario_log LIKE '%$usuario%' ORDER BY id_log DESC";
        }elseif($documento!=""){
            $where=" WHERE accion_log LIKE '%$documento%' ORDER BY id_log DESC LIMIT 100";
        }
        elseif($fecha!=""){
            $where=" WHERE date(fechaHora)='$fecha' ORDER BY id_log DESC LIMIT 100";
        }else{
            $where=" WHERE 1 ORDER BY id_log DESC LIMIT 100";
        }
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);

        return($ask);
    }
    function get_tigger_M(){
        $column="estado";
        $tabla="lanzadores";
        $where=" WHERE nombre = 'logs'";
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($ask);
     }
}
?>