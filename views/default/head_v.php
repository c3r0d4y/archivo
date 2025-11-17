<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Archivo</title>

    <script src="../resource/js/jquery-3.4.1.min.js"> type="text/javascript"></script>
    <script src="../resource/js/jquery.validate.js" type="text/javascript"></script>
    <script src='../resource/js/menu.js' type='text/javascript'></script>
    <script src='../resource/js/common.js' type='text/javascript'></script>
    
          
    <link rel="stylesheet" href= "../resource/css/common.css">
    <link rel="stylesheet" href= "../resource/css/menu.css">
    <link rel="stylesheet" href= "../resource/css/buttons.css">
    <link rel="stylesheet" href= "../resource/css/specific.css">
    <link rel="stylesheet" href= "../resource/css/modals.css">
    
    <?php
        require_once ("controllers/SaveTime.php");
        $select = $_SERVER['REQUEST_URI'];
        $select = explode("/", $select);
        $select = end($select);

        if(!isset($_SESSION['user']['rol'])){
           echo "<script>alert('Este usuario no tiene un rol asignado');</script>".
            Session::destroy();
            header("Location:".URL."/Usuarios/destroySession");  
        }
       
        $alias= $_SESSION['user']['nombre_usuario'];
        $idUsuarioSession= $_SESSION['user']['id_usuario'];
        $rolSession = $_SESSION['user']['rol'];
        $nombreSession = $alias.'  ('.$rolSession.')';
        $fotoSession= $_SESSION['user']['foto_usuario'];
        $fotoSession='../resource/images/fotos_usuarios/'.$fotoSession;
        $time=new saveTime();
        $time = $time->guardaTiempo( $idUsuarioSession);

        //Tiempo de session
        $tiempo_limite=3000;
        //Para corroborar envio de formularios
        $_SESSION['token']=random_int(100, 9999);
        //echo "Token en head =".$_SESSION['token'];
        
        if($select=='usuarios'){
            echo "<script src='../resource/js/usuarios.js' type='text/javascript'></script>";
        }
        elseif($select=='expedientes'){
            echo "<script src='../resource/js/expedientes.js' type='text/javascript'></script>";
        }
        elseif($select=='roles'){
            echo "<script src='../resource/js/roles.js' type='text/javascript'></script>";
        }
        elseif($select=='unidades'){
            echo "<script src='../resource/js/unidades.js' type='text/javascript'></script>";
        }
        elseif($select=='perfil'){
            echo "<script src='../resource/js/perfil.js' type='text/javascript'></script>";
        }
        elseif($select=='logs'){
            echo "<script src='../resource/js/logs.js' type='text/javascript'></script>";
        }
        elseif($select=='hacking'){
            echo "<script src='../resource/js/hacking.js' type='text/javascript'></script>";
        }
        elseif($select=='archivo'){
            echo "<script src='../resource/js/archivo.js' type='text/javascript'></script>";
        }
        elseif($select=='expediente'){
            echo "<script src='../resource/js/expediente.js' type='text/javascript'></script>";
        }
        elseif($select=='mensajes'){
            echo "<script src='../resource/js/mensajes.js' type='text/javascript'></script>";
        }
        elseif($select=='adjuntos'){
            echo "<script src='../resource/js/adjuntos.js' type='text/javascript'></script>";
        }
       
        date_default_timezone_set("America/Mexico_City");
        $hora = $_SESSION['user']["hora"];

        $ahora = date("Y-m-d H:i:s");
        //echo "Ahora=".$ahora.">>$hora<br/>";
        $tiempo_transcurrido = (strtotime($ahora)-strtotime($hora));
        //echo $tiempo_transcurrido.">>". $tiempo_limite;

        if( $tiempo_transcurrido > $tiempo_limite){
            header("Location:".URL."/Validacion/cerrarSession");
        }else{
              $_SESSION["hora"]=$ahora;
        }
 ?>
</head>
<?php  date_default_timezone_set('America/Mexico_City');?>
<body>
    <header>
        <div class="menu-icons">
            <div class="logo"><img class="logo" src="<?php echo $fotoSession;?>" ></div>
            <a  href="<?php echo URL.'Archivo/archivo';?>"><div class="menu-icon">🏠</div></a>
            <a  href="<?php echo URL.'Usuarios/usuarios';?>"><div class="menu-icon">👥</div></a>
            <a  href="<?php echo URL.'Perfil/perfil';?>"><div class="menu-icon">👤</div></a>
            <a  href="<?php echo URL.'Roles/roles';?>"><div class="menu-icon">🔑</div></a>
            <a  href="<?php echo URL.'Unidades/unidades';?>"><div class="menu-icon">📍</div></a>
            <a  href="<?php echo URL.'Logs/logs';?>"><div class="menu-icon">📝</div></a>
            <a href=<?php echo URL."Validacion/cerrarSession";?>><div class="menu-icon">🚪</div></a>
        </div>
        <div class="company-name"><?php echo $nombreSession; ?></div>
    </header>