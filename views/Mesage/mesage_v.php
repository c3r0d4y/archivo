<link rel="stylesheet" href= "../resource/css/botones.css">
<?php
$mensaje=$param[0];
$ruta=$param[1];
//cuando la pagina de destino necesita un parametro
$nombreVariable="";
$valorVariable="";
if(isset($param[2]) && isset($param[3])){
    $nombreVar=$param[2];
    $valorVariable=$param[3];
}     
?>
<div class="c_mensaje">
    <div>
        <form action="<?php
            if($ruta=="localhost"){
                echo $ruta;
            }else{ echo URL.$ruta; }
            ?>" method="POST">
            <table>
                <h1><?php echo $mensaje; ?></h1>
                <tbody> 
                     <tr>
                        <td><button type="submit" class="btn">Hack</button></td>
                    </tr>
               </tbody>
               <input type="hidden" value="<?php echo $valorVariable; ?>" name="<?php echo $nombreVar; ?>">
            </table>    
        </form>
   </div>
</div>