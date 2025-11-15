<?php
    $_SESSION['token']=random_int(100, 9999);
?>
 <link rel="stylesheet" href= "../resource/css/modals.css">
  <link rel="stylesheet" href= "<?php echo URL."resource/css/common.css"; ?>" >
<div class="modal m500">
    <table>
        <div class='table-title'>¿Con qué rol quieres iniciar?</div>
        <tbody>
            <?php
                foreach ($param as $row){
                    $nRol=$row[0];
                    echo "
                    <tr>
                        <td><button id='$nRol' class='btn'>$nRol</button></td>
                    </tr>";
                } 
                if(isset($_SESSION['rol'])){
                     header("Location:".URL."Archivo/archivo");
                }
            ?>
        </tbody>
    </table>
</div>
<script>
    var botones = document.getElementsByClassName("btn");
    for(var i = 0; i < botones.length; i++) {
        botones[i].addEventListener('click', comprueba, false);
    }
    function comprueba(){
        var valor=this.id;
        console.log(valor);
        enviar(valor);
    }
    function enviar(valor){
        var valores = 'valores='+valor;
        $.ajax({
            type: "POST",
            url: "grabarRol",
            data: valores,
            success: function(response)
            {
               location.href ="../Archivo/archivo";
            }
        });
    }
</script>