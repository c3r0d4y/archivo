<?php
    require "config.php";//Aqui estan las constantes
    //Recibimos los datos redireccionados por  htacces y si no hay datos pasamos el controlador index, 
   $url = $_GET['url'] ?? header("Location:".URL."Index/index");
   //Con este metodo separamos los datos recibidos separados por /
   $url = explode("/", $url);

   $controller = "";
   $method = "";
    
    //Checamos si contiene un controlador en la posicion 0 de la url
   if(isset($url[0])){
        $controller = $url[0];
    }
   //Checamos si hay un metodo en la segunda posicion de la url
   if(isset($url[1])){
        //Checamos que el metodo no venga vacio
        if($url[1] != ''){
            $method = $url[1];
        }
   }
   //Verificamos que nunca haya un tercer parametro, de lo contrario cerramos la session o enviamos a main
   if(isset($url[2])){
       //echo 11;
        header("Location:".URL."Index/index");
    }
   
    //Esta funcion carga de forma automatica las clases que estan siendo invocadas
   //La clase debe tener el nombre del archivo
   spl_autoload_register(function($class){
        if(file_exists(LBS.$class.".php")){
            require LBS.$class.".php";
        }
   });
   //Incluimos el archivo controller para despues instanciar la clase
   $controllerPath = "controllers/".$controller.".php";
   //echo "Controlador index = ".$controllerPath."<br/>";
   if(file_exists($controllerPath)){
       
       require $controllerPath;
       //Instanciamos la clase
       $controller = new $controller();
        if(isset($method)){
            //echo 'Metodo en index='.$method.'<br/>';
            //Dependiendo el controlador  que invoquemos es el metodo que invocaremos
            if(method_exists($controller, $method)){
                //echo "i-10";
                $controller->{$method}();
            }else{
                //Cuando no se encuentra el metodo nos vamos a main
                header("Location:".URL."Main/main");
            }
        }
   }else{
    //echo "i-12";
        header("Location:".URL."Index/index");
   }
   
?>
