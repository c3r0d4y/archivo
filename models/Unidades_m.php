<?php
class Unidades_m extends Conexion{
    function __construct(){
        parent::__construct();
     }
     function getUnidades_m(){
         //se pasa la tabla, columna y where
         
        $column="*";
        $tabla="unidades";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
     }
     public function deleteU_m ($idDelete){
            $tabla="unidades";
            $where= " WHERE id_unidad = ".$idDelete;
            $response = $this->db->delete($tabla, $where, 0);
            return($response);
    }
    public function registroUnidad_m ($cUnidad, $nUnidad){
        $tabla='unidades';
        $campos='abreviatura_unidad, nombre_unidad';
        $values = "'$cUnidad', '$nUnidad'";
        //echo $values.'<br/>';
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
    }
    public function  updateUnidad_m($idUnidad, $claveUnidad ,$nombreUnidad){
        $tabla='unidades';
        $where="WHERE id_unidad =". $idUnidad;
        $values = "abreviatura_unidad = '$claveUnidad', nombre_unidad = '$nombreUnidad'";
        $response = $this->db->update($tabla, $where, $values);
    }
    function get_secciones_a_m($id_unidad){
        $column="a_sec.id_a_sec, unidades.claveUnidad, secciones.nombre_seccion,secciones.abreviatura_seccion";
       $tabla="a_sec, unidades, secciones";
       $where=" WHERE a_sec.id_unidad=unidades.idUnidad AND a_sec.id_seccion=secciones.id_seccion AND a_sec.id_unidad = $id_unidad";
       $tipoSentencia="muchosRegistros";
       $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
       return($response);
    }
    public function deleteAsignacion_M ($id_eliminar){
        $tabla="a_sec";
        $where= " WHERE id_a_sec = ".$id_eliminar;
        $response = $this->db->delete($tabla, $where);
        return($response);
    }
    function get_secciones_select_m(){
        $column="*";
        $tabla="secciones";
        $where=" WHERE 1 ORDER BY abreviatura_seccion";
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($ask);
     }
     public function insertSeccion_M ($id_seccion, $id_unidad){
        $tabla='a_sec';
        $campos='id_unidad, id_seccion';
        $values = "$id_unidad, $id_seccion";
        //echo $values.'<br/>';
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
    }
    function get_secciones_m(){
        $column="*";
        $tabla="secciones";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function deleteSeccion_M ($id_eliminar){
        $tabla="secciones";
        $where= " WHERE id_seccion = $id_eliminar";
        $response = $this->db->delete($tabla, $where);
        return($response);
    }
    public function insertSe_M ($nombre_seccion, $a_seccion){
        $tabla='secciones';
        $campos='nombre_seccion, abreviatura_seccion';
        $values = "'$nombre_seccion', '$a_seccion'";
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
    }
    public function  updateSeccion_M($id_update, $nombre_seccion, $a_seccion){
        $tabla='secciones';
        $where="WHERE id_seccion =". $id_update;
        $values = "nombre_seccion = '$nombre_seccion', abreviatura_seccion = '$a_seccion'";
        $response = $this->db->update($tabla, $where, $values);

    }
}
?>