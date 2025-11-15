<div class="container">
    <div class='btn_img'><a href="<?php echo URL."Archivo/archivo"; ?>"><img src='../resource/images/iconos/volver.png'></a></div>
    <div class='btn_img ri' onclick="insert_rol()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></div>
    <div class='table-title'>Editar roles</div>
    <div id="bRoles" class="table-container"></div>
</div>
<!-- Modal para insertar u rol -->
<div id="m_insert" class="bgModal ocultar">
    <div class="modal m500">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="updated()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <div class='table-title'>Guardar rol</div>
        <form action="#" method="POST" name="formInsert" id="formInsert">
            <table>
                <tbody>
                    <tr><td>Nombre del rol</td></tr>
                    <tr><td><input type="text" name="nombreRolU" id="nombreRolU" required></td></tr>
                    <tr><th>Tipo del rol</th></tr>
                    <tr><td><select name="tipoRolU" id="tipoRolU"></select></td></tr>
                </tbody>
                <input type="hidden" name="idRolU" id="idRolU" required>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
            </table>
        </form>
    </div>    
</div>
<!-- Modal delete -->
<div id="m_delete" class="bgModal ocultar"> 
    <div class="modal m500">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="deleted()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>    
        <div class='table-title'>¿Esta seguro de eliminar?</div>
        <form action="#" method="POST" id="formDelete" name="formDelete">
            <table>
                <tr><td><div id="nombreDelete"></div></td></tr>
                <td><input type="hidden" name="idDelete" id="idDelete" value=""></td>
                <td><input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> </td>
                </tr>
            </table>
        </form>
    </div>
</div>
