<?php
class Roles extends Controllers
{
    function __construct(){
        parent::__construct();
        require_once "library/validar_cadenas.php";
        require_once("SaveLogs.php");
    }
    //Para la vista de interfaz de usuarios OK
    public function roles(){
        //Corroboramos que sea un usuario valido
       if (null != Session::getSession("user")){
            $param='';
            $menu='';
            $rol = $_SESSION['user']['rol'];
            if($rol != 'Administrador'){header("Location:destroySession");}
               $this->view->render($this, "roles_v", $menu, $param);
        } else {
                header("Location:".URL);
        }
    }
    function getRoles(){
        $count=0;
        $bg_tr="claro";
        $count_tr=0;
        $respond = $this->model->getRoles_m();
        echo "<table><tr><th>Rol</th><th>Tipo</th><th colspan='2'><div id='ver' class='ocultar ri'></div></th></tr>";
        foreach ($respond as $row){
            $datosR=json_encode($respond[$count]);
            if($count_tr==0){$bg_tr="claro";$count_tr++;}else{$bg_tr="oscuro";$count_tr=0;}
            $roles = "
            <tr class='$bg_tr'>" .
                "<td>$row[1]</td>".
                "<td>$row[3]</td>".
                "<td class='btn_img' onmouseover='verE()' onmouseout='ocultar()'><a href='#' onclick='update_rol(".$datosR.")'><img src='../resource/images/iconos/editar.png'/></a></td>".
                "<td class='btn_img' onmouseover='verEl()' onmouseout='ocultar()'><a href='#' onclick='delete_rol(".$datosR.")'><img src='../resource/images/iconos/eliminar.png'/></a></td>".
            "</tr>";
            echo $roles;
            $count++;
        }
        echo "</table>";
    }
   function selectRoles(){
            $ask = $this->model->selectRoles_m();
            foreach ($ask as $row){
                echo "<option value=$row[0]>$row[1]</option>";
            } 
    }
    public function delete_rol(){
        
        $_SESSION['token']=random_int(100, 9999);
        $idDelete = v($_POST["idDelete"],'cadena', 'encode');
        $response = $this->model->delete_rol_m($idDelete);
        if($response == 1){
            //Registro de log
            require_once("SaveLogs.php");
            $log=new SaveLogs();
            $log = $log->insertLogs_M('CRUD', 'Elimino el rol :'.$idDelete);

           //Redirigimos a la vista
            $param[0]="¡Rol eliminado con exito!";
            $param[1]="Roles/roles";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }else{
            $param[0]="¡Este rol esta en uso!";
            $param[1]="Roles/roles";
            $menu='1';
            $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
        }
    }
    public function insertRol(){
        
        $_SESSION['token']=random_int(100, 9999);
        
        $rol = v($_POST["nombreRolU"],'cadena', 'encode');
        $tipoRol = v($_POST["tipoRolU"],'cadena', 'encode');

        //Registro de log
        $log=new SaveLogs();$log = $log->insertLogs_M('CRUD', 'Inserto el rol :'.$rol);
               
        $data =  $this->model->insertRol_m($rol, $tipoRol);
        $param[0]="¡Rol guardado con exito!";
        $param[1]="Roles/roles";
        $menu='1';
        unset($_SESSION['token']);
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    }
    public function updateRol(){
        
        $_SESSION['token']=random_int(100, 9999);

        $idRol = v($_POST["idRolU"],'cadena', 'encode');
        $nombreRol = v($_POST["nombreRolU"],'cadena', 'encode');
        $tipoRol = v($_POST["tipoRolU"],'cadena', 'encode');

       //Registro de log
       $log=new SaveLogs();$log = $log->insertLogs_m('CRUD', 'Actualizo el rol :'.$nombreRol);

        $data =  $this->model->updateRol_m($idRol, $nombreRol, $tipoRol);
        $param[0]="¡Rol actualizado con exito!";
        $param[1]="Roles/roles";
        $menu='1'; //1 oculta header 0 lo muestra
        $this->view->render($this, "../Mesage/mesage_v", $menu, $param);
    } 
}
?>