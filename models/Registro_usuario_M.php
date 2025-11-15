<?php
 class Registro_usuario_M extends Conexion
 {
     function __construct(){
        parent::__construct();
     }

     function registro_usuarios( $usuario, $password){
      echo $usuario."-modelo<br/>";
      return ('Modelo');
     }
}
?>