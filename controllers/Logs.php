
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
        $tipoBusqueda = $_POST["tipoBusqueda"];
        $usuario = $_POST["usuario"];
        $documento= $_POST["documento"];
        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];
        
        //echo $tipoBusqueda."|".$usuario."|".$documento."|".$fechaInicio."|".$fechaFin."<br/>";
        $no=0;
        $count=0;
        
        $count_tr=0;
        $respond = $this->model->getLogs_M($tipoBusqueda, $usuario, $documento, $fechaInicio, $fechaFin);
        echo "
        <table class='data-table'>
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
            $roles = "
            <tr>" .
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
