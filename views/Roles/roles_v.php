<div class="c_main">
    <h1>Roles <div class='btn_img ri' onclick="insert_rol()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></div></h1>
    <div id="bRoles" class="scroll"></div>
</div>
<!-- Modal para insertar u rol -->
<div id="m_insert" class="bgModal ocultar">
    <div class="modal1">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="updated()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <h1>Guardar rol</h1>
     
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
    <div class="modal1">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="deleted()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>    
        <h1>¿Esta seguro de eliminar?</h1>
        <form action="#" method="POST" id="formDelete" name="formDelete">
            <table>
                <tr><td><div id="nombreDelete"></div></td></tr>
                <td><input type="text" name="idDelete" id="idDelete" value=""></td>
                <td><input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> </td>
                </tr>
            </table>
        </form>
    </div>
</div>
