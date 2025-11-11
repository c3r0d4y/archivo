
<?php
class Logs extends Controllers
{
    function __construct(){
        parent::__construct();
    }
    //Para la vista de interfaz de usuarios OK
    public function logs(){
       if (null != Session::getSession("user")){
            $param='';
            $menu='';
            $rol = $_SESSION['user']['rol'];
            $this->view->render($this, "logs_v", $menu, $param);
        } else {
                echo "<script>alert('Salir');</script>";
                header("Location:".URL);
        }
    }
    public function get_logs(){
        $usuario = $_POST["usuario"];
        $documento= $_POST["documento"];
        $fecha = $_POST["fecha"];
            
        //echo "|".$usuario."|".$documento."|".$fecha."|<br/>";
        $no=0;
        $count=0;
        $bg_tr="claro";
        $count_tr=0;
        $respond = $this->model->getLogs_M($usuario, $documento, $fecha);
        echo "<table>
            <tr>
                <th class='no'>No.</th>
                <th>Tipo</th>
                <th>Accion</th>
                <th>Pagina</th>
                <th>IP</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Rol</th>
            </tr>";
        foreach ($respond as $row){
            $datosR=json_encode($respond[$count]);
            $no++;
            if($count_tr==0){$bg_tr="logc";$count_tr++;}else{$bg_tr="logo";$count_tr=0;}
            $roles = "
            <tr class='$bg_tr'>" .
                "<td>$no</td>".
                "<td>$row[1]</td>".
                "<td>$row[2]</td>".
                "<td >$row[3]</td>".
                "<td >$row[4]</td>".
                "<td >$row[5]</td>".
                "<td >$row[6]</td>".
                "<td >$row[7]</td>".
            "</tr>";
            echo $roles;
            $count++;
        }
        echo "</table>";
    }
}
?>
