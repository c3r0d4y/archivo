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
    <script src='../resource/js/refrescar.js' type='text/javascript'></script>
    <script src='../resource/js/common.js' type='text/javascript'></script>    
          
    <link rel="stylesheet" href= "../resource/css/common.css">
    <link rel="stylesheet" href= "../resource/css/menu.css">
    <link rel="stylesheet" href= "../resource/css/buttons.css">
    <link rel="stylesheet" href= "../resource/css/specific.css">
    <link rel="stylesheet" href= "../resource/css/modals.css">
        
    <?php
        require_once ("controllers/saveTime.php");
        $select = $_SERVER['REQUEST_URI'];
        $select = explode("/", $select);
        $select = end($select);

        if(!isset($_SESSION['user']['rol'])){
            echo "no reconoce el rol";
            Session::destroy();
            header("Location:".URL."/Usuarios/destroySession");  
        }
       
        $alias= $_SESSION['user']['nombre_usuario'];
        $idUsuarioSession= $_SESSION['user']['id_usuario'];
        $rolSession = $_SESSION['user']['rol'];
        $nombreSession = $alias.'  ('.$rolSession.')';
        $fotoSession= $_SESSION['user']['foto_usuario'];
        $fotoSession='../resource/images/fotos_usuarios/'.$fotoSession;
        $time=new saveTime();$time = $time->saveTime_M( $idUsuarioSession);

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
        elseif($select=='archivo'){
            echo "<script src='../resource/js/archivo.js' type='text/javascript'></script>";
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
    <div class="ascii-container" id="asciiContainer"></div>
    
    <input id="rol" type="hidden" value="<?php echo $rolSession;?>">
    <div class= "c_menu">
        <div class="m_imagen"><img src="<?php echo $fotoSession;?>" ></div>
        <div class="menu">
            <div class="m_item">
                 <a  href="<?php echo URL."Archivo/archivo"; ?>">
                 <div <?php if($select=="archivo"){ echo "class= 'm_boton m_select'";}else{echo "class='m_boton'";}?>><img src="../resource/images/iconos/home.png" /></div>
                 </a>
            </div>
             <div class='m_item'>
                <a  href="<?php echo URL."Usuarios/usuarios";?>">
                    <div <?php if($select=="usuarios"){ echo "class= 'm_boton m_select'";}else{echo "class='m_boton'";}?>><img src='../resource/images/iconos/usuarios.png' /></div>
                </a>
            </div>
            <?php
                if($rolSession=="Administrador"){
                    echo "<div class='m_item'>
                        <a  href=".URL."Roles/roles>
                        <div <?php if($select=='roles'){ class= 'm_boton m_select'}else{class='m_boton'}><img src='../resource/images/iconos/roles.png' /></div>
                        </a>
                    </div>";
                }
            ?>
            <div class="m_item">
                 <a  href="<?php echo URL."Perfil/perfil"; ?>">
                 <div <?php if($select=="perfil"){ echo "class= 'm_boton m_select'";}else{echo "class='m_boton'";}?>><img src="../resource/images/iconos/perfil.png" /></div>
                 </a>
            </div>
            <?php
                if($rolSession=="Administrador"){
                    echo "<div class='m_item'>
                        <a  href=".URL."Unidades/unidades>
                        <div <?php if($select=='unidades'){ class= 'm_boton m_select'}else{class='m_boton'}><img src='../resource/images/iconos/lugares.png' /></div>
                        </a>
                    </div>";
                }
            ?>
            <div class="m_item">
                 <a  href="<?php echo URL."Logs/logs"; ?>">
                 <div <?php if($select=="logs"){ echo "class= 'm_boton m_select'";}else{echo "class='m_boton'";}?>><img src="../resource/images/iconos/logs.png" /></div>
                 </a>
            </div>
            <div class="m_item">
                <a href=<?php echo URL."Validacion/cerrarSession";?>>
                    <div class="m_boton"><img src="../resource/images/iconos/salir.png" title="Salir" /></div>
                </a>
            </div>
        </div>
        <div class="m_nombre"><?php echo $nombreSession; ?></div>
    </div>
    <div class="cyber-dots" id="cyberDots"></div>