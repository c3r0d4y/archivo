<?php
 class Index extends Controllers
 {
    public function __construct(){
        //Invocamos el motodo constructor de la clase padre
        parent::__construct();
    }
    public function index(){
       //Para no regresar desde la flecha del navegador a login y permanecer en main miestras la session este abierta
       $user = $_SESSION["user"] ?? null;
      if(null != $user){
         //echo "<script>alert('entrar');</script>";
         $param='';
         $menu="";
         $this->view->render($this, "main_v", $menu, $param);
      }else{
         //echo "<script>alert('salida');</script>";
         $param='';
         $menu="index";
         $this->view->render($this, "index_v", $menu, $param);
      }
   }
        
 }
?>