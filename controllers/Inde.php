<?php
 class Inde extends Controllers
 {
    public function __construct(){
        //Invocamos el motodo constructor de la clase padre
        parent::__construct();
    }
    public function inde(){
       //Para no regresar desde la flecha del navegador a login y permanecer en main miestras la session este abierta
       
         $param='';
         $menu="1";
         $this->view->render($this, "inde_v", $menu, $param);
         
      
   }
        
 }
?>