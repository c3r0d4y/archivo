<?php
 class Validacion_m extends Conexion
 {
    function __construct(){
        parent::__construct();
    }
    function validacion_m($usuario, $password){
       $res=0;
       //echo "1-".$usuario."==".$password."<br/>";
        //Ciframos el usuario que se recibe para compararlo con la base de datos
        $usuario = hash('sha256', SALT.hash('sha256', $usuario.SALT));
        $column="*";
        $tabla="usuarios";
        $where=" WHERE usuario='$usuario'";
        $tipoSentencia="unRegistro";

        //enviamos a la query el usuario que se logueo, y si esta en la base de datos nos devuelve la contraseña
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        if(isset($response[0])){$id_usuario=$response[0];}
        if(isset($response[6])){$estado=$response[11];}
        if(isset($response[7])){$intentos=$response[12];}
                
        //En caso que elo usuario no sea valido retornamos a index de lo contrario validamos contraseña
        if(!empty($response)){

            //Si el usuario esta bloqueado salimos (mas de 3 intentos)
            // //Descartamos el usuario dado de baja accesos denegados o estados 1 en linea, 2 bloqueado y 3 de baja
            if($intentos >3 || $estado > 1){
                $response[]=NULL;
                $response[0]='usuario_bloqueado';
                //echo "Contraseña no valida<br/>";
                return ($response);
            }
            $passwor_db=$response['password'];
            //echo "Passwor=".$password."<br/>";
            //echo "PasswordDB=".$passwor_db."<br/>";

            //verificamos la contraseña
            if(password_verify($password, $passwor_db)){
                                            
                //Aqui almacenamos datos para usarlos en la session iniciada
                $data = array(
                    "id_usuario" => $response['id_usuario'],
                    "nombre_usuario" => v($response['nombre_usuario'],'cadena', 'decode'),
                    "id_unidad" => $response['id_unidad'],
                    "pin" => $response['pin'],
                    "foto_usuario" => $response['foto_usuario']
                );
                //Almacenamos la informacion del array en variables de session
                Session::setSession("user",$data);
                return ($response);
            }else{
                $response[]=NULL;
                $response[0]='contrasenaIncorrecta';
                $response[1]=$intentos;
                $response[2]=$id_usuario;
                return ($response);
            }
        }
        else{
            $response[]=NULL;
            $response[0]='usuarioIncorrecto';
            //echo "Usuario no valido o la sentencia sql fallo<br/>";
            return ($response);
        }  
     }
     function elegirRol_m($idUsuario){
        //echo 'idUsuario='.$idUsuario.'<br/>';
        $column='roles.nombre_rol';
        $tabla='asignacionroles, roles';
        $where=" WHERE asignacionroles.id_usuario = $idUsuario AND asignacionroles.id_rol=roles.id_rol";
        $tipoSentencia="muchosRegistros";
        $response = $this->db->select($column, $tabla, $where, $tipoSentencia);
        return($response);
     }
     public function  update_estado_M($id_usuario, $estado, $intentos){
        $tabla='usuarios';
        $where="WHERE id_usuario =". $id_usuario;
        $values = "estado_usuario = $estado, intentos_usuario = $intentos";
        $response = $this->db->update($tabla, $where, $values);
    }
}