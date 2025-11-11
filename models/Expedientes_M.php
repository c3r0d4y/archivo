<?php
class Expedientes_m extends Conexion{
    function __construct(){
        parent::__construct();

     }
     function get_bitacora_activos_m($search, $tipoActivo){
        //Todos los casos
        if($tipoActivo==""){
            $column="*";
            $tabla="activos";
            $where=" WHERE red='internet' ORDER BY estado";
        
        //busqueda por tipo de activo
        }else{
            $column="*";
            $tabla="activos";
            $where=" WHERE red='$tipoActivo' ORDER BY estado";
        }
       
                
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function get_bitacora_m($search, $id_activo){
        //Todos los casos
        if($search==""){
            $column="*";
            $tabla="bitacora";
            $where=" WHERE id_activo=$id_activo";
        //Casos
        }else{
            $column="*";
            $tabla="bitacora";
            $where=" WHERE id_activo=$id_activo AND fecha='$search'";
        }
                
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function insert_accion_m ($idActivo, $fecha, $hora, $unidad, $coordinador,  $coordinado, $accion){
        $tabla='bitacora';
        $campos='id_activo, fecha, hora, id_unidad_coordina, coordinador, coordinado, acciones';
        $values = "$idActivo, '$fecha', '$hora', $unidad, '$coordinador',  '$coordinado', '$accion'";
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
    }
    function get_unidad_accion_m($unidad){
        $column="abreviatura_unidad";
        $tabla="unidades";
        $where=" WHERE id_unidad=$unidad";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function  update_accion_m($idAccion,$fecha, $hora, $unidad, $coordinador,  $coordinado, $accion){
        $tabla='bitacora';
        $where="WHERE id_bitacora =". $idAccion;
        $values = "fecha='$fecha', hora='$hora', id_unidad_coordina=$unidad, coordinador='$coordinador', coordinado='$coordinado', acciones='$accion'";
        $response = $this->db->update($tabla, $where, $values);
    }
     function get_documentos_m($numeroDocumento, $fechaDocumento, $asuntoDocumento, $pendientes, $idActivo){

        $column="*";
        $tabla="documentos";
        
        if($numeroDocumento!="" && $asuntoDocumento == "" && $fechaDocumento!="" && $pendientes==0){
            $where=" WHERE id_activo=$idActivo
            AND documentos.numero_documento LIKE '%$numeroDocumento%'  AND date(documentos.fecha) = '$fechaDocumento' ORDER BY documentos.fecha DESC LIMIT 15";
         }
         elseif ($numeroDocumento=="" && $asuntoDocumento == "" && $fechaDocumento!="" && $pendientes==0){
            $where=" WHERE id_activo=$idActivo
            AND date(documentos.fecha) = '$fechaDocumento' ORDER BY documentos.fecha DESC LIMIT 15";
         }
         elseif ($numeroDocumento!="" && $asuntoDocumento == "" && $fechaDocumento=="" && $pendientes==0){
            $where=" WHERE id_activo=$idActivo
            AND documentos.numero_documento LIKE '%$numeroDocumento%' ORDER BY documentos.fecha DESC LIMIT 15";
         }
         elseif ($numeroDocumento=="" && $asuntoDocumento != "" && $fechaDocumento == "" && $pendientes==0){
            $where=" WHERE id_activo=$idActivo
            AND documentos.asunto LIKE '%$asuntoDocumento%' ORDER BY documentos.fecha DESC LIMIT 15";
         }
         elseif ($numeroDocumento=="" && $asuntoDocumento != "" && $fechaDocumento != "" && $pendientes==0){
            $where=" WHERE id_activo=$idActivo
            AND documentos.asunto LIKE '%$asuntoDocumento%' AND date(documentos.fecha) = '$fechaDocumento' ORDER BY documentos.fecha DESC LIMIT 15";
         }
         elseif ($pendientes==1){
            $where=" WHERE id_activo=$idActivo AND documentos.copia=''
            ORDER BY documentos.copia ASC LIMIT 30";
         }
         else{
            $where=" WHERE id_activo=$idActivo
            ORDER BY documentos.fecha DESC  LIMIT 30";
         }

        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($ask);
     }
     public function getTipoDocumento_m(){
         $column='*';
         $tabla='tipodocumento';
         $where=" WHERE 1";
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
         $column='abreviatura_unidad';
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
      public function get_casos_m(){
         $column='*';
         $tabla='casos';
         $where=" WHERE 1";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      public function get_activos_m(){
         $column='*';
         $tabla='activos';
         $where=" WHERE 1";
         $tipoSentencia="muchosRegistros";
         $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
         return($response);
      }
      public function insertDocumento_m ($tipoDocumento, $numeroDocumento, $procedenciaDocumento, $archivo, $fechaDocumento, 
      $asuntoDocumento, $expediente, $acuerdoDocumento, $esDocumento, $usuarioRegistra,$casos, $activos){

         $idUnidadArchivo=$_SESSION['user']['id_unidad'];
         //echo $tipoDocumento."|".$numeroDocumento."|".$procedenciaDocumento."|".$fechaDocumento."|".$asuntoDocumento."|".$expediente."|".$acuerdoDocumento."|".$esDocumento."|".$usuarioRegistra."<br/>";
         $ruta= RC.'/archivos/documentos/';
         $ano=date('Y',strtotime($fechaDocumento)); 
         
         //Si se cargo un archivo preparamos el nombre que llevara en la DB con el numero y año
         if($archivo["name"]!=""){
            $nombreArchivoDB = hash('sha256', $numeroDocumento.$ano);}else{$nombreArchivoDB="";
         }
		 
		 //Para ver el hash en caso de que marque que el archivo existe
			//echo "Hash=".$nombreArchivoDB."<br/>";
          //Verificamos que que ese numero de documento no exista en el mismo año
          $column="*";
          $tabla="documentos";
          $where=" WHERE numero_documento = '$numeroDocumento' AND YEAR(fecha) = $ano";
          $tipoSentencia="muchosRegistros";
          $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
          if(!empty($response)){return("Numero existente en el mismo año");}//Si el nombre existe salimos
         
         
         //Chemos si el campo de archivo no viene vacio
         if(isset($archivo) & $archivo["name"]!=""){
              $nombreTem= $archivo['tmp_name'];
               $nombreArchivo = $archivo['name'];
               $extensionArchivo= substr(strrchr($nombreArchivo, '.'), 1);
               $extensionArchivo = strtolower($extensionArchivo);//convertir las extensiones aminusculas

               //Filtramos solo el formato que aceptemos
               if($extensionArchivo != "pdf"){return("formato no compatible");}
               
               $nombreArchivo=$nombreArchivoDB.'.'.$extensionArchivo;
               $ruta=$ruta.$nombreArchivo;
               $archivo=$nombreTem;
               $response = $this->db->insertImagen($archivo, $ruta);
               $nombreArchivoDB=$nombreArchivoDB.".pdf";
               if($response == false){ return("Este numero de documento ya existe");}
         }
            
         //Unicamente guardamos si el archivo no existe
         $tabla='documentos';
         $campos='id_tipo_documento, numero_documento, id_unidad_procedencia, e_s, fecha, asunto, expediente, acuerdo, id_usuario, copia, id_caso, id_activo, id_unidad_archivo';
         $values = "$tipoDocumento, '$numeroDocumento', $procedenciaDocumento, '$esDocumento', '$fechaDocumento', '$asuntoDocumento', '$expediente', '$acuerdoDocumento', $usuarioRegistra, '$nombreArchivoDB', $casos, $activos, $idUnidadArchivo";
         $response = $this->db->insert($tabla, $campos, $values, 0);
         return("");//recibimos el id del usuario insertado
      }
      public function deleteDocumento_m ($idDocumento, $nombreArchivo){
         //Borramos el archivo
         $ruta= RC.'/archivos/documentos/';
         //echo "Documento que se eliminará  :".$ruta. "nombre :".$nombreArchivo;
         unlink($ruta. $nombreArchivo);
         $tabla="documentos";
         $where= " WHERE id_documentos = $idDocumento";
         $response = $this->db->delete($tabla, $where, 0);
         return($response);
      }

      public function  updateDocumento_m($idDocumento, $tipoDocumento, $procedenciaDocumento, $numeroDocumento, $numeroDocumentoTem,
      $fechaDocumento, $fechaDocumentoTem, $asuntoDocumento, $acuerdoDocumento, $usuarioRegistra, $expediente, $esDocumento, $archivo, $imagen, $casos, $activos){
         //Variables utilizadas
         $ano=date('Y',strtotime($fechaDocumento));
         $idUnidadArchivo=$_SESSION['user']['id_unidad'];
         $ruta= RC.'/archivos/documentos/';
         $nombre_archivo_old = $imagen;
         $nombre_archivo_new =  hash('sha256',$numeroDocumento.$ano);
         $nombre_archivo_new=$nombre_archivo_new.".pdf";
                  
         //Si el numero de documento cambio checamos que no exista de lo contrario salimos
         if($numeroDocumento != $numeroDocumentoTem){
            $column="*";
            $tabla="documentos";
            $where=" WHERE numero_documento = '$numeroDocumento' AND YEAR(fecha) = $ano";
            $tipoSentencia="muchosRegistros";
            $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
            if(!empty($response)){return("Numero existente en el mismo año");}//Si el nombre existe salimos
         }

         //Si aun no se carga algun archivo actualizamos los otros valores
         if($imagen=="" && $archivo['name'] == ""){
            $tabla='documentos';
            $where="WHERE id_documentos =". $idDocumento;
            $values = "id_tipo_documento = $tipoDocumento, numero_documento='$numeroDocumento', id_unidad_procedencia = $procedenciaDocumento, e_s='$esDocumento', fecha='$fechaDocumento', asunto='$asuntoDocumento', expediente='$expediente', acuerdo='$acuerdoDocumento', id_usuario=$usuarioRegistra, id_caso=$casos, id_activo=$activos";
            $response = $this->db->update($tabla, $where, $values);
            return("");
         }
          //Si no se cargo archivo, pero ya existia uno
         elseif(($imagen!="" && $archivo['name']=="")){

            //Si cambio el numero de documento renombramos el archivo
            if($numeroDocumento!=$numeroDocumentoTem){
               $response = $this->db->updateImagen($nombre_archivo_old,  $nombre_archivo_new, $ruta);
            }
            $tabla='documentos';
            $where="WHERE id_documentos =". $idDocumento;
            $values = "id_tipo_documento = $tipoDocumento, numero_documento='$numeroDocumento', id_unidad_procedencia = $procedenciaDocumento,
            e_s='$esDocumento', fecha='$fechaDocumento', asunto='$asuntoDocumento', expediente='$expediente', acuerdo='$acuerdoDocumento',
            id_usuario=$usuarioRegistra, copia='$nombre_archivo_new', id_caso=$casos, id_activo=$activos";
            $response = $this->db->update($tabla, $where, $values);
            return("");   
            
            
         }
         //Si no existia archivo pero se cargo uno
         elseif(($imagen=="" && $archivo['name'] != "")){
               $nombreTem= $archivo['tmp_name'];
               $nombreArchivo = $archivo['name'];
               $extensionArchivo= substr(strrchr($nombreArchivo, '.'), 1);
               $extensionArchivo = strtolower($extensionArchivo);//convertir las extensiones aminusculas

               //Filtramos solo el formato que aceptemos
               if($extensionArchivo != "pdf"){return("extension no válida");}
               $ruta=$ruta.$nombre_archivo_new;
               $archivo=$nombreTem;
               $response = $this->db->insertImagen($archivo, $ruta);
               if($response == false){return("Error al insertar imagen");}
               //Guardamos
               $tabla='documentos';
               $where="WHERE id_documentos =". $idDocumento;
               $values = "id_tipo_documento = $tipoDocumento, numero_documento='$numeroDocumento', id_unidad_procedencia = $procedenciaDocumento, e_s='$esDocumento', fecha='$fechaDocumento', asunto='$asuntoDocumento', expediente='$expediente', acuerdo='$acuerdoDocumento', id_usuario=$usuarioRegistra, copia='$nombre_archivo_new', id_caso=$casos, id_activo=$activos";
               $response = $this->db->update($tabla, $where, $values);
               return("");
         }
         //Si ya existia un archivo y se cargo uno, reemplazamos
         elseif(($imagen!="" && $archivo['name']!="")){
            //Eliminamos el archivo existente
            unlink($ruta. $nombre_archivo_old);
            $nombreTem= $archivo['tmp_name'];
            $nombreArchivo = $archivo['name'];
            $extensionArchivo= substr(strrchr($nombreArchivo, '.'), 1);
            $extensionArchivo = strtolower($extensionArchivo);//convertir las extensiones aminusculas

            //Filtramos solo el formato que aceptemos
            if($extensionArchivo != "pdf"){return("extension no válida");}
            $ruta=$ruta.$nombre_archivo_new;
            $archivo=$nombreTem;
            $response = $this->db->insertImagen($archivo, $ruta);
            if($response == false){return("Error al insertar imagen");}
            //Guardamos
            $tabla='documentos';
            $where="WHERE id_documentos =". $idDocumento;
            $values = "id_tipo_documento = $tipoDocumento, numero_documento='$numeroDocumento', id_unidad_procedencia = $procedenciaDocumento, e_s='$esDocumento', fecha='$fechaDocumento', asunto='$asuntoDocumento', expediente='$expediente', acuerdo='$acuerdoDocumento', id_usuario=$usuarioRegistra, copia='$nombre_archivo_new', id_caso=$casos, id_activo=$activos";
            $response = $this->db->update($tabla, $where, $values);
            return("");
      }
   }
}
?>