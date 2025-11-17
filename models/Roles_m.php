<?php
class Roles_m extends Conexion{
    function __construct(){
        parent::__construct();
    }

    function getRoles_m(){
        $column="roles.id_rol, roles.nombre_rol, roles.id_tipo_rol, tipo_rol.nombre_tipo_rol";
        $tabla="roles, tipo_rol";
        $where=" WHERE roles.id_tipo_rol=tipo_rol.id_tipo_rol";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function selectRoles_m(){
        $column="*";
        $tabla="tipo_rol";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($ask);
     }
    public function delete_rol_m ($idDelete){
        //echo $idRol.'<br/>';
        $column="id_rol";
        $tabla="asignacionroles";
        $where=" WHERE id_rol=$idDelete";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        if(empty($response)) {
            $tabla="roles";
            $where= " WHERE id_rol = ".$idDelete;
            $response = $this->db->delete($tabla, $where, 0);
            return($response);
        }else{
           return($response);
        }
    }

    public function insertRol_m ($rol, $tipoRol){
        //echo  $rol.'=='.$tipoRol;
        $tabla='roles';
        $campos='nombre_rol, id_tipo_rol';
        $values = "'$rol', '$tipoRol'";
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
    }

    public function  updateRol_m($idRol, $nombreRol, $tipoRol){
        $tabla='roles';
        $where="WHERE id_rol =". $idRol;
        $values = "nombre_rol = '$nombreRol', id_tipo_rol = '$tipoRol'";
        $response = $this->db->update($tabla, $where, $values);
    }
}
?>