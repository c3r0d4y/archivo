<?php
    class Unidades extends Controllers
    {
        function __construct(){
            parent::__construct();
            require_once "library/validar_cadenas.php";
            require_once ("SaveLogs.php");
        }
        //Para la vista de interfaz de usuarios OK
        public function unidades(){
            if (null != Session::getSession("user")){
                $param='';
                $menu='';
                $rol = $_SESSION['user']['rol'];
                if($rol == 'Administrador' || $rol == 'Jefe de turno SOC'){
                    $this->view->render($this, "unidades_v", $menu, $param);
                }else{header("Location:destroySession");}
            } else {
                header("Location:".URL);
            }
        }
        public function insert_unidad(){
            
            $_SESSION['token']=random_int(100, 9999);

            $claveUnidad = v($_POST["claveUnidadU"],'cadena', 'encode');
            $nombreUnidad = v($_POST["nombreUnidadU"],'cadena', 'encode');
            $data =  $this->model->registroUnidad_m($claveUnidad, $nombreUnidad);
            //Registro de Log
            $log=new SaveLogs(); $log = $log->insertLogs_M('CRUD', 'Agrego la unidad:'.$claveUnidad);
            $param[0]="¡Unidad guardada con exito!";
            $param[1]="Unidades/unidades";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        /*public function enlace_unidad(){
           $this->view->render($this, "unidadE", '', '');
        }
        public function enlace_sub(){
            $this->view->render($this, "unidadS", '', '');
         }
        public function secciones(){
            $this->view->render($this, "secciones", '', '');
        }
        */
        function get_unidades(){
            echo 
            "<form action='#' method='POST' name='formE'>
                <table class='data-table'>
                    <input type='hidden' id='id_unidad' name = 'id_unidad'>
                    <tr class='trth'>
                        <th>Nombre de la unidad</th>
                        <th>Abreviatura</th>
                        <th colspan='2'><div id='ver' class='ocultar ri'></th> 
                    </tr>";
                    $count=0;
                    $clase="claro";
                    $contClase=0;
                    $respond = $this->model->getUnidades_m();
                    foreach ($respond as $row){
                        $datosR=json_encode($respond[$count]);
                        if($contClase==0){$contClase=1;$clase="claro";}else{$contClase=0;$clase="oscuro";}
                        $nombreUnidad=v($row[1],'cadena','decode');
                        $abreviatura=v($row[2],'cadena','decode');   
                        $roles = 
                            "<tr class='$clase'>".
                                "<td>$nombreUnidad</td>".
                                "<td> $abreviatura</td>".
                                "<td class='btn_img' onmouseover='verE()' onmouseout='ocultar()' onclick='update_unidad(".$datosR.")'><img src='../resource/images/iconos/editar.png' /></td>".
                                "<td class='btn_img' onmouseover='verEl()' onmouseout='ocultar()' onclick='delete_unidad(".$datosR.")'><img src='../resource/images/iconos/eliminar.png' ></td>".
                            "</tr>";
                        echo $roles;
                        $count++;
                    } 
            echo "</table></form>";
        }
        public function update_unidad(){
            
            $_SESSION['token']=random_int(100, 9999);
            $idUnidad = v($_POST["idUnidadU"],'cadena', 'encode');
            $claveUnidad = v($_POST["claveUnidadU"],'cadena', 'encode');
            $nombreUnidad = v($_POST["nombreUnidadU"],'cadena', 'encode');
            $data =  $this->model->updateUnidad_m($idUnidad, $claveUnidad ,$nombreUnidad);
            //Registro de Log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Actualizo la unidad:'.$claveUnidad);
            $param[0]="¡Unidad actualizada con exito!";
            $param[1]="Unidades/unidades";
            $menu='1'; //1 oculta header 0 lo muestra
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        public function delete_unidad(){
            
            $_SESSION['token']=random_int(100, 9999);
            $idDelete = v($_POST["idDelete"],'cadena', 'encode');
            $response = $this->model->deleteU_m($idDelete);
            
            if($response == 1){
                //Registro de Log
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Elimino la unidad:'.$idDelete);
                $param[0]="¡Unidad eliminada con exito!";
                $param[1]="Unidades/unidades";
                $menu='1';
                //echo "Enviar=". $param[0]."<br/>";
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }else{
                    $param[0]="¡Esta unidad esta en uso!";
                    $param[1]="Unidades/unidades";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
        }
    }
    
?>