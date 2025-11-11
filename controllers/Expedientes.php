<?php
class Expedientes extends Controllers
{
    function __construct(){
        parent::__construct();
        require_once "library/validar_cadenas.php";
        require_once ("SaveLogs.php");
    }
    public function expediente(){
        if(isset($_POST['idActivo'])){
            $idActivo=$_POST['idActivo'];
            $nombreActivo=$_POST['nombreActivo'];
            $_SESSION['idActivo']=$idActivo;
            $_SESSION['nombreActivo']=$nombreActivo;
        }
        $this->view->render($this, "expediente", '', '');
    }
    function get_bitacora_activos(){
        $count=0;
        $search=$_POST['search'];
        $tipoActivo=$_POST['tipoActivo'];
        $bg_tr="claro";
        $count_tr=0;
        $arrayCasos=[];
        $respond = $this->model->get_bitacora_activos_m($search, $tipoActivo);
        echo "<table><tr><th>Nombre del activo</th><th>Administrador</th><th>Extenciones<th></tr>";
        foreach ($respond as $row){
            $datos=json_encode($respond[$count]);
            if($count_tr==0){$bg_tr="claro";$count_tr++;}else{$bg_tr="oscuro";$count_tr=0;}
            $idActivo=$row[0];
            $nombreActivo=$row[1];
            $administrador=$row[4];
            $extenciones=$row[6];
            $estado=$row[8];
            
                $roles = "
                <tr class='$bg_tr $estado'>".
                    "<td>$nombreActivo</td>".
                    "<td>$administrador</td>".
                    "<td>$extenciones</td>".
                    "<td class='btn_img' onclick='expediente(".$datos.")'><img src='../resource/images/iconos/expediente.png'></a></td>".
                "</tr>";
                echo $roles;
                $count++;
        }
        echo "</table>";
    }
    function get_bitacora(){
        $count=0;
        $search=$_POST['search'];
        $id_activo=$_POST['id_activo'];
        $bg_tr="claro";
        $count_tr=0;
        $arrayCasos=[];
        $respond = $this->model->get_bitacora_m($search, $id_activo);
        echo "<table><tr><th>fecha/hora</th><th>Organismo</th><th>recibió llamada</th><th>Coordinó</th><th>Acciones</th><th>-</th></tr>";
        foreach ($respond as $row){
            $datos=json_encode($respond[$count]);
            if($count_tr==0){$bg_tr="claro";$count_tr++;}else{$bg_tr="oscuro";$count_tr=0;}
            $idActivo=$row[0];
            $fecha=$row[2];
            $hora=$row[3];
            $unidad=$row[4];
            $respondU = $this->model->get_unidad_accion_m($unidad);
            $unidad=$respondU['0']['0'];
            $coordinado=$row[5];
            $coordinador=$row[6];
            $acciones=$row[7];
            
                $roles = "
                <tr class='$bg_tr'>".
                    "<td>$fecha ($hora)</td>".
                    "<td>$unidad</td>".
                    "<td>$coordinado</td>".
                    "<td>$coordinador</td>".
                    "<td><textarea readonly class='textareaBitacora'>$acciones</textarea></td>".
                    "<td class='btn_img' onclick='update_bitacora(".$datos.")'><img src='../resource/images/iconos/editar.png'></a></td>".
                "</tr>";
                echo $roles;
                $count++;
            
        }
        echo "</table>";
    }
    function get_unidad_accion(){
        $respond = $this->model->get_unidad_activo_m();
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[2]</option>";
        } 
    }
    function insert_accion(){
        $idActivo = v($_POST["idActivo"],'');
        $fecha = v($_POST["fecha"],'');
        $hora = v($_POST["hora"],'');
        $unidad = v($_POST["unidad"],'');
        $coordinador = v($_POST["coordinador"],'');
        $coordinado = v($_POST["coordinado"],'');
        $accion = v($_POST["accion"],'');
        
        $data =  $this->model->insert_accion_m($idActivo, $fecha, $hora, $unidad, $coordinador,  $coordinado, $accion);
        //Registro de log
        $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Agregó una accion al activo :'.$idActivo);
        $param[0]="¡Accion guardada con exito!";
        $param[1]="Activos/bitacora";
        $menu='1';
        unset($_SESSION['token']);
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    }
    public function update_accion(){
        $idAccion = v($_POST["idAccion"],'');
        $idActivo = v($_POST["idActivo"],'');
        $fecha = v($_POST["fecha"],'');
        $hora = v($_POST["hora"],'');
        $unidad = v($_POST["unidad"],'');
        $coordinador = v($_POST["coordinador"],'');
        $coordinado = v($_POST["coordinado"],'');
        $accion = v($_POST["accion"],'');

        $data =  $this->model->update_accion_m($idAccion, $fecha, $hora, $unidad, $coordinador,  $coordinado, $accion);
        //Registro de log
        $log=new SaveLogs();$log = $log->insertLogs_m('CRUD', 'Actualizo la accion :'.$unidad);
        $param[0]="¡Accion actualizado con exito!";
        $param[1]="Activos/bitacora";
        $menu='1'; //1 oculta header 0 lo muestra
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    } 
    //Para la vista de interfaz de usuarios OK
    public function expedientes(){
       if (null != Session::getSession("user")){
            $param='';
            $menu='';
            $rol = $_SESSION['user']['rol'];
            $this->view->render($this, "expedientes_v", $menu, $param);
        } else {
                header("Location:".URL);
        }
    }
    function get_documentos(){
        $numeroDocumento=$_POST['numeroDocumento'];
        $fechaDocumento=$_POST['fechaDocumento'];
        $asuntoDocumento=$_POST['asuntoDocumento'];
        $idActivo=$_POST['idActivo'];
        $pendientes=$_POST['pendientes'];
        $ask = $this->model->get_documentos_m($numeroDocumento, $fechaDocumento, $asuntoDocumento, $pendientes, $idActivo);
        $cont=0;
        $clase="claro";
        $contClase=0;

        foreach ($ask as $row){
            $datos=json_encode($ask[$cont]);
            $url=$row[11];
            $link=$url;

            $fecha=$row[5];
            $numeroDocumento=$row[2];
            $asunto=$row[6];
            $es=$row[4];

            $idTipoDocumento=$row[1];
            $query = $this->model->getNombreDocumento_m($idTipoDocumento);
            $tipo = $query[0][0];

            $idUnidadDocumento=$row[3];
            $query = $this->model->getNombreUnidad_m($idUnidadDocumento);
            $unidad = $query[0][0];

            if($contClase==0){$contClase=1;$clase="claro";}else{$contClase=0;$clase="oscuro";}
            if($url!=""){
                $url="<td class='btn_img' onclick='visualizar(".$datos.")'><div><img src='../resource/images/iconos/pdf.png' ></div></td>";
            }else{
                $url="<td class='btn_img'><div><img src='../resource/images/iconos/pendientes.png' ></div></td>";
            }
            $documentos = 
            "<tr class='$clase'>" .
                "<td><div>$fecha</div></td>".
                "<td><div>$tipo</div></td>".
                "<td><div>$unidad</div></td>".
                "<td><div>$numeroDocumento</div></td>".
                "<td><div>$asunto</div></td>".
                "<td><div>$es</div></td>".
                "$url".
            "</tr>";
            $cont++;
            echo $documentos;
        }
           
    }
    function getTipoDocumento(){
        $respond = $this->model->getTipoDocumento_m();
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[1]</option>";
        } 
    }
    function getProcedenciaDocumento(){
        $respond = $this->model->getProcedenciaDocumento_m();
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[2]</option>";
        } 
    }
    function get_casos(){
        $respond = $this->model->get_casos_m();
        echo "<option value='NULL'>Asociar a un caso</option>";
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[1]</option>";
        } 
    }
    function get_activos(){
        $respond = $this->model->get_activos_m();
        echo "<option value='NULL'>Asociar a un activo</option>";
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[1]</option>";
        } 
    }

    public function insertDocumento(){
        $archivo = $_FILES["archivo"];
        $tipoDocumento = v($_POST["tipoDocumento"],'');
        $numeroDocumento = v($_POST["numeroDocumento"],'');
        $asuntoDocumento = v($_POST["asuntoDocumento"],'');
        $expediente = v($_POST["expediente"],'');
        $acuerdoDocumento = v($_POST["acuerdoDocumento"],'');
        $usuarioRegistra = v($_POST["usuarioRegistra"],'');
        $procedenciaDocumento = v($_POST["procedenciaDocumento"],'');
        $esDocumento = v($_POST["esDocumento"],'');
        $fechaDocumento = v($_POST["fechaDocumento"],'');
        $casos = v($_POST["casos"],'');
        $activos = v($_POST["activos"],'');

        $data =  $this->model->insertDocumento_m($tipoDocumento, $numeroDocumento, $procedenciaDocumento, 
        $archivo, $fechaDocumento, $asuntoDocumento, $expediente, $acuerdoDocumento, $esDocumento, $usuarioRegistra, $casos, $activos);

        if($data != ""){
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Falló al registrar documento :'. $data);
            $param[0]="¡Error al guardar($data)!";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        //Registro de log
        $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Registró el documento:'.$numeroDocumento);
        $param[0]="¡Documento guardado con exito!";
        $param[1]="Archivo/archivo";
        $menu='1';
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    }
    public function deleteDocumento(){
        $id_eliminar = v($_POST["id_eliminar"],'');
        $nombre_archivo = v($_POST["nombre_archivo"],'');

        $response = $this->model->deleteDocumento_m($id_eliminar,  $nombre_archivo);
        if($response==1){
            //Registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Elimino el documento No.:'.$nombre_archivo);
           //Redirigimos a la vista
            $param[0]="¡Documento eliminado con exito!";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }else{
            $param[0]="¡No se elimino el documento!";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
    }
    public function updateDocumento(){
        //Recibimos variables y las enviamos
        $idDocumento = v($_POST["idDocumento"],'');
        $tipoDocumento = v($_POST["tipoDocumento"],'');
        $procedenciaDocumento = v($_POST["procedenciaDocumento"],'');
        $numeroDocumento = v($_POST["numeroDocumento"],'');
        $fechaDocumento = v($_POST["fechaDocumento"],'');
        $asuntoDocumento = v($_POST["asuntoDocumento"],'');
        $acuerdoDocumento = v($_POST["acuerdoDocumento"],'');
        $usuarioRegistra = v($_POST["usuarioRegistra"],'');
        $expediente = v($_POST["expediente"],'');
        $esDocumento = v($_POST["esDocumento"],'');
        $imagen = v($_POST["imagen"],'');
        $fechaDocumentoTem = v($_POST["fechaTem"],'');
        $numeroDocumentoTem = v($_POST["numeroDocumentoTem"],'');
        $archivo = $_FILES["archivo"];
        $casos = v($_POST["casos"],'');
        $activos = v($_POST["activos"],'');

        $data =  $this->model->updateDocumento_m($idDocumento, $tipoDocumento, $procedenciaDocumento, $numeroDocumento, $numeroDocumentoTem, $fechaDocumento, $fechaDocumentoTem, $asuntoDocumento, $acuerdoDocumento, $usuarioRegistra, $expediente, $esDocumento, $archivo, $imagen, $casos, $activos);
        if(isset($data) && $data != ""){
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Imagen No insertada en menu :'.$numeroDocumento);
            $param[0]="¡Error al actualizar($data)!";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        //Registro de log
        $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Actualizo el Documento :'.$numeroDocumento);
        $param[0]="¡Documento actualizado con exito!";
        $param[1]="Archivo/archivo";
        $menu='1'; //1 oculta header 0 lo muestra
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    }    
}
?>