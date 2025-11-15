<div class="container">
    <div class='btn_img'><a href="<?php echo URL."Archivo/archivo"; ?>"><img src='../resource/images/iconos/volver.png'></a></div>
    <div class='btn_img ri' onclick="insert_unidad()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></div>
    <div class='table-title'>Editar unidades</div>    
    <div id="bUnidades" class="table-container"></div>
</div>

<!-- Delete -->
<div id="m_delete" class="bgModal ocultar"> 
    <div class="modal m500">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="deleted()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
        <div class='table-title'>¿Esta seguro de eliminar?</div>   
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
    <div class="modal m500">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="guardar_unidad()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <div class='table-title'>Unidades</div>
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
