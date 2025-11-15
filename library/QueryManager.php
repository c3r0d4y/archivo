<?php
class QueryManager{
        public $conexion;
        public $conexion_db;
        function __construct($USER, $PASS, $DB){
                $this->conexion = mysqli_connect('localhost', $USER, $PASS, $DB);
                if (!$this->conexion) {
                        die('Error de Conexión (' . mysqli_connect_errno() . ') '
                         . mysqli_connect_error());
                }
                $this->conexion_db = mysqli_connect('localhost', $USER, $PASS, $DB);
                if (!$this->conexion_db) {
                        die('Error de Conexión (' . mysqli_connect_errno() . ') '
                         . mysqli_connect_error());
                }
        }
        function select($colum, $table, $where, $tipoSentencia){
                if($tipoSentencia=="muchosRegistros"){
                        $query = "SELECT $colum FROM $table $where";
                        //echo $query."<br/>";
                        $result=mysqli_query($this->conexion, $query);
                        $ask=mysqli_fetch_all($result);
                }
                elseif($tipoSentencia=="unRegistro") {
                        $query = "SELECT * FROM $table $where";
                        $result=mysqli_query($this->conexion, $query);
                        $ask=mysqli_fetch_array($result);
                } 
                elseif($tipoSentencia=="recorrer") {
                        date_default_timezone_set('America/Mexico_City');
                        $fecha=date('Ymdhi');
                        $query = "SELECT $colum FROM $table";
                        $ask[0]="";
                        $claveLector=$where;
                        $result=mysqli_query($this->conexion, $query);
                        while($row = mysqli_fetch_array($result))
                        { 
                                $claveLectorDB = hash('sha256', $row[1].$fecha);
                                if($claveLectorDB==$claveLector){
                                $ask[0]=$row[1];
                                }
                        } 
                }else{
                        $ask[0]="Sin query";
                }
                return ($ask);
                mysqli_close($this->conexion);       
        }
        function insert($tabla, $campos, $values, $intruccion){
                $query = "INSERT INTO $tabla ($campos) VALUES ($values)";
                //echo $query;
                mysqli_query($this->conexion , $query);
                $idUltimo=mysqli_insert_id($this->conexion);
                if($intruccion == 0){
                        //echo "Cerrando query";
                        mysqli_close($this->conexion);
                }
                return ($idUltimo);
        }
        function update($table, $where, $values){
                $query = "UPDATE $table set $values $where";
                mysqli_query($this->conexion , $query);
                //mysqli_close($this->conexion);
        }
        function delete($tabla, $where, $instruccion){
                $query = "DELETE FROM $tabla $where";
                //echo "query=".$query."<br/>";
                mysqli_query($this->conexion , $query);  
                if (mysqli_affected_rows($this->conexion) > 0) {
                        return(1);
                }else{
                        return(0);
                }
                if($instruccion==0){
                        mysqli_close($this->conexion);
                }
        }
        function insertArchivo($archivo, $ruta, $nombreArchivo){
                $extensionArchivo = $archivo['name'];
                $extensionArchivo= substr(strrchr($extensionArchivo, '.'), 1);
                $extensionArchivo = strtolower($extensionArchivo);//convertir las extensiones aminusculas
                $nombreArchivo=$nombreArchivo.'.'.$extensionArchivo;
                $comprobar=$ruta.$nombreArchivo;
                $archivo=$archivo['tmp_name'];
                //Si se carga un archivo y no habia uno anteriormente cargamos la nueva imagen
                if($archivo!=null){
                   move_uploaded_file($archivo, $ruta.$nombreArchivo);
                }    
                return ($nombreArchivo);
        }
        function updateArchivo($archivo, $ruta, $nombreArchivoNuevo, $nombreArchivoDB){
                //Eliminamos el archivo actual
                if($nombreArchivoDB!="default.png" && $nombreArchivoDB!=""){
                     unlink($ruta.$nombreArchivoDB);
                }
                //Agregamos el nuevo archivo
                $extensionArchivo = $archivo['name'];
                $extensionArchivo= substr(strrchr($extensionArchivo, '.'), 1);
                $extensionArchivo = strtolower($extensionArchivo);//convertir las extensiones aminusculas
                $nombreArchivo=$nombreArchivoNuevo.'.'.$extensionArchivo;
                $comprobar=$ruta.$nombreArchivo;
                $archivo=$archivo['tmp_name'];
                move_uploaded_file($archivo, $ruta.$nombreArchivo);
                return($nombreArchivo);
        }
        function deleteArchivo($ruta, $archivo){
           unlink($ruta.$archivo);
        }           
}

?>