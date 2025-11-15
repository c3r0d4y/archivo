
<?php
   $idDocumento=$_SESSION['idDocumento'];
   $numeroDocumento=$_SESSION['numeroDocumento'];
?>
<div class="container">
    <div >
        <a href="archivo"><div class='btn_img le'><img src='../resource/images/iconos/volver.png'></div></a>
        <div class='table-title'>Asociar documento a activo o caso (<?php echo $numeroDocumento; ?>)</div>
        <form name="formRegistro" method="POST">
        <table class="table-input">
            <tr>
                <td><select name="activos" id="activos"></select></td>
                <td><select name="casos" id="casos"></select></td>
                <td class='btn_img' ><div onclick="insert_asociar()"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div></td>
            </tr>
            <input type="hidden" name="idDocumento" id="idDocumento" value="<?php echo $idDocumento; ?>">
        </table>
        </form>
    </div>
    <div id="activosAsociados" class="table-container"></div>
    <div id="casosAsociados" class="table-container"></div>
</div>

<!--Modal delete -->
<div id="m_delete" class="bgModal ocultar">
        <div class="modal m500">
            <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
            <div onclick="deleted()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
            <div class='table-title'>¿Desea eliminar esta asociacion?</div>
            <form method="post" action="delete_asociado" name="formDelete">
                <table class="tableInsert">
                    <tr><td><div id="nombreActivoD"></div></td></tr>
                    <input type="hidden" id="idDelete" name="idDelete">
                    <input type="hidden" id="activoCaso" name="activoCaso">
                    
                </table>
            </form>
        </div> 
    </div>
    <div id="m_campo_vacio" class="bgModal ocultar"> 
    <div class="modal m_eliminar">
        <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <h1>Los campos no pueden quedar vacios</h1> 
    </div>
</div>