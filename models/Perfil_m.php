<?php
class Perfil_m extends Conexion{
    function __construct(){
        parent::__construct();

     }
     function getRoles_m(){
        $column="*";
        $tabla="roles";
        $where=" WHERE 1";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
     }

     //Solo se actualiza la foto XdXd
     function update_usuario_m($idUsuario,$nombreArchivoDB, $archivo){
        
        //Cargamos la imagen
        $ruta= RC.'/images/fotos_usuarios/';
        $nombreArchivoNuevo=rand(1,100).date("Ydms");////Nombre con que se guardara en base de datos
                
        if($archivo["name"]!=""){
            //echo"si cambia";
            //Cargamos el archivo y obtenemos el nombre para la base de datos
            $cargarArchivo = $this->db->updateArchivo($archivo, $ruta, $nombreArchivoNuevo, $nombreArchivoDB);
        }
        else{
            //echo"no cambia";
            $cargarArchivo=$nombreArchivoDB;
        }
        
        $tabla='usuarios';
        $where="WHERE id_usuario = ".$idUsuario;
        $values = "foto_usuario = '$cargarArchivo'";
        $ask = $this->db->update($tabla, $where, $values);      
    }
    public function  updatePin_m($idUsuario, $pin){
        $pin = hash('sha256', $pin.SALT);
        $tabla='usuarios';
        $where="WHERE id_usuario =". $idUsuario;
        $values = "pin = '$pin'";
        $response = $this->db->update($tabla, $where, $values);
    }

    public function buscarUsuarios_m($idUsuario){
        $column="*";
        $tabla="usuarios";
        $where=" WHERE id_usuario=$idUsuario";
        $tipoSentencia="muchosRegistros";
        $ask = $this->db->select($column, $tabla, $where, $tipoSentencia);
        //Agregamos el id del rol al array devuelto
        $cont=0;
        return($ask);
    }

    public function deleteU_m ($valor, $valor1){
        $tabla="asignacionroles";
        $where= " WHERE idUsuario = ".$valor;
        $response = $this->db->delete($tabla, $where, 0);
        //Eliminamos la imagen del usuario
        if($valor1!='default.png'){
            $ruta="resource/images/fotos/";
            unlink($ruta.$valor1);
        }

        $tabla="usuarios";
        $where= " WHERE idUsuario = ".$valor;
        $response = $this->db->delete($tabla, $where, 0);
    }
    public function deleteR_m ($valor){
        $tabla="asignacionroles";
        $where= " WHERE idAsignacionRol = ".$valor;
        $response = $this->db->delete($tabla, $where, 0);
    }
    public function buscarRoles_m($idUsuario){
        //echo 'idUsuario='.$idUsuario.'<br/>';
        $column='asignacionroles.idAsignacionRol, roles.nombreRol';
        $tabla='asignacionroles, roles';
        $where=" WHERE asignacionroles.idUsuario = $idUsuario AND asignacionroles.idRol=roles.idRol";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
    }
    public function asignacionRol_m($idRol, $idUsuario){
        $tabla='asignacionroles';
        $campos='idUsuario, idRol';
        $values = "$idUsuario, $idRol";
        //echo $values.'<br/>';
        $response = $this->db->insert($tabla, $campos, $values);
        return($response);//recibimos el id del usuario insertado

    }
    public function buscarSecreto_m($idUR){
        $column="secreto";
        $tabla="usuarios";
        $where=" WHERE idUsuario=$idUR";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        //Agregamos el id del rol al array devuelto
        $cont=0;
        return($response);
    }
    public function destroySession(){
        Session::destroy();
        header("Location:".URL);
    }
    function validacion_credenciales_actuales_m($idUsuario, $usuario, $password){
        $usuario = hash('sha256', SALT.hash('sha256', $usuario.SALT));
        $res=0;
        $column="*";
        $tabla="usuarios";
        $where=" WHERE id_usuario=$idUsuario AND usuario='$usuario'";
        $tipoSentencia="unRegistro";
        $consulta_credenciales = $this->db->select($column, $tabla, $where, $tipoSentencia);
        //verificamos que el usuario sea valido
        if(!empty($consulta_credenciales)){
            $passwor_db=$consulta_credenciales['password'];
            //veryficamos que la contraseña
            if(!password_verify($password, $passwor_db)){
                $consulta_credenciales[0]='contrasenaActualIncorrecta';
            }else{
                $consulta_credenciales[0]=1;
            }
        }else{
            //Si ya existe el usuario
            $consulta_credenciales[0]='usuarioActualIncorrecto';
        } 
        return($consulta_credenciales);
    }
    
     function update_credenciales_m($idUsuario, $usuario, $usuarioN , $password, $passwordN){
        //Si cambio el usuario
        $operacion=0;
        if($usuarioN!=""){
            $usuarioN = hash('sha256', SALT.hash('sha256', $usuarioN.SALT));
            //validamos usuario nuevo
            $column="*";
            $tabla="usuarios";
            $where=" WHERE usuario='$usuarioN'";
            $tipoSentencia="unRegistro";
            $consulta_usuario = $this->db->select($column, $tabla, $where, $tipoSentencia);
            //verificamos que el usuario no esxiste
            if(!empty($consulta_usuario)){
                $consulta_usuario[0]='usuarioExistente';
                return ($consulta_usuario);
            }
            $operacion=1;
        }
        //Si cambio la contraseña
        if($passwordN!=""){
            $passwordN = password_hash($passwordN, PASSWORD_DEFAULT);
            if($operacion==1){$operacion=3;}else{$operacion=2;}
        }
        
        //actualizamos credenciales
        if($operacion==1){
            $values = "usuario = '$usuarioN'";
            $consulta_usuario[0]=1;
        }elseif($operacion==2){
            $values = "password = '$passwordN'";
            $consulta_usuario[0]=2;
        }
        elseif($operacion==3){
            $values = "usuario = '$usuarioN', password = '$passwordN'";
            $consulta_usuario[0]=3;
        }       
        $tabla='usuarios';
        $where="WHERE id_usuario = ".$idUsuario;
        $response = $this->db->update($tabla, $where, $values);
        return($consulta_usuario);//recibimos el id del usuario insertado
    }  
}
?>