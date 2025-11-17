<?php
class SaveTime extends Controllers
{
    function __construct(){
        parent::__construct();
    }
    public function guardaTiempo($id_usuario){
        $data =  $this->model->guardaTiempo_m($id_usuario);
    }
}
?>