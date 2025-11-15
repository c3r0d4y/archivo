<?php
class Archivo_m extends Conexion{
    function __construct(){
        parent::__construct();

     }
     function get_documentos_m($tipoBusqueda,$numeroDocumento, $fechaDocumento,$fechaDocumento1, $asuntoDocumento, $pendientes, $editor, $buscarTipo){

        $column="*";
        $tabla="documentos";
        //echo "p0=".$tipoBusqueda."|p1=".$numeroDocumento."|p2=".$fechaDocumento."|p3=".$asuntoDocumento."|p4=".$pendientes."|p5=".$editor."|p6=".$buscarTipo."</br>";
        if($pendientes=="pendientes"){$tipoBusqueda="pendientes";}
        //Por numero de documento
        if($tipoBusqueda=="numero"){
            $where=" WHERE numero_documento LIKE '%$numeroDocumento%' ORDER BY fecha DESC LIMIT 150";
        }
        else if($tipoBusqueda=="usuario" && $editor!=""){
            $where=" WHERE id_usuario=$editor ORDER BY fecha DESC LIMIT 500";
        }
        else if($tipoBusqueda=="tDocumento" && $buscarTipo!=""){
            $where=" WHERE id_tipo_documento = $buscarTipo ORDER BY fecha DESC LIMIT 500";
        }
        else if($tipoBusqueda=="dia" && $fechaDocumento!=""){
           $where=" WHERE date(fecha) = '$fechaDocumento' ORDER BY fecha DESC LIMIT 500";
        }
        else if($tipoBusqueda=="asunto" && $asuntoDocumento!=""){
           $where=" WHERE asunto LIKE '%$asuntoDocumento%' ORDER BY fecha DESC LIMIT 500";
        }
        else if($tipoBusqueda=="pendientes"){
           $where=" WHERE copia='' ORDER BY fecha DESC LIMIT 150";
        }
        else if($tipoBusqueda=="tipoasunto" && $buscarTipo!="" && $asuntoDocumento!=""){
           $where=" WHERE id_tipo_documento = $buscarTipo AND asunto LIKE '%$asuntoDocumento%' ORDER BY fecha DESC LIMIT 150";
        }
        else if($tipoBusqueda=="tiponumero" && $buscarTipo!="" && $numeroDocumento!=""){
           $where=" WHERE id_tipo_documento = $buscarTipo AND numero_documento LIKE '%$numeroDocumento%' ORDER BY fecha DESC LIMIT 150";
        }
        else if($tipoBusqueda=="periodo" && $fechaDocumento!="" && $fechaDocumento1!=""){
          $where=" WHERE fecha BETWEEN '$fechaDocumento' AND '$fechaDocumento1' ORDER BY fecha DESC LIMIT 500";
        }
        else if($tipoBusqueda=="usuarioperiodo" &&$editor!="" && $fechaDocumento!="" && $fechaDocumento1!=""){
          $where=" WHERE id_usuario=$editor AND fecha BETWEEN '$fechaDocumento' AND '$fechaDocumento1' ORDER BY fecha DESC LIMIT 500";
        }
        else if($tipoBusqueda=="tipoperiodo" && $buscarTipo!="" && $fechaDocumento!="" && $fechaDocumento1!=""){
          $where=" WHERE id_tipo_documento = $buscarTipo AND fecha BETWEEN '$fechaDocumento' AND '$fechaDocumento1' ORDER BY fecha DESC LIMIT 150";
        }
        else{
            $where=" WHERE 1 ORDER BY fecha DESC  LIMIT 50";
         }
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($ask);
     }
     public function getTipoDocumento_m(){
         $column='*';
         $tabla='tipodocumento';
         $where=" WHERE 1 ORDER BY tipo_documento";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      public function getEditor_m(){
         $column='*';
         $tabla='usuarios';
         $where=" WHERE estado_usuario < 3 ORDER BY nombre_usuario";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      public function getNombreDocumento_m($idTipoDocumento){
         $column='tipo_documento';
         $tabla='tipodocumento';
         $where=" WHERE id_tipo_documento = $idTipoDocumento";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      public function getNombreUnidad_m($idUnidadDocumento){
         $column='nombre_unidad';
         $tabla='unidades';
         $where=" WHERE id_unidad = $idUnidadDocumento";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      public function getProcedenciaDocumento_m(){
         $column='*';
         $tabla='unidades';
         $where=" WHERE 1";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      
      public function insertDocumento_m ($tipoDocumento, $numeroDocumento, $procedenciaDocumento, $archivo, $fechaDocumento, 
      $asuntoDocumento, $expediente, $acuerdoDocumento, $esDocumento, $usuarioRegistra){
         $idUnidadArchivo=$_SESSION['user']['id_unidad'];
         $ano=date('Y',strtotime($fechaDocumento));                 
          //Verificamos que que ese numero de documento no exista en el mismo año
          $column="*";
          $tabla="documentos";
          $where=" WHERE numero_documento = '$numeroDocumento' AND YEAR(fecha) = $ano";
          $tipoSentencia="muchosRegistros";
          $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
          if(!empty($response)){return("Este numero ya se encuentra registrado en este año");}//Si el nombre existe salimos
         $ruta= RC.'/archivos/documentos/';
         $nombreArchivo=rand(1,100).date("Ydms");
        //Si no se cargo una imagen se pone una por defecto
        if($archivo==3){
            $cargarArchivo="";
        }else{
             //Cargamos el archivo y obtenemos el nombre para la base de datos
             $cargarArchivo = $this->db->insertArchivo($archivo, $ruta, $nombreArchivo);
        }    
         //Unicamente guardamos si el archivo no existe
         $tabla='documentos';
         $campos='id_tipo_documento, numero_documento, id_unidad_procedencia, e_s, fecha, asunto, expediente, acuerdo, id_usuario, copia, id_unidad_archivo';
         $values = "$tipoDocumento, '$numeroDocumento', $procedenciaDocumento, '$esDocumento', '$fechaDocumento', '$asuntoDocumento', '$expediente', '$acuerdoDocumento', $usuarioRegistra, '$cargarArchivo', $idUnidadArchivo";
         $response = $this->db->insert($tabla, $campos, $values, 0);
         return("");//recibimos el id del usuario insertado
      }
      public function delete_documento_m ($idDelete, $archivoEliminar){
         //Borramos el archivo
         $ruta= RC.'/archivos/documentos/';
         //echo "Documento que se eliminará  :".$ruta. "nombre :".$nombreArchivo;
         
         $tabla="documentos";
         $where= " WHERE id_documentos = $idDelete";
         $response = $this->db->delete($tabla, $where, 0);
         if($archivoEliminar != 'default.png' && $archivoEliminar!=""){
            $ruta= RC.'/archivos/documentos/';
            $delete = $this->db->deleteArchivo($ruta, $archivoEliminar);
         }
        return($response);
      }

      public function  updateDocumento_m($idDocumento, $tipoDocumento, $procedenciaDocumento, $numeroDocumento, $numeroDocumentoTem,
      $fechaDocumento, $fechaDocumentoTem, $asuntoDocumento, $acuerdoDocumento, $usuarioRegistra, $expediente, $esDocumento, $archivo, $nombreArchivoDB){
         //Variables utilizadas
         $ano=date('Y',strtotime($fechaDocumento));
         $idUnidadArchivo=$_SESSION['user']['id_unidad'];
               
         //Si el numero de documento cambio checamos que no exista de lo contrario salimos
         if($numeroDocumento != $numeroDocumentoTem){
            $column="*";
            $tabla="documentos";
            $where=" WHERE numero_documento = '$numeroDocumento' AND YEAR(fecha) = $ano";
            $tipoSentencia="muchosRegistros";
            $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
            if(!empty($response)){return("Numero existente en el mismo año");}//Si el nombre existe salimos
         }
         //Cargamos el archivo
         $ruta= RC.'/archivos/documentos/';
         $nombreArchivoNuevo=rand(1,100).date("Ydms");////Nombre con que se guardara en base de datos      
         if($archivo!=3){
               //Cargamos el archivo y obtenemos el nombre para la base de datos
               $cargarArchivo = $this->db->updateArchivo($archivo, $ruta, $nombreArchivoNuevo, $nombreArchivoDB);
         }
         else{
               $cargarArchivo=$nombreArchivoDB;
         }
         //echo "nombre a guardar:".$cargarArchivo."<br/>";
         //Guardamos
         $tabla='documentos';
         $where="WHERE id_documentos =". $idDocumento;
         $values = "id_tipo_documento = $tipoDocumento, numero_documento='$numeroDocumento', id_unidad_procedencia = $procedenciaDocumento, e_s='$esDocumento', fecha='$fechaDocumento', asunto='$asuntoDocumento', expediente='$expediente', acuerdo='$acuerdoDocumento', copia='$cargarArchivo'";
         $response = $this->db->update($tabla, $where, $values);
         return("");    
   }
   public function  validar_documento_m($idDocumento, $numeroDocumento){
         //Guardamos
         $tabla='documentos';
         $where="WHERE id_documentos =". $idDocumento;
         $values = "estado='1'";
         $response = $this->db->update($tabla, $where, $values);
         return($response);
   }
}
?>