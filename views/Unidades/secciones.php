<div class="c_main c_unidades">
    <form action=""><table><tr><td><input type="hidden" id="id_unidad" value = "<?php echo  $id_unidad; ?>"></td></tr></table></form>
    <h1>Secciones
    <div id="insertUsuario" class="b_title right" onclick='insertSeccion()'>+</div>
    <div class="b_title right"><a href="unidades">‹‹</a></div>
    </h1>
    <div id="secciones" class="scroll"></div>
</div>
<!-- Delete -->
<div id="m_delete" class="bgModal ocultar"> 
    <div class="modal m_eliminar">
        <h1>¿Esta seguro de eliminar?<div class="b_cancelar">X</div></h1>
        <form action="#" method="POST" id="deleteForm" name="deleteForm">
            <table>
                <tr class="centrar"><td><input type="test" name="nombre_delete" id="nombre_delete" value="" readonly></td></tr>
                <tr class="centrar"><td><button type="submit" class="boton">Aceptar</button></td></tr>
                <td><input type="hidden" name="id_delete" id="id_delete" value=""></td>
                <input type="hidden" name="id_volver" id="id_volver" value="<?php echo $id_unidad; ?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
            </table>
        </form>
    </div>
</div>
<!-- Insert -->
<div id="m_insert" class="bgModal ocultar">
    <div class="modal m_secciones">
        <form action="#" method="POST" id="formInsertSeccion" name="formInsertSeccion">
            <table>
                <caption>Sección<div class="b_cancelar">X</div></caption>
                <tbody>
                    <tr ><th>Abreviatura de la sección</th></tr>
                    <tr><td><input type="text" name="a_seccion" id="a_seccion" required></td></tr>
                    <tr><th>Nombre de la sección</th></tr>
                    <tr><td><input type="text" name="nombre_seccion" id="nombre_seccion" required></td></tr>
                    <tr class="centrar"><td><button type="submit" class="boton" >Guardar</button></td></tr>
                </tbody>
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
                <td><input type="text" name="id_update" id="id_update" value=""></td>
            </table>
        </form>
    </div>
</div>