<?php
    $id_sec=$_POST['id_sec'];
    echo "ok= ".$id_sec."<br/>";
?>
<div class="c_main c_unidades">
    <form action=""><table><tr><td><input type="hidden" id="id_unidad" value = "<?php echo  $id_unidad; ?>"></td></tr></table></form>
    <h1>Asignacion de Subsecciones
    <div class="b_volver"><a href="unidades">‹‹</a></div>
    <div id="insertUsuario" class="b_agregar" onclick='insertAsignacion()'>+</div>
    </h1>
    <div id="secciones" class="scroll"></div>
</div>
<!-- Modal para eliminar -->
<div id="m_eliminar" class="bgModal ocultar"> 
    <div class="modal m_eliminar">
        <h1>¿Esta seguro de eliminar?<div class="b_cancelar">X</div></h1>
        <div id="nombre_eliminar"></div>
        <form action="#" method="POST" id="deleteForm" name="deleteForm">
            <table>
                <tr class="centrar">
                    <td><input type="hidden" name="id_eliminar" id="id_eliminar" value=""></td>
                    <input type="hidden" name="id_volver" id="id_volver" value="<?php echo $id_unidad; ?>">
                    <td><button type="submit" class="boton">Aceptar</button></td>
                    
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- Modal para registrar -->
<div id="m_asignacion" class="bgModal ocultar">
    <div class="modal m_asignacion">
        <form action="#" method="POST" id="formA" name="formA">
            <table>
                <caption>Agregar Sección<div class="b_cancelar">X</div></caption>
                <tbody>
                    <tr ><th>Abreviatura de seccion</th></tr>
                    <tr><td><select id="id_seccion" name="id_seccion"></select></td></tr>
                    <tr class="centrar"><td><button type="submit" class="boton" >Guardar</button></td></tr>
                </tbody>
                <input type="hidden" name="id_unidad" id="id_unidad" value="<?php echo $id_unidad; ?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
            </table>
        </form>
    </div>
</div>