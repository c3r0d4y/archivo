<div class="c_main c_unidades">
    <table>
        <tr>
            <td><h1>Unidades</h1></td>
            <td><td class='btn_img'><div onclick="insert_unidad()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></div></td>
        </tr>
    </table>    
    <div id="bUnidades" class="scroll"></div>
</div>

<!-- Delete -->
<div id="m_delete" class="bgModal ocultar"> 
    <div class="modal1">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="deleted()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
        <h1>¿Esta seguro de eliminar?</h1>
        <h2 id="nombreDelete"></h2>
        <form action="#" method="POST" id="formDelete" name="formDelete">
            <table>
                <tr class="centrar">
                    <td><input type="hidden" name="idDelete" id="idDelete" value=""></td>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- Insert -->
<div id="m_insert" class="bgModal ocultar">
    <div class="modal1">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="guardar_unidad()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <h1>Unidades</h1>
        <form action="#" method="POST" id="formInsert" name="formInsert">
            <table>
                <tbody>
                    <tr ><th>Abreviatura de la unidad</th></tr>
                    <tr><td><input type="text" name="claveUnidadU" id="claveUnidadU" required></td></tr>
                    <tr><th>Nombre de la ubidad</th></tr>
                    <tr><td><input type="text" name="nombreUnidadU" id="nombreUnidadU" required></td></tr>
                </tbody>
                <input type="hidden" name="idUnidadU" id="idUnidadU" required>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
            </table>
        </form>
    </div>
</div>
