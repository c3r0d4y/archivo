<?php
class SaveLogs extends Controllers
{
    function __construct(){
        parent::__construct();
    }
   
    public function getIP()
    {
    
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
    
    }
    
    public function insertLogs_m($tipo_log, $accion_log){
        $ip_log=$this->getIP();
        $pagina_log= $_SERVER['REQUEST_URI'];
       
        $usuario_log="Anonymous";
        if(isset($_SESSION['user']['nombre_usuario'])){
            $usuario_log= $_SESSION['user']['nombre_usuario'];
        }
        $rol_log="Anonymous";
        if(isset($_SESSION['user']['rol'])){
            $rol_log=$_SESSION['user']['rol'];
        }
        
        //Para verificar si la ip desde la que navegamos esta autorizada
        $dataIp =  $this->model->select_ip_m($ip_log);
        $ip=count($dataIp);
        //Si no esta autorizada la ip, salimos y alertamos
        if($ip==0){
            $accion_log="IP no autorizada";
            $tipo_log="IPNA";
            $data =  $this->model->insertLog_m($tipo_log, $accion_log, $pagina_log, $ip_log, $usuario_log, $rol_log);
            session_destroy();
        }else{

            $data =  $this->model->insertLog_m($tipo_log, $accion_log, $pagina_log, $ip_log, $usuario_log, $rol_log);
        }
    }
    
   
}
?>