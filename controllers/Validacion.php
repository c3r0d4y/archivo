<?php
    class Validacion extends Controllers
    {
        public function __construct(){
            parent::__construct();
            require_once "library/validar_cadenas.php";
            require_once("SaveLogs.php");
        }
        public function validacion(){
            if(isset($_POST["usuario"]) && isset($_POST["password"])){
                //Recibimos los valores del formulario y los sanitizamos
                $user=v($_POST["usuario"], 'cadena', 'encode');
                $pass=v($_POST["password"], 'cadena', 'encode');
                
                $_POST["usuario"]="";
                $_POST["password"]="";
            
                //Enviamos los valores al modelo
                $data =  $this->model->validacion_m($user, $pass);            
                //verificamos si el datos almacenado en este objeto es un array
                if($data[0]=="usuarioIncorrecto"){
                    require_once("SaveLogs.php");
                    $log=new SaveLogs();
                    $log = $log->insertLogs_M('ALERTA', 'Usuario Incorrecto: '.$user);
                    $param[0]="¡Usuario Incorrecto!";
                    $param[1]="Index/index_c";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }elseif($data[0]=="contrasenaIncorrecta"){              
                    $log=new SaveLogs();$log = $log->insertLogs_M('ALERTA', 'Contraseña Incorrecta');
                    $id_usuario =$data[2];
                    $intentos =$data[1];
                                
                    $intentos=$intentos+1;//Se incrementa cada ves que la contraseña es incorrecta
                    $intentosr=5-$intentos;//Intentos restantes
                
                    if($intentos > 4){
                        //Se bloquea el usuario
                        $param[0]="¡Tu usuario se encuentra bloqueado";
                        $data =  $this->model->update_estado_M($id_usuario, 5, 5);
                    }else{
                        $param[0]="¡Contraseña Incorrecta! te quedan $intentosr intentos";
                        $data =  $this->model->update_estado_M($id_usuario, 0, $intentos);
                    }            
                    $param[1]="Index/index_c";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }
                elseif($data[0]=="usuario_bloqueado"){           
                    $log=new SaveLogs();$log = $log->insertLogs_M('ALERTA', 'Usuario bloqueado');
                    $param[0]="¡Usuario bloqueado!";
                    $param[1]="Index/index_c";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }
                else{
                        //Si los datos del usuario fueron correctos
                        date_default_timezone_set("America/Mexico_City");
                        $_SESSION['user']['hora']=date("Y-m-d H:i:s");
                        $idUsuario=v($data['id_usuario'], 'cadena', 'encode');           
                        //echo $idUsuario."<br/>";
                        //Consultamos la tabla de roles
                        $sqlRoles =  $this->model->elegirRol_m($idUsuario);  
                        $numeroRoles=count($sqlRoles);                 
                        
                        //Si tiene mas de un rol
                        if($numeroRoles>1){  
                            $datos =  $this->model->update_estado_M($idUsuario, 1, 0);                        
                            $menu="1";
                            $this->view->render($this, 'eligerol_v', $menu, $sqlRoles);
                        }
                        //Si solo tiene un rol se va a main en automatico
                        else{                             
                            $rolunico=$sqlRoles[0][0];
                            $_SESSION['user']['rol']=$rolunico;
                            //Registro de Log
                            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Inicio de Session');                    
                            $data =  $this->model->update_estado_M($idUsuario, 1, 0);
                            header("Location:".URL."Archivo/archivo");
                        }
                }    
            }else{
                //Registro de Log
                require_once("SaveLogs.php");
                $log=new SaveLogs();
                $log = $log->insertLogs_M('PELIGRO', v($_POST['usuario'],"").' -> '.v($_POST['password'], 'cadena', 'encode'));
                header("Location:".URL."/Usuarios/destroySession");
            }
        }
      //Esta funcion se llama desde JS para guardar la variable de session del rol
      public function grabarRol(){
            //Registro de Log
            $rol=$_POST['valores'];
            echo 'se recibio'.$rol.'<br/>';
            $_SESSION['user']['rol']=$rol;
            $log=new SaveLogs();
            $log = $log->insertLogs_M('CRUD', 'Inicio de session');
      }
      public function cerrarSession(){
            //$data =  $this->model->update_estado_M($_SESSION['user']['idUsuario'], 0, 0);
            Session::destroy();
            $param[0]="Su sesion ha finalizado";
            $param[1]="Index/index";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
    }
?>