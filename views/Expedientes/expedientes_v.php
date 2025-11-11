
<div class="c_main">
    <a href="activos"><div class='btn_img le'><img src='../resource/images/iconos/volver.png'></div></a>
    <h1>Expedientes de Activos</h1>
    <table class="t_search">
        <tr>
            <td><select name="tipoActivo" id="tipoActivo" onChange="get_bitacora_activos()"><option value="internet">Internet</option><option value="intranet">Intranet</option></select></td>
        </tr>
    </table>
    <div id="activos"></div>
</div>

<!--Modal insert -->
<div id="m_insert_activo" class="bgModal ocultar">
    <div class="modal m_insert">
        <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <h1>Guardar Activo</h1>
        <form method="post" action="" name="formActivos">
            <table class="t_insert">
                <tr>
                    <th colspan="2">Nombre del activo</th>
                    <th>Administrador del activo</th>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="nombreActivo" id="nombreActivo" require></td>
                    <td><input type="text" name="administradorActivo" id="administradorActivo" require></td>
                </tr>
                <tr>
                    <th>Unidad del activo</th>
                    <th>Extenciones</th>
                    <th>Estado del activo</th>
                </tr>
                <tr>
                    <td><select id="unidadActivo" name="unidadActivo"></select></td>
                    <td><input type="text" name="extencionActivo" id="extencionActivo" require></td>
                    <td>
                        <select name="estadoActivo" id="estadoActivo">
                            <option value="A">Disponible</option>
                            <option value="B">Suspendido</option>
                            <option value="C">Baja</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">URL del del activo</th>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" name="urlActivo" id="urlActivo" require></td>
                </tr>
                <tr><th colspan="3">Descripción del activo</th></tr>
                <tr><td colspan="3"><textarea type="text" name="descripcionActivo" id="descripcionActivo"></textarea></td></tr>
                
                <input type="hidden" id="idActivo" name="idActivo">
            </table>
        </form>
    </div> 
</div>
<!--Modal delete -->
<div id="m_delete_activo" class="bgModal ocultar">
        <div class="modal m_delete">
            <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
            <div onclick="eliminar_activo()" class="b_guardar le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
            <h1>¿Desea eliminar este caso?</h1>
            <form method="post" action="d" name="formDeleteActivo">
                <table class="tableInsert">
                    <tr><td><div id="nombreActivoD"></div></td></tr>
                    <input type="hidden" id="idActivoD" name="idActivoD">
                    
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