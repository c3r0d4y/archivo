<?php
class Usuarios_M extends Conexion{
    function __construct(){
        parent::__construct();
    }
  
    function get_roles_m(){
        $column="*";
        $tabla="roles";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function get_unidades_m(){
        $column="*";
        $tabla="unidades";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function get_grados_m(){
        $column="*";
        $tabla="grados";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function get_especialidades_m(){
        $column="*";
        $tabla="especialidades";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function get_grado_m($grado){
        $column="grado_abreviado";
        $tabla="grados";
        $where=" WHERE id_grados=$grado";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    function get_especialidad_m($especialidad){
        $column="especialidad_abreviada";
        $tabla="especialidades";
        $where=" WHERE id_especialidad=$especialidad";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
   
    function insert_usuario_m($grados, $especialidades, $unidades, $nombreUsuario, $matricula, $rol, $usuario, $password, $archivo){
        $column="*";
        $tabla="usuarios";
        $where=" WHERE nombre_usuario = '$nombreUsuario'";
        $tipoSentencia="unRegistro";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        
         //Si el username ya existese sale
        if($response!=NULL){
            $response[0]="nombreExistente";
            return($response);
        }
        $usuario = hash('sha256', SALT.hash('sha256', $usuario.SALT));
        $column="*";
        $tabla="usuarios";
        $where=" WHERE nombre_usuario = '$usuario'";
        $tipoSentencia="unRegistro";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
                 
        //Si el usuario ya existiese sale
        if($response!=NULL){
            $response[0]="usuarioExistente";
            return($response);
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        //Si se inserto una imagen se guarda de lo contrario de pone una imagen por default
        $ruta= RC.'/images/fotos_usuarios/';
        $nombreArchivo=rand(1,100).date("Ydms");
        //Si no se cargo una imagen se pone una por defecto
        if($archivo["name"]==""){
            $cargarArchivo="default.png";
        }else{
             //Cargamos el archivo y obtenemos el nombre para la base de datos
             $cargarArchivo = $this->db->insertArchivo($archivo, $ruta, $nombreArchivo);
        }
        
        $tabla='usuarios';
        $campos="id_grado, id_especialidad, matricula, nombre_usuario, foto_usuario, id_rol, id_unidad, usuario, password";
        $values = "$grados, $especialidades, '$matricula', '$nombreUsuario', '$cargarArchivo', $rol, $unidades, '$usuario', '$password'";
        $response = $this->db->insert($tabla, $campos, $values, 1);
       
        $tabla='asignacionroles';
        $campos='id_usuario, id_rol';
        $values = "$response, $rol";
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
    }
    public function get_usuarios_m($getUsuario){
        //echo "Valor en el metodo".$valor."<br/>";
        if($getUsuario=="todos"){
            $column="*";
            $tabla="usuarios";
            $where=" WHERE 1";
            $tipoSentencia="muchosRegistros";
            $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
            //Agregamos el id del rol al array devuelto
            $cont=0;
            return($response);
        }else{
            $column="*";
            $tabla="usuarios";
            $where=" WHERE nombre_usuario LIKE '%$getUsuario%'";
            $tipoSentencia="muchosRegistros";
            $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
            //Agregamos el id del rol al array devuelto
            $cont=0;
            return($response);
        }
    }
    function update_usuario_m($idUsuario, $grados, $especialidades, $unidades, $nombreUsuario, $matricula, $usuario, $password, $archivo, $nombreArchivoDB){
        $column="*";
        $tabla="usuarios";
        $where=" WHERE id_usuario=$idUsuario";
        $tipoSentencia="unRegistro";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        
        $matriculaTem=$response[3];
        $fotoTem=$response[5];
        $usuarioTem=$response[8];
        $passTem=$response[9];
                    
        //si cambia el usuario
        if($usuario=="****"){
            $usuario=$usuarioTem;
            //echo "no cambio usuario<br/>";
        }else{
            $usuario = hash('sha256', SALT.hash('sha256', $usuario.SALT));
            //echo "cambio usuario<br/>";
            //Si el usuario cambio checamos que no exista
            $column="*";
            $tabla="usuarios";
            $where=" WHERE usuario = '$usuario'";
            $tipoSentencia="unRegistro";
            $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
                      
            //Si el usuario ya existese salimos
            if($response!=NULL){
                $response[0]="usuarioexistente";
                return($response);
            }
        }
        //Si cambia la contraseña
        if($password=="****************"){
            $password=$passTem;
            //echo "no cambio contraseña<br/>";
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT);
            //echo "cambio contrañaseña<br/>";
            //echo  $password."<br/>";
        }
        //Si cambia la matricula
        if($matricula!=$matriculaTem){
            $column="*";
            $tabla="usuarios";
            $where=" WHERE matricula = '$matricula'";
            $tipoSentencia="unRegistro";
            $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
            
            //Si la matricula ya existe salimos
            if($response!=NULL){
                $response[0]="matriculaexistente";
                return($response);
            }
        }

        //Cargamos la imagen
        $ruta= RC.'/images/fotos_usuarios/';
        $nombreArchivoNuevo=rand(1,100).date("Ydms");////Nombre con que se guardara en base de datos
        if($archivo["name"]!=""){
            //Cargamos el archivo y obtenemos el nombre para la base de datos
            $cargarArchivo = $this->db->updateArchivo($archivo, $ruta, $nombreArchivoNuevo, $nombreArchivoDB);
        }
        else{
            $cargarArchivo=$nombreArchivoDB;
        }
        
    
        $tabla='usuarios';
        $where="WHERE id_usuario = ".$idUsuario;
        $values = "id_grado=$grados, id_especialidad=$especialidades, matricula='$matricula', nombre_usuario='$nombreUsuario', foto_usuario = '$cargarArchivo',
        id_unidad=$unidades, usuario = '$usuario', password='$password', estado_usuario=0, intentos_usuario=0";
        $response = $this->db->update($tabla, $where, $values);
        return($response);//recibimos el id del usuario insertado
    }
    
    public function delete_usuario_m ($idEliminar, $archivoEliminar){
        $tabla="asignacionroles";
        $where= " WHERE id_usuario = $idEliminar";
        $eliminar_rol = $this->db->delete($tabla, $where, 1);

        $tabla="usuarios";
        $where= " WHERE id_usuario = $idEliminar";
        $eliminar_usuario = $this->db->delete($tabla, $where, 0);

        //Eliminamos la imagen del usuario
        if($archivoEliminar != 'default.png' && $eliminar_usuario == 1 ){
            $ruta="resource/images/fotos_usuarios/";
            $delete = $this->db->deleteArchivo($ruta, $archivoEliminar);
        }
        return($eliminar_usuario);
    }
    public function delete_rol_m ($idDelete){
        $tabla="asignacionroles";
        $where= " WHERE id_asignacion_rol = $idDelete";
        $response = $this->db->delete($tabla, $where, 0);
    }
    public function get_rol_m($idUsuario){
        $column='asignacionroles.id_asignacion_rol, roles.nombre_rol';
        $tabla='asignacionroles, roles';
        $where=" WHERE asignacionroles.id_usuario = $idUsuario AND asignacionroles.id_rol=roles.id_rol";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function insert_rol_m($idUsuario, $idRol){
        $tabla='asignacionroles';
        $campos='id_usuario, id_rol';
        $values = "$idUsuario, $idRol";
        //echo $values.'<br/>';
        $response = $this->db->insert($tabla, $campos, $values, 0);
        return($response);//recibimos el id del usuario insertado
   }
    public function get_usuario_m($idUsuario){
        //echo "M= ".$idUsuario."<br/>";
        $column="*";
        $tabla="usuarios";
        $where=" WHERE id_usuario = ".$idUsuario;
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        //Agregamos el id del rol al array devuelto
        $cont=0;
        return($ask);
    }
        
    public function destroySession(){
        Session::destroy();
        header("Location:".URL);
    }
    public function  update_estado_M($id_usuario, $estado, $intentos){
        $tabla='usuarios';
        $where="WHERE id_usuario =". $id_usuario;
        $values = "estado_usuario = $estado, intentos_usuario = $intentos";
        $response = $this->db->update($tabla, $where, $values);
    }
    public function check_usuarios_M(){
        $column="id_usuario, tiempo";
        $tabla="usuarios";
        $where=" WHERE estado_usuario = 1";
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($ask);
    }
    public function  sacar_usuarios_m($id_usuario){
        $tabla='usuarios';
        $where="WHERE id_usuario = $id_usuario";
        $values = "estado_usuario = 0";
        $response = $this->db->update($tabla, $where, $values);
    }
    //==================================================================Expediente
    public function get_id_tipo_documento_m(){
        $column='*';
        $tabla='tipo_documento_expediente';
        $where=" WHERE 1 ORDER by nombre";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function insert_documento_m ($idUsuario, $archivo, $descripcion, $tipoDocumento){
        
        $ruta= RC."/users/$idUsuario/";
        if (!file_exists($ruta)) {
            mkdir($ruta, 0755, true);
        }

        $nombreArchivo=rand(1,100).date("Ydms");
        //Si no se cargo una imagen se pone una por defecto
        if($archivo["name"]==""){
            $cargarArchivo=null;
        }else{
             //Cargamos el archivo y obtenemos el nombre para la base de datos
             $cargarArchivo = $this->db->insertArchivo($archivo, $ruta, $nombreArchivo);
        }
        $tabla='expedientes_personal';
        $campos="id_tipo_documento, id_usuario, nombre_documento, titulo_documento";
        $values = "$tipoDocumento, $idUsuario, '$cargarArchivo', '$descripcion'";
        $response = $this->db->insert($tabla, $campos, $values, 1);
    }
    function get_documentos_m($idUsuario){
        $column="*";
            $tabla="expedientes_personal, tipo_documento_expediente";
            $where=" WHERE expedientes_personal.id_tipo_documento=tipo_documento_expediente.id_tipo AND expedientes_personal.id_usuario=$idUsuario ORDER BY nombre_documento DESC";
            $tipoSentencia="muchosRegistros";
            
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function  update_documento_m($idUsuario, $idDocumento, $tipoDocumento, $descripcion, $archivo, $nombreArchivoDB){
        $ruta= RC."/users/$idUsuario/";
        $nombreArchivoNuevo=rand(1,100).date("Ydms");////Nombre con que se guardara en base de datos
                
        if($archivo["name"]!=""){
                //Cargamos el archivo y obtenemos el nombre para la base de datos
            $cargarArchivo = $this->db->updateArchivo($archivo, $ruta, $nombreArchivoNuevo, $nombreArchivoDB);
        }
        else{
            $cargarArchivo=$nombreArchivoDB;
        }
        $tabla='expedientes_personal';
        $where="WHERE id_expediente =".$idDocumento;
        $values = "id_tipo_documento=$tipoDocumento, nombre_documento='$cargarArchivo', titulo_documento='$descripcion'";
        $response = $this->db->update($tabla, $where, $values);
    }
    
    public function delete_documento_m ($idUsuario, $idDocumento, $archivoEliminar){
                
        $tabla="expedientes_personal";
        $where= " WHERE id_expediente = ".$idDocumento;
        $response = $this->db->delete($tabla, $where, 0);

        if($archivoEliminar != 'default.png'){
            $ruta= RC."/users/$idUsuario/";
            $delete = $this->db->deleteArchivo($ruta, $archivoEliminar);
        }
        return($response);
    }    
}


?>