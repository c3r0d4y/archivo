<?php
class Archivo_m extends Conexion{
    function __construct(){
        parent::__construct();

     }
     function get_documentos_m($numeroDocumento, $fechaDocumento, $asuntoDocumento, $pendientes, $editor, $buscarTipo){
        $column="*";
        $tabla="documentos";
        
        //Por editor
        if($editor!="" && $buscarTipo=="" && $numeroDocumento=="" && $asuntoDocumento == "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE id_usuario=$editor ORDER BY fecha DESC LIMIT 150";
         }
         //Por tipo de documento
         elseif ($editor=="" && $buscarTipo!="" && $numeroDocumento=="" && $asuntoDocumento == "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE id_tipo_documento = $buscarTipo ORDER BY fecha DESC LIMIT 150";
         }
         //Por tipo y numero de documento
         elseif ($editor=="" && $buscarTipo!="" && $numeroDocumento!="" && $asuntoDocumento == "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE id_tipo_documento = $buscarTipo AND numero_documento LIKE '%$numeroDocumento%' ORDER BY fecha DESC LIMIT 150";
         }
         //Por tipo y asunto de documento
         elseif ($editor=="" && $buscarTipo!="" && $numeroDocumento=="" && $asuntoDocumento != "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE id_tipo_documento = $buscarTipo AND asunto LIKE '%$asuntoDocumento%' ORDER BY fecha DESC LIMIT 150";
         }
         //Por numero de documento
         elseif ($editor=="" && $buscarTipo=="" && $numeroDocumento!="" && $asuntoDocumento == "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE numero_documento LIKE '%$numeroDocumento%' ORDER BY fecha DESC LIMIT 150";
         }
         //Por asunto de documento
         elseif ($editor=="" && $buscarTipo=="" && $numeroDocumento=="" && $asuntoDocumento != "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE asunto LIKE '%$asuntoDocumento%' ORDER BY fecha DESC LIMIT 150";
         }
         //Por fecha de documento
         elseif ($editor=="" && $buscarTipo=="" && $numeroDocumento=="" && $asuntoDocumento == "" && $fechaDocumento!="" && $pendientes==0){
            $where=" WHERE date(fecha) = '$fechaDocumento' ORDER BY fecha DESC LIMIT 150";
         }
         //Por fecha de documento
         elseif ($editor=="" && $buscarTipo=="" && $numeroDocumento=="" && $asuntoDocumento == "" && $fechaDocumento!="" && $pendientes==0){
            $where=" WHERE date(fecha) = '$fechaDocumento' ORDER BY fecha DESC LIMIT 150";
         }
         //por documentos pendientes
         elseif ($editor=="" && $buscarTipo=="" && $numeroDocumento=="" && $asuntoDocumento == "" && $fechaDocumento=="" && $pendientes==1){
            $where=" WHERE copia='' ORDER BY fecha DESC LIMIT 50";
         }
         else{
            $where=" WHERE 1 ORDER BY fecha DESC  LIMIT 70";
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
         $where=" WHERE 1 ORDER BY nombre_usuario";
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
   //==========================================================Asociar==============================================
   public function get_cases_m(){
      $column='*';
      $tabla='cases';
      $where=" WHERE 1 ORDER BY nombre_case";
      $tipoSentencia="muchosRegistros";
      $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
      return($response);
   }
   public function get_activos_m(){
      $column='*';
      $tabla='activos';
      $where=" WHERE 1 ORDER BY nombre_activo";
      $tipoSentencia="muchosRegistros";
      $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
      return($response);
   }
   function insert_asociar_m($idDocumento, $idActivo, $idCaso){
      
       if($idActivo!=""){
         $tabla='expedientes_activos';
         $campos="id_activo, id_documento";
         $values = "$idActivo, $idDocumento";
       }else{
         $tabla='case_expediente';
         $campos="id_caso, id_documento";
         $values = "$idCaso, $idDocumento";
       }
       $response = $this->db->insert($tabla, $campos, $values, 1);
       return($response);//recibimos el id del usuario insertado
  }
  public function get_activos_asociados_m($idDocumento){
      $column='*';
      $tabla='expedientes_activos';
      $where=" WHERE id_documento=$idDocumento";
      $tipoSentencia="muchosRegistros";
      $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
      return($response);
   }
   public function get_casos_asociados_m($idDocumento){
      $column='*';
      $tabla='case_expediente';
      $where=" WHERE id_documento=$idDocumento";
      $tipoSentencia="muchosRegistros";
      $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
      return($response);
   }
   public function get_datos_caso_m($idCaso){
      $column='*';
      $tabla='cases';
      $where=" WHERE id_case=$idCaso";
      $tipoSentencia="muchosRegistros";
      $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
      return($response);
   }
   public function get_datos_activo_m($idActivo){
      $column='*';
      $tabla='activos';
      $where=" WHERE id_activo=$idActivo";
      $tipoSentencia="muchosRegistros";
      $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
      return($response);
   }
   public function delete_asociado_m ($idDelete, $activoCaso){
      if($activoCaso=="activo"){
         $tabla="expedientes_activos";
         $where= " WHERE id_expediente_activo=$idDelete";
      }else{
         $tabla="case_expediente";
         $where= " WHERE id_expediente=$idDelete";
      }
      $response = $this->db->delete($tabla, $where, 0);
      return($response);
   }
}
?>