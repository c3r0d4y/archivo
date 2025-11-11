
<?php
class Archivo extends Controllers
{
    function __construct(){
        parent::__construct();
        require_once "library/validar_cadenas.php";
        require_once ("SaveLogs.php");
    }
    //Para la vista de interfaz de usuarios OK
    public function archivo(){
       if (null != Session::getSession("user")){
            $param='';
            $menu='';
            $rol = $_SESSION['user']['rol'];
            $this->view->render($this, "archivo_v", $menu, $param);
        } else {
                header("Location:".URL);
        }
    }
    function get_documentos(){
        $numeroDocumento=v($_POST['numeroDocumento'],'cadena','encode');
        $fechaDocumento=v($_POST['fechaDocumento'],'cadena','encode');
        $asuntoDocumento=v($_POST['asuntoDocumento'],'cadena','encode');
        $pendientes=v($_POST['pendientes'],'cadena','encode');
        $editor=v($_POST['editor'],'cadena','encode');
        $buscarTipo=v($_POST['buscarTipo'],'cadena','encode');
        $ask = $this->model->get_documentos_m($numeroDocumento, $fechaDocumento, $asuntoDocumento, $pendientes, $editor, $buscarTipo);
        $cont=0;
        $no=0;
        $clase="claro";
        $contClase=0;
        echo "<tr>
            <th>No.</th>
            <th class='date'>Fecha</th>
            <th>Tipo</th>
            <th>No. Doc.</th>
            <th>Asunto</th>
            <th colspan='5'><div id='ver' class='ocultar ri'></div></th>
        </tr>";
        foreach ($ask as $row){
            $datos=json_encode($ask[$cont]);           
            $url=$row[11];
            $link=$url;
            $fecha=$row[5];
            $numeroDocumento=v($row[2],'cadena','decode');
            $asunto=v($row[6],'cadena','decode');
            $es=v($row[4],'cadena','decode');
            $idTipoDocumento=v($row[1],'cadena','decode');
            $query = $this->model->getNombreDocumento_m($idTipoDocumento);
            $tipo = $query[0][0];
            $idUnidadDocumento=$row[3];
            $query = $this->model->getNombreUnidad_m($idUnidadDocumento);
            $unidad = $query[0][0];
            $estado=$row[9];
            $no++;
            if($estado=='1'){$estado="revisado";}else{$estado="pendiente";}
            if($contClase==0){$contClase=1;$clase="claro";}else{$contClase=0;$clase="oscuro";}
            if($url!=""){
                $url="<td class='btn_img'><div><a href='../resource/archivos/documentos/$url' target='blank'><img src='../resource/images/iconos/pdf.png' ></a></div></td>";
            }else{
                $url="<td class='btn_img'onmouseover='verC()' onmouseout='ocultar()' ><div><img src='../resource/images/iconos/pendientes.png' ></div></td>";
            }
            $documentos = 
            "<tr class='$clase'>" .
                "<td class='$estado btn_img' onmouseover='verV()' onmouseout='ocultar()' onclick='validar_documento(".$datos.")'>$no</td>".
                "<td class='date'>$fecha</td>".
                "<td>$tipo</td>".
                "<td>$numeroDocumento</td>".
                "<td>$asunto</td>".
                "$url".
                "<td class='btn_img' onmouseover='verE()' onmouseout='ocultar()' onclick='update_documento(".$datos.")'><div><img src='../resource/images/iconos/editar.png' /></div></td>".
                "<td class='btn_img' onmouseover='verEl()' onmouseout='ocultar()' onclick='delete_documento(".$datos.")'><div><img src='../resource/images/iconos/eliminar.png' ></div></td>".
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
    function getTipo(){
        echo "<option value=''>Seleccione el tipo de documento</option>";
        $respond = $this->model->getTipoDocumento_m();
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[1]</option>";
        } 
    }
    function getEditor(){
        echo "<option value=''>Seleccione un usuario</option>";
        $respond = $this->model->getEditor_m();
        foreach ($respond as $row){
            $editor=v($row[4],'cadena','decode');
            echo "<option value='$row[0]'>$editor</option>";
        } 
    }
    function getProcedenciaDocumento(){
        $respond = $this->model->getProcedenciaDocumento_m();
        foreach ($respond as $row){
            echo "<option value='$row[0]'>$row[2]</option>";
        } 
    }
    public function insertDocumento(){
        $tipoDocumento = v($_POST["tipoDocumento"],'cadena','encode');
        $numeroDocumento = v($_POST["numeroDocumento"],'cadena', 'encode');
        $asuntoDocumento = v($_POST["asuntoDocumento"],'cadena', 'encode');
        $expediente = v($_POST["expediente"],'cadena', 'encode');
        $acuerdoDocumento = v($_POST["acuerdoDocumento"],'cadena', 'encode');
        $usuarioRegistra = v($_POST["usuarioRegistra"],'cadena', 'encode');
        $procedenciaDocumento = v($_POST["procedenciaDocumento"],'cadena', 'encode');
        $esDocumento = v($_POST["esDocumento"],'cadena', 'encode');
        $fechaDocumento = v($_POST["fechaDocumento"],'cadena', 'encode');

        $archivo = v($_FILES["archivo"], 'documento', 'pdf');
        if($archivo=='formato'){
            $param[0]="¡El formato del documento no es valido!";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        elseif($archivo=='size'){
            $param[0]="¡El tamaño del documento excede el permitido (1 MB)";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            //devuelve null cuando no se carga un archivo
        }
        else{
            $data =  $this->model->insertDocumento_m($tipoDocumento, $numeroDocumento, $procedenciaDocumento, 
            $archivo, $fechaDocumento, $asuntoDocumento, $expediente, $acuerdoDocumento, $esDocumento, $usuarioRegistra);
            if($data != ""){
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Falló al registrar documento :'. $data);
                $param[0]="¡Error al guardar($data)!";
                $param[1]="Archivo/archivo";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }else
            {
                //Registro de log     
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Registró el documento:'.$numeroDocumento);
                $param[0]="¡Documento guardado con exito!";
                $param[1]="Archivo/archivo";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
        }
    }
    public function delete_documento(){
        $idDelete = v($_POST["idDelete"],'cadena','encode');
        $archivoEliminar = v($_POST["nombre_archivo"],'cadena', 'encode');
        $respond = $this->model->delete_documento_m($idDelete, $archivoEliminar);
		   //Redirigimos a la vista
            if($respond !=1){
                $param[0]="¡No se pudo eliminar el archivo!";
                $param[1]="Archivo/archivo";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
            else{
                //Registro de log
                $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Elimino el avatar:'.$archivoEliminar);
                $param[0]="¡Documento eliminado con exito!";
                $param[1]="Archivo/archivo";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
    }
    public function updateDocumento(){
        //Recibimos variables y las enviamos
        $idDocumento = v($_POST["idDocumento"],'cadena', 'encode');
        $tipoDocumento = v($_POST["tipoDocumento"],'cadena', 'encode');
        $procedenciaDocumento = v($_POST["procedenciaDocumento"],'cadena', 'encode');
        $numeroDocumento = v($_POST["numeroDocumento"],'cadena', 'encode');
        $fechaDocumento = v($_POST["fechaDocumento"],'cadena', 'encode');
        $asuntoDocumento = v($_POST["asuntoDocumento"],'cadena', 'encode');
        $acuerdoDocumento = v($_POST["acuerdoDocumento"],'cadena', 'encode');
        $usuarioRegistra = v($_POST["usuarioRegistra"],'cadena', 'encode');
        $expediente = v($_POST["expediente"],'cadena', 'decode');
        $esDocumento = v($_POST["esDocumento"],'cadena', 'encode');
        $nombreArchivoDB = v($_POST["nombreArchivoDB"],'cadena', 'encode');
        $fechaDocumentoTem = v($_POST["fechaTem"],'cadena', 'decode');
        $numeroDocumentoTem = v($_POST["numeroDocumentoTem"],'cadena', 'encode');
        
        $archivo = v($_FILES["archivo"], 'documento', 'pdf');
        if($archivo=='formato'){
            $param[0]="¡EL formato de la imagen no es valido!";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
        elseif($archivo=='size'){
            $param[0]="¡El tamaño de la imagen excede el permitido (3 MB)";
            $param[1]="Archivo/archivo";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            //devuelve null cuando no se carga un archivo
        }
        else{
            $data =  $this->model->updateDocumento_m($idDocumento, $tipoDocumento, $procedenciaDocumento, $numeroDocumento, $numeroDocumentoTem, $fechaDocumento, $fechaDocumentoTem, $asuntoDocumento, $acuerdoDocumento, $usuarioRegistra, $expediente, $esDocumento, $archivo, $nombreArchivoDB);
            if(isset($data) && $data != ""){
                $param[0]="¡Error al actualizar($data)!";
                $param[1]="Archivo/archivo";
                $menu='1';
                $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }else{
            //Registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Actualizo el Documento :'.$numeroDocumento);
            $param[0]="¡Documento actualizado con exito!";
            $param[1]="Archivo/archivo";
            $menu='1'; //1 oculta header 0 lo muestra
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
            }
        }
    }
    public function validar_documento(){
        if($_SESSION['user']['rol']=="Administrador" || $_SESSION['user']['rol']=="Jefe de turno SOC"){
            //Recibimos variables y las enviamos
            $idDocumento=$_POST['idDocumento'];
            $numeroDocumento=$_POST['numeroDocumento'];
                    
            $data =  $this->model->validar_documento_m($idDocumento, $numeroDocumento);
            //Registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Valido el documento :'.$numeroDocumento);
            $param[0]="¡Documento validado con exito!";
            $param[1]="Archivo/archivo";
            $menu='1'; //1 oculta header 0 lo muestra
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
    }
}
?>