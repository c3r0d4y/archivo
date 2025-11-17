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
       if (isset($_SESSION['user']['rol'])){
        echo "1";
            $param='';
            $menu='';
            $rol = $_SESSION['user']['rol'];
            $this->view->render($this, "archivo_v", $menu, $param);
        } else {
                echo "2";
                header("Location:".URL);
        }
    }
   
    function get_documentos(){
        $tipoBusqueda=v($_POST['tipoBusqueda'],'cadena','encode');
        $numeroDocumento=v($_POST['numeroDocumento'],'cadena','encode');
        $fechaDocumento=v($_POST['fechaDocumento'],'cadena','encode');
        $fechaDocumento1=v($_POST['fechaDocumento1'],'cadena','encode');
        $asuntoDocumento=v($_POST['asuntoDocumento'],'cadena','encode');
        $pendientes=v($_POST['pendientes'],'cadena','encode');
        $editor=v($_POST['editor'],'cadena','encode');
        $buscarTipo=v($_POST['buscarTipo'],'cadena','encode');

        $ask = $this->model->get_documentos_m( $tipoBusqueda,$numeroDocumento, $fechaDocumento,$fechaDocumento1, $asuntoDocumento, $pendientes, $editor, $buscarTipo);
        $cont=0;
        $no=0;
        $clase="claro";
        $contClase=0;
        echo "<table class='data-table'><tr>
            <th>No.</th>
            <th class='date'>Fecha</th>
            <th>Tipo</th>
            <th>No. Doc.</th>
            <th>Asunto</th>
            <th colspan='4'><div id='ver' class='ocultar ri'></div></th>
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
            
            if($url!=""){
                $url="<td class='btn_img'><div><a href='../resource/archivos/documentos/$url' target='blank'><img src='../resource/images/iconos/pdf.png' ></a></div></td>";
            }else{
                $url="<td class='btn_img'onmouseover='verC()' onmouseout='ocultar()' ><div><img src='../resource/images/iconos/pendientes.png' ></div></td>";
            }
            $documentos = 
            "<tr>" .
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
        echo "</table>";     
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
    //==========================================================asociar=================================================
    function get_cases(){
        $respond = $this->model->get_cases_m();
        echo "<option value=''>Asociar a un caso</option>";
        foreach ($respond as $row){
            $casos=v($row[1], 'cadena','decode');
            echo "<option value='$row[0]'>$casos</option>";
        } 
    }
    function get_activos(){
        $respond = $this->model->get_activos_m();
        echo "<option value=''>Asociar a un activo</option>";
        foreach ($respond as $row){
            $activo=v($row[1],'cadena','decode');
            echo "<option value='$row[0]'>$activo</option>";
        } 
    }
    public function insert_asociar(){
        $idDocumento = v($_POST["idDocumento"],'cadena','encode');
        $idActivo = v($_POST["activos"],'cadena','encode');
        $idCaso = v($_POST["casos"],'cadena','encode');

        //echo "datos:|".$idDocumento."|".$idActivo."|".$idCaso."|";
        
        $data =  $this->model->insert_asociar_m($idDocumento, $idActivo, $idCaso);
        
        //Registro de log
        $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Asoció un documento');
        $param[0]="¡Documento asociado con exito!";
        $param[1]="Archivo/asociar";
        $menu='1';
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    }
    function get_activos_asociados(){
        $idDocumento=$_POST['idDocumento'];
        $ask = $this->model->get_activos_asociados_m($idDocumento);
        $cont=0;
        $clase="claro";
        $contClase=0;
        echo "<div class='table-title'>Activos asociados</div>
        <table class='data-table'>";
        foreach ($ask as $row){
            $datos=json_encode($ask[$cont]);
            $idAsociado=$row[0];
            $idActivo=$row[1];
            $query = $this->model->get_datos_activo_m($idActivo);
            $idActivo = $query[0][1];
            $nombreActivo = $query[0][1];
            $nombreActivo=v($nombreActivo,'cadena','decode');
            $documentos = 
            "<tr>".
                "<td>$nombreActivo</td>".
                "<td class='btn_img' onclick='delete_activo_asociado(".$idAsociado.")'><img src='../resource/images/iconos/eliminar.png'></td>".
            "</tr>";
            $cont++;
            echo $documentos;
        }
        echo "</table>";
    }
    function get_casos_asociados(){
        $idDocumento=$_POST['idDocumento'];      
        $ask = $this->model->get_casos_asociados_m($idDocumento);
        $cont=0;
        $clase="claro";
        $contClase=0;
        echo "<div class='table-title'>Casos asociados</div>
        <table class='data-table'>";
        foreach ($ask as $row){
            $datos=json_encode($ask[$cont]);
            $idAsociado=$row[0];
            $idCaso=$row[1];
            $query = $this->model->get_datos_caso_m($idCaso);
            $idCaso = $query[0][1];
            $nombreCaso = $query[0][1];
            $nombreCaso=v($nombreCaso,'cadena','decode');

            if($contClase==0){$contClase=1;$clase="claro";}else{$contClase=0;$clase="oscuro";}
            
            $documentos = 
            "<tr>".
                "<td>$nombreCaso</td>".
                "<td class='btn_img'><a href='#' onclick='delete_caso_asociado(".$idAsociado.")'><div><img src='../resource/images/iconos/eliminar.png' ></div></a></td>".
            "</tr>";
            $cont++;
            echo $documentos;
        }
        echo "</table>";
    }
    public function delete_asociado(){
        $idDelete = v($_POST["idDelete"],'cadena','encode');
        $activoCaso=v($_POST['activoCaso'],'cadena','encode');
        $response = $this->model->delete_asociado_m($idDelete, $activoCaso);
        if($response==1){
            //Registro de log
            $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Elimino la asociacion');
           //Redirigimos a la vista
            $param[0]="¡Asociacion eliminada con exito!";
            $param[1]="Archivo/asociar";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }else{
            $param[0]="¡No se elimino la asociacion!";
            $param[1]="Archivo/asociar";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
    }
}
?>