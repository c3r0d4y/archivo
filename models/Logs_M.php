<?php
class Logs_M extends Conexion{
    function __construct(){
        parent::__construct();
    }
    function getLogs_m($tipoBusqueda, $usuario, $documento, $fechaInicio, $fechaFin){
        $column="*";
        $tabla="logs";
        $where="";

        if($tipoBusqueda=="pornumero"){
            $where=" WHERE accion_log LIKE '%$documento%' ORDER BY id_log DESC LIMIT 500";
        }elseif($tipoBusqueda=="pornombre"){
            $where=" WHERE usuario_log LIKE '%$usuario%' ORDER BY id_log DESC LIMIT 500";
        }elseif($tipoBusqueda=="porperiodo"){
            if($fechaInicio!="" && $fechaFin==""){
                $where=" WHERE date(fechaHora)='$fechaInicio' ORDER BY id_log DESC LIMIT 500";
            }
            elseif($fechaInicio!="" && $fechaFin!=""){
                $where=" WHERE fechaHora BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY id_log DESC LIMIT 500";
            }else{
                 $where=" WHERE 1 ORDER BY id_log DESC LIMIT 500";
            }
        }elseif($tipoBusqueda=="pornombreyperiodo"){
            //Solo nombre
            if($usuario!="" && $fechaInicio=="" && $fechaFin==""){
                $where=" WHERE accion_log LIKE '%$documento%' ORDER BY id_log DESC LIMIT 500";
            }
            //Solo una fecha
            elseif($usuario!="" && $fechaInicio!="" && $fechaFin==""){
                $where=" WHERE date(fechaHora)='$fechaInicio' ORDER BY id_log DESC LIMIT 500";
            }//Por intervalo de fechas
            elseif($usuario!="" && $fechaInicio!="" && $fechaFin!=""){
                $where=" WHERE fechaHora BETWEEN '$fechaInicio' AND '$fechaFin' ORDER BY id_log DESC LIMIT 500";
            }
            else{
                 $where=" WHERE 1 ORDER BY id_log DESC LIMIT 500";
            }
        }
        /*if($usuario!=""){
            $where=" WHERE usuario_log LIKE '%$usuario%' ORDER BY id_log DESC LIMIT 500";
        }elseif($documento!=""){
            $where=" WHERE accion_log LIKE '%$documento%' ORDER BY id_log DESC LIMIT 500";
        }
        elseif($fechaInicio!=""){
            $where=" WHERE date(fechaHora)='$fechaInicio' ORDER BY id_log DESC LIMIT 500";
        }else{
            $where=" WHERE 1 ORDER BY id_log DESC LIMIT 500";
        }*/

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