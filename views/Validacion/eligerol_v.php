<?php
    $_SESSION['token']=random_int(100, 9999);
?>
<div class="c_rol">
    <table>
        <h1>¿Con qué rol quieres iniciar?</h1>
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
                     header("Location:".URL."Archivo/archivo_c");
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