<?php
class SaveTime extends Controllers
{
    function __construct(){
        parent::__construct();
    }
    
    public function saveTime_M($id_usuario){
        $data =  $this->model->saveTime_M($id_usuario);
    }
    
   
}
?>