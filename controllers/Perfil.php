<?php
    class Perfil extends Controllers
    {
        function __construct(){
            parent::__construct();
            require_once "library/validar_cadenas.php";
            require_once("SaveLogs.php");
        }
        //Para la vista de interfaz de usuarios OK
        public function perfil(){
            if (null != Session::getSession("user")){
               // echo "<script>alert('entrar');</script>";
               $param='';
               $menu='';
               $this->view->render($this, "perfil_v", $menu, $param);
            } else {
                //echo "<script>alert('Salir');</script>";
                header("Location:".URL);
            }
        }
        //Para actualizar perfil
        public function update_usuario(){
            $_SESSION['token']=random_int(100, 9999);
            $idUsuario = v($_POST["idUsuario"], 'cadena', 'encode');
            $nombreArchivoDB = v($_POST["nombreArchivoDB"], 'cadena', 'encode');  

            $archivo=v($_FILES["foto"],'archivo', 'fotos');
            if($archivo=='formato'){
                $param[0]="¡EL formato de la imagen no es valido!";
                $param[1]="Ciberactores/ciberactores";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            elseif($archivo=='size'){
                $param[0]="¡El tamaño de la imagen excede el permitido (1 MB)";
                $param[1]="Ciberactores/ciberactores";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                //devuelve null cuando no se carga un archivo
            }else{
                $ask =  $this->model->update_usuario_m($idUsuario,$nombreArchivoDB, $archivo);
                //registro de log
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Actualizo su perfil:');
                $param[0]="¡Actualizacion exitosa!";
                $param[1]="Perfil/perfil";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }    
        }
        public function updatePin(){          
            $_SESSION['token']=random_int(100, 9999);
            $pin = v($_POST['pin'],'cadena', '');
            $pinV = v($_POST['pinV'],'cadena', '');
            $idUsuario = $_SESSION['user']['id_usuario'];
           
            //verfificamos que sean iguales los PIN
            if( $pin == $pinV){
                //registro de log
                require_once("SaveLogs.php");
                $log=new SaveLogs();
                $log = $log->insertLogs_M('CRUD', 'Actualizo su PIN');

                $ask =  $this->model->updatePin_m($idUsuario, $pin);
                $param[0]="¡Pin actualizado con exito!";
                $param[1]="Perfil/perfil";
                $menu='1'; //1 oculta header 0 lo muestra
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }else{
                //registro de log
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Fallo al actualizar su perfil:');

                $param[0]="¡Los pines no coinciden!";
                $param[1]="Perfil/perfil";
                $menu='1'; //1 oculta header 0 lo muestra
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }   
        }
        public function updatePassword(){
            $operacion=0;
            $idUsuario = $_SESSION['user']['id_usuario'];
            $password = v($_POST['password'], 'password', '');
            $passwordN = v($_POST['passwordN'], 'passwordN', '');
            $usuario = v($_POST['usuario'], 'cadena', 'encode');
            $usuarioN = v($_POST['usuarioN'], 'cadena', 'encode');
            
            //validamos el usuario actual
            if(strlen($usuario) < 4){
                $param[0]="¡El usuario actual no cumple con el formato requerido!";
                $param[1]="perfil/perfil";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            //validamos la contraseña actual
            elseif($password=='x'){
                $param[0]="¡La contraseña actual no cumple con el formato requerido!";
                $param[1]="perfil/perfil";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            //validamos el nuevo usuario
            elseif(strlen($usuarioN) < 4 && $usuarioN!=""){
                $param[0]="¡El nuevo usuario no cumple con los parametros requeridos!";
                $param[1]="perfil/perfil";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            //Validamos la nueva contraseña
            elseif($passwordN==123456){
                    $param[0]="¡La nueva contraseña no cumple con los parametros requeridos!";
                    $param[1]="perfil/perfil";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            elseif($usuarioN=="" && $passwordN==""){
                $param[0]="¡No se ingreso ningun dato nuevo!";
                $param[1]="perfil/perfil";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            else{//Si almenos cambio la contraseña o usuario continuamos
                                
                //Validamos credenciales actuales
                $consulta_credenciales =  $this->model->validacion_credenciales_actuales_m($idUsuario, $usuario, $password);
                if($consulta_credenciales[0]=="usuarioActualIncorrecto"){
                    $param[0]="¡Usuario Incorrecto!";
                    $param[1]="Perfil/perfil";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }elseif($consulta_credenciales[0]=="contrasenaActualIncorrecta"){
                    $param[0]="¡Contraseña Incorrecta!";
                    $param[1]="perfil/perfil";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }else{
                    //Si las credenciales anteriores son validas procedemos a la actualizacion
                    $actualizacion_credenciales =  $this->model->update_credenciales_m($idUsuario, $usuario, $usuarioN , $password, $passwordN);
                    if($actualizacion_credenciales[0]=='usuarioExistente'){
                        //Si solo cambio el usuario
                        $param[0]="¡EL usuario que eligió ya esta en uso!";
                        $param[1]="perfil/perfil";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param); 
                    }
                    elseif($actualizacion_credenciales[0]==1){
                        //Si solo cambio el usuario
                        $param[0]="¡Usuario actualizado con exito!";
                        $param[1]="perfil/perfil";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param); 
                    }elseif($actualizacion_credenciales[0]==2){
                        //Si solo cambio la contraseña
                        $param[0]="¡Contraseña actualizada con exito!";
                        $param[1]="perfil/perfil";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param); 

                    }elseif($actualizacion_credenciales[0]==3){
                        //Si cambiaron ambos
                        $param[0]="¡Credenciales actualizadas con exito!";
                        $param[1]="perfil/perfil";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param); 
                    }
                }
            }
        }
        //Metodo parta obtener los datos del modelo roles OK
        function getRoles(){
            $respond = $this->model->getRoles_m();
            echo '<option value="">Seleccionar rol</option>';
            foreach ($respond as $row){
                echo "<option value=$row[0]>$row[1]</option>";
            } 
        }    
        public function buscarUsuarios(){
            $count=0;
            $datosU="";
            $idUsuario =  $_SESSION['user']['id_usuario'];
                        
            $ask = $this->model->buscarUsuarios_m( $idUsuario);
            $contArray=sizeof($ask[0]);
           
            for($i = 0; $i < $contArray; $i++){
                echo $ask[0][$i];
                echo "/";
            }
        }
        public function buscarRoles(){
            //echo 'Se recibe'.$_POST["valor"].'<br/>';
            $count=0;
             //echo $_POST["valor"];         
            $respond = $this->model->buscarRoles_m($_POST["valor"]);
            
            //var_dump($respond);
            if(!empty($respond&$_POST["valor"]!='')){
                echo "<table>";
               foreach($respond as $row){
                    //$respond[$count][]=$count;
                    $datosU=json_encode($respond[$count]);
                     $roles = "<tr>" .
                        "<td><input type='button' id='idRol'  value='$row[1]' class='boton b_rol'/></td>".
                        "<td class='b_td'><a href='#' onclick='deleteR(".$datosU.")'><button class='boton bI na'><img src='../resource/images/iconos/eliminar.png' ></button></a></td>".
                    "</tr>";
                   echo $roles;
                   $count++;
                }
                echo "
                </table>
                ";
            }else{
                echo "Dato vacio";
            }
        }
        public function deleteR(){
            if(!isset($_POST["token"]) || !isset($_SESSION["token"]) || $_POST["token"] == ""|| $_SESSION["token"] =="" || $_POST["token"] != $_SESSION["token"]){
                $log=new SaveLogs();$log = $log->insertLogs_M('ALERTA', 'Token no valido');
                Session::destroy();header("Location:".URL);
            }
            //registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Elimino un el rol :'.$_POST["valor1"]);

            $respond = $this->model->deleteR_m($_POST["valor"], $_POST["valor1"]);
            $param[0]="¡Rol eliminado con exito!";
            $param[1]="Usuarios/usuarios";
            $menu='1';
            //echo "Enviar=". $param[0]."<br/>";
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
         }
         public function agregarRol(){
            if(!isset($_POST["token"]) || !isset($_SESSION["token"]) || $_POST["token"] == ""|| $_SESSION["token"] =="" || $_POST["token"] != $_SESSION["token"]){
                $log=new SaveLogs();$log = $log->insertLogs_M('ALERTA', 'Token no valido');
                Session::destroy();header("Location:".URL);
            }
            //registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Agrego el rol :'.$_POST["rolesa"]);

            $data =  $this->model->asignacionRol_m($_POST["rolesa"], $_POST["idU"]);
            $param[0]="¡Rol agregado con exito!";
            $param[1]="Usuarios/usuarios";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
         
}
?>