<?php
    class Usuarios extends Controllers
    {
        function __construct(){
            parent::__construct();
            require_once "library/validar_cadenas.php";
            require_once ("SaveLogs.php");
        }
        //Para la vista de interfaz de usuarios OK
        public function usuarios(){
            if (null != Session::getSession("user")){
               $ask =  $this->model->check_usuarios_M();
               date_default_timezone_set("America/Mexico_City");
               $hoy = date("Y-m-d H:i:s");
               foreach ($ask as $row){
                    $id_usuario=$row[0];
                    $hora=$row[1];
                    $tiempo = (strtotime($hoy)-strtotime($hora));
                    $tiempo=$tiempo;

                    if( $tiempo > 3000){
                        $ask =  $this->model->sacar_usuarios_M($id_usuario);
                    }
                } 
               $param='';
               $menu='';
               $rol = $_SESSION['user']['rol'];
               if($rol != 'Administrador'){ header("Location:destroySession");}
               $this->view->render($this, "usuarios_v", $menu, $param);
            }
            else {
                header("Location:".URL);
            }
        }
        public function expedientes(){
        if(isset($_POST['idUsuario'])){
           $_SESSION['datosUsuario']=$_POST['idUsuario'];
        }
        $this->view->render($this, "expedientes", '', '');
    }
        
        function get_roles(){
            $respond = $this->model->get_roles_m();
            foreach ($respond as $row){
                echo "<option value=$row[0]>$row[1]</option>";
            } 
        }
        function get_grados(){
            $respond = $this->model->get_grados_m();
            foreach ($respond as $row){
                echo "<option value=$row[0]>$row[2]</option>";
            } 
        }
        function get_especialidades(){
            $respond = $this->model->get_especialidades_m();
            foreach ($respond as $row){
                echo "<option value=$row[0]>$row[2]</option>";
            } 
        }
        function get_unidades(){
            $respond = $this->model->get_unidades_m();
            foreach ($respond as $row){
                echo "<option value=$row[0]>$row[2]</option>";
            } 
        }
        public function insert_usuario(){               
            $_SESSION['token']=random_int(100, 9999);

            $nombreUsuario = v($_POST["nombreUsuario"], 'cadena', 'encode');
            $matricula = v($_POST["matricula"], 'cadena', 'encode');
            $grados = v($_POST["grados"], 'cadena', 'encode');
            $especialidades = v($_POST["especialidades"], 'cadena', 'encode');
            $unidades = v($_POST["unidades"], 'cadena', 'encode');
            $rol = v($_POST["roles"], 'cadena', 'encode');

            $usuario = v($_POST["usuario"], 'cadena', 'encode');
            $password = v($_POST["password"], 'password', '');
            $archivo=v($_FILES["archivo"],'foto','');
            
            //Verificamos que los campos no vengan vacios
            if( $nombreUsuario=="" || $matricula=="" || $usuario==""){
                $param[0]="¡Los campos no pueden quedar vacios!";
                $param[1]="Usuarios/usuarios";
                $menu='1';
               $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }//Validamos la contraseña
            elseif($password=='x'){
                $param[0]="¡La contraseña no cumple con los parametros!";
                $param[1]="Usuarios/usuarios";
                $menu='1';
               $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            //Validamos la foto
            elseif($archivo=='formato'){
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
                    $ask =  $this->model->insert_usuario_m($grados, $especialidades, $unidades, $nombreUsuario, $matricula, $rol, $usuario, $password, $archivo);             
                    if(isset($ask[0]) && $ask[0]=='nombreExistente'){
                        $param[0]="¡Este nombre ya existe!";
                        $param[1]="Usuarios/usuarios";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                    }
                    elseif(isset($ask[0]) && $ask[0]=='usuarioExistente'){
                        $param[0]="¡Este usuario ya existe!";
                        $param[1]="Usuarios/usuarios";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                    }
                    else{
                        //Registro de log
                        $log=new SaveLogs();$log = $log->insertLogs_m('CRUD', 'Inserto el Nombre de usuario :'. $nombreUsuario);
                        $param[0]="¡Registro exitoso!";
                        $param[1]="Usuarios/usuarios";
                        $menu='1';
                        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                    }
                }
        }
        public function get_usuarios(){
            $count=0;
            $bg_tr="claro";
            $count_tr=0;
            $no=1;
            $datosU="";
            $getUsuario=v($_POST["getUsuario"], 'cadena', 'encode');
             echo "
             <table class='data-table'>
                <tr>
                    <th>Avatar</th>
                    <th>Usuario</th>
                    <th colspan='4'><div id='ver' class='ocultar'></div></th>
                </tr>";
            $respond = $this->model->get_usuarios_m($getUsuario);
            if(!empty($respond)){
                foreach($respond as $row){
                                        
                    $grado=v($row[1],'cadena', 'decode');
                    $respondG = $this->model->get_grado_m($grado);
                    $grado=$respondG[0][0];
                    
                    $especialidad=v($row[2],'cadena', 'decode');
                    $respondE = $this->model->get_especialidad_m($especialidad);
                    $especialidad=$respondE[0][0];

                    $matricula=v($row[3],'cadena', 'decode');
                    $nombre=v($row[4],'cadena', 'decode');
                    $clase="";
                    $estado=$row[11];

                    if($estado == 1){$clase="linea";}
                    if($estado == 2){$clase="alto";}

                     $datosU=json_encode($respond[$count]);

                     //Descartamos el usuario dado de baja accesos denegados o estados 1 en linea, 2 bloqueado y 3 de baja
                     if($estado < 3){
                        $usuarios = "
                        <tr>".
                            "<td class='w150'><img src='../resource/images/fotos_usuarios/$row[5]'></td>".
                            "<td class='$clase'><div>$grado $especialidad $nombre</div></td>".
                            "<td class='btn_img' onmouseover='verEx()' onmouseout='ocultar()' onclick='expediente(".$datosU.")'><img src='../resource/images/iconos/expediente.png'></td>".
                            "<td class='btn_img' onmouseover='verE()' onmouseout='ocultar()' onclick='update_usuario(".$datosU.")'><img src='../resource/images/iconos/editar.png'></td>".
                            "<td class='btn_img' onmouseover='verR()' onmouseout='ocultar()' onclick='update_rol(".$datosU.")'><img src='../resource/images/iconos/roles_a.png'></td>".
                            "<td class='btn_img' onmouseover='verEl()' onmouseout='ocultar()' onclick='delete_usuario(".$datosU.")'><img src='../resource/images/iconos/eliminar.png'></td>".
                        "</tr>";
                    echo $usuarios;
                     }
                     $clase="";
                     $estado=0;
                   $count++;
                   $no++;
                }
            }else{
                echo "Dato vacio";
            }
            echo "</table>";
        }
        public function update_usuario(){
            $idUsuario = v($_POST["idUsuario"], 'cadena','encode');
            $nombreUsuario = v($_POST["nombreUsuario"], 'cadena','encode');
            $matricula = v($_POST["matricula"], 'cadena','encode');
            $grados = v($_POST["grados"], 'cadena','encode');
            $especialidades = v($_POST["especialidades"], 'cadena','encode');
            $unidades = v($_POST["unidades"], 'cadena','encode');
            $usuario = v($_POST["usuario"], 'cadena','encode');
            $password = v($_POST["password"], 'password','');
            $nombreArchivoDB = v($_POST["nombreArchivoDB"], 'cadena','encode');
            $estado = v($_POST["estado"], 'cadena','encode');
            
            //Validamos el archivo
            $archivo=v($_FILES["archivo"],'fotos', '');
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
            }
            elseif($password=='x'){
                $param[0]="¡La contraseña no cumple con el parametro requerido";
                $param[1]="Ciberactores/ciberactores";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            else{
                $ask =  $this->model->update_usuario_m($idUsuario, $grados, $especialidades, $unidades, $nombreUsuario, $matricula, $usuario, $password, $archivo, $nombreArchivoDB, $estado);
                if(isset($ask[0]) && $ask[0]=='matriculaexistente'){
                    $param[0]="¡Esta matricula ya existe!";
                    $param[1]="Usuarios/usuarios";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }
                elseif(isset($ask[0]) && $ask[0]=='usuarioexistente'){
                    $param[0]="¡Este usuario ya existe!";
                    $param[1]="Usuarios/usuarios";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }
                else{
                    //Registro de log
                    $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Actualizo el usuario matricula:'.$matricula);
                    $param[0]="¡Actualizacion exitosa!";
                    $param[1]="Usuarios/usuarios";
                    $menu='1';
                    $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                }
            }
        }
        //Para buscar usuarios
        public function delete_usuario(){
            
            $_SESSION['token']=random_int(100, 9999);
            $idEliminar = v($_POST["idEliminar"],'cadena', 'encode');
            $nombreEliminar = v($_POST["nombreEliminar"],'cadena', 'decode');
            $archivoEliminar = v($_POST["archivoEliminar"],'', '');
            
            $eliminarUsuario = $this->model->delete_usuario_m($idEliminar, $archivoEliminar);
            //Redirigimos a la vista
            if( $eliminarUsuario !=1 ){
                $param[0]="¡No se pudo eliminar al usuario!";
            }
            else{
                //Registro de log
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Elimino el usuario:'.$nombreEliminar);
                $param[0]="¡Usuario eliminado con exito!";
            }
            $param[1]="Usuarios/usuarios";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        public function get_rol(){
            $count=0;
            $count_tr=0;
            $idUsuario = v($_POST['idUsuario'], 'cadena', 'encode');
            $respond = $this->model->get_rol_m($idUsuario);         
            if(!empty($respond) & $idUsuario!=''){
                echo "<table>";
               foreach($respond as $row){
                    $datosU=json_encode($respond[$count]);
                    if($count_tr==0){$bg_tr="claro";$count_tr++;}else{$bg_tr="oscuro";$count_tr=0;}
                    $roles = "<tr>" .
                        "<td class='$bg_tr'><div id='idRol'>$row[1]</div></td>".
                        "<td class='b1'><a href='#' onclick='delete_rol(".$datosU.")'><div class='boton b_eliminar na'><img src='../resource/images/iconos/eliminar.png' ></div></a></td>".
                    "</tr>";
                    $count++;
                    echo $roles;
                }
                echo "</table>";
                
            }else{
                echo "<h2>Este usuario no cuenta con roles asignados</h2>";
            }
        }
        //Roles del usuario
        public function insert_rol(){
                       
            $idRol = v($_POST["rolesa"], "cadena", "encode");
            $idUsuario = v($_POST["idU"], "cadena", "encode");

            $data =  $this->model->insert_rol_m($idUsuario, $idRol);

            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Asigno un rol al usuario id:'.$idUsuario);
            $param[0]="¡Rol agregado con exito!";
            $param[1]="Usuarios/usuarios";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        
        public function delete_rol(){
            $idEliminar = v($_POST["idEliminar"],'cadena', 'encode');
            $nombreEliminar = v($_POST["nombreEliminar"],'cadena', 'encode');

            $respond = $this->model->delete_rol_m($idEliminar);
            //Registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Quito el rol '. $nombreEliminar);

            $param[0]="¡Rol eliminado con exito!";
            $param[1]="Usuarios/usuarios";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        //============================================================Expediente
        function get_id_tipo_documento(){
            $respond = $this->model->get_id_tipo_documento_m();
            foreach ($respond as $row){
                echo "<option value='$row[0]'>$row[1]</option>";
            } 
        }
        function insert_documento(){
            $idUsuario = v($_POST["idUsuario"],'cadena', 'encode');
            $tipoDocumento = v($_POST["tipoDocumento"],'cadena', 'encode');
            $descripcion = v($_POST["descripcion"],'cadena', 'encode');
            $archivo = v($_FILES["archivo"],'archivos', 'todos');
            if($archivo=='formato'){
                $param[0]="¡EL formato dl documento no es valido!";
                $param[1]="Usuarios/expedientes";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            elseif($archivo=='size'){
                $param[0]="¡El tamaño del documento excede el permitido (1 MB)";
                $param[1]="Usuarios/expedientes";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
                //devuelve null cuando no se carga un archivo
            }else{
                //Registro de log
                $data =  $this->model->insert_documento_m($idUsuario, $archivo, $descripcion, $tipoDocumento);
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Agregó una foto');
                $param[0]="¡Evidencia guardada con exito!";
                $param[1]="Usuarios/expedientes";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
        }
        function get_documentos(){
        $count=0;
        $count_tr=0;
        $idUsuario = $_SESSION['idUsuario'];
        $path= URL.RC."/users/$idUsuario/";
        
        $em="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $ec="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $ciber="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $com="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $per="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $dh="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $ot="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";
        $ed="<table class='data-table'><tr><th>Documento</th><th>Descripción</th><th>-</th><th>-</th></tr>";

        $respond = $this->model->get_documentos_m($idUsuario);
       
        foreach ($respond as $row){
            $path= URL.RC."/users/$idUsuario/";
            $datos=json_encode($respond[$count]);
            $archivo=$row[3];
            $descripcion=v($row[4],'cadena','decode');
            $tipoDocumento=$row[6];
            
            $extension=substr($archivo,-3);
            //Para previsualizar el archivo
            if($extension=="jpg" || $extension=="png"|| $extension=="peg"){
                $path="<tr><td class='btn_img' >
                    <div><a href='$path$archivo' target='_blank'><img src='$path$archivo'></a></div>
                </td>";
            }  
            if($extension==""){
                $path="<tr><td class='no btn_img'>Texto</td>";
            }
            if($extension=="tml"){
                $path="<tr ><td class='btn_img'><div><a href='$path$archivo' target='_blank'><img src='../resource/images/iconos/html.png'></a></div></td>";
            }
            if($extension=="pdf"){
                $path="<tr ><td class='btn_img'><div><a href='$path$archivo' target='_blank'><img src='../resource/images/iconos/pd.png'></a></div></td>";
            }

            //Para descargar el archivo
            if($extension=="zip"){$path="<tr><td class='btn_img'><div><a href='$path$archivo'><img src='../resource/images/iconos/zipp.png'></a></div></td>";}
            if($extension=="rar"){$path="<tr><td class='btn_img'><div><a href='$path$archivo'><img src='../resource/images/iconos/rarr.png'></a></div></td>";}
            if($extension=="ocx"){$path="<tr><td class='btn_img'><div><a href='$path$archivo'><img src='../resource/images/iconos/wod.png'></a></div></td>";}
            if($extension=="ptx"){$path="<tr><td class='btn_img'><div><a href='$path$archivo'><img src='../resource/images/iconos/pow.png'></a></div></td>";}
             $line =
                "$path".
                "<td>$descripcion</td>".
                "<td class='btn_img'><a href='#' onclick='update_documento(".$datos.")'><img src='../resource/images/iconos/editar.png'></a></td>".
                "<td class='btn_img'><a href='#' onclick='delete_documento(".$datos.")'><img src='../resource/images/iconos/eliminar.png'></a></td>".
                "</tr>";
            if($tipoDocumento=="Estudios"){$em=$em.$line;}
            if($tipoDocumento=="Cursos"){$ec=$ec.$line;}
            if($tipoDocumento=="Familia"){$ciber=$ciber.$line;}
            if($tipoDocumento=="X1"){$com=$com.$line;}
            if($tipoDocumento=="X2"){$per=$per.$line;}
            if($tipoDocumento=="X3"){$dh=$dh.$line;}
            if($tipoDocumento=="X4"){$ed=$ed.$line;}
            if($tipoDocumento=="X5"){$ot=$ot.$line;}
            $line="";
            $count++;
        }
            $em=$em."</table>";
            $ec=$ec."</table>";
            $ciber=$ciber."</table>";
            $com=$com."</table>";
            $per=$per."</table>";
            $dh=$dh."</table>";
            $ot=$ot."</table>";
            echo $em."*".$ec."*".$ciber."*".$com."*".$per."*".$dh."*".$ot."*".$ed;        
    }
    public function update_documento(){
        $idUsuario = v($_POST["idUsuario"],'cadena', 'encode');
        $idDocumento = v($_POST["idDocumento"],'cadena', 'encode');
        $descripcion = v($_POST["descripcion"],'cadena', 'encode');
        $nombreArchivoDB = v($_POST["nombreArchivoDB"],'cadena', 'encode');
        $tipoDocumento = v($_POST["tipoDocumento"],'cadena', 'encode');
        
        $archivo=v($_FILES["archivo"],'archivos', 'todos');
            if($archivo=='formato'){
                $param[0]="¡El formato del documento no es valido!";
                $param[1]="Usuarios/expedientes";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            elseif($archivo=='size'){
                $param[0]="¡El tamaño del documento excede el permitido (1 MB)";
                $param[1]="Usuarios/expedientes";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            else{	
                $data =  $this->model->update_documento_m($idUsuario, $idDocumento, $tipoDocumento, $descripcion, $archivo, $nombreArchivoDB);
                //Registro de log
                $log=new SaveLogs();$log = $log->insertLogs_m('CRUD', 'Actualizo el documento (Imagen)');
                $param[0]="¡Documento actualizado con exito!";
                $param[1]="Usuarios/expedientes";
                $menu='1'; //1 oculta header 0 lo muestra
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
    }
    public function delete_documento(){
        $idDocumento = v($_POST["idDocumento"],'cadena', 'encode');
        $archivoEliminar = v($_POST["nombreArchivoDB"],'cadena', 'encode');
        $idUsuario = v($_POST["idUsuario"],'cadena', 'encode');

        $response = $this->model->delete_documento_m($idUsuario, $idDocumento, $archivoEliminar);
        //if($response == 1){
            //Registro de log
            require_once("SaveLogs.php");
            $log=new SaveLogs();
            $log = $log->insertLogs_M('CRUD', 'Elimino un documento');
           //Redirigimos a la vista
            $param[0]="¡Documento eliminad0 con exito!";
            $param[1]="Usuarios/expedientes";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    }
}
?>