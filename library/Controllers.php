<?php
 class Controllers
 {
    //Por defecto renderiza una vista
     public function __construct(){
         //invocamos el metodo estatico start de la clase Session
        Session::star();
        $this->view = new Views();
        $this->loadClassModels();//por defecto renderizamos un modelo
     }

     //checamos un modelo
     function loadClassModels(){
         $model = get_class($this).'_m';
         //echo "Modelos= ". $model."<br/>";
         $path = 'models/'.$model.'.php';
         if(file_exists($path)){
            
            require $path;
            //Invocamos la clase
            $this->model = new $model();
         }else{
             //Nota, si mandamos un error aqui, no nos redirigira a main
             //echo "No existe modelo => ". $model;
            }
     }
         
 }
 
?>