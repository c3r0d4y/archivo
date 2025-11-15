<?php
class SaveLogs_M extends Conexion{
    function __construct(){
        parent::__construct();
    }
    public function insertLog_m ($tipo_log, $accion_log, $pagina_log, $ip_log, $usuario_log, $rol_log){   
        $tabla='logs';
        $campos='tipo_log, accion_log, pagina_log, ip_log, usuario_log, rol_log';
        $values = "'$tipo_log', '$accion_log', '$pagina_log', '$ip_log', '$usuario_log', '$rol_log'";
        $response = $this->db->insert($tabla, $campos, $values, 0);      
    }
    function select_ip_m($ip_log){
        $column='*';
        $tabla='ip_autorizadas';
        $where=" WHERE ip='$ip_log'";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
     }
}
?>