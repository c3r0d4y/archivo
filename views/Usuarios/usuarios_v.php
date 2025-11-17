<div class="container">
    <div class="table-search">
    <table class="table-input">
        <tr>
            <td class='btn_img'><a href="<?php echo URL."Archivo/archivo"; ?>"><img src='../resource/images/iconos/volver.png'></a></td>
            <td>
                <input type="text"placeholder="Busqueda de usuarios" name="buscarUsuarios" id="getUsuario" onkeyup="get_usuarios()">
            </td>
            <td class='btn_img'>
                <div onclick="insert_usuario()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></div>
            </td>
        </tr>
    </table>
    </div>
    <div class='table-title'>Registro de usuarios</div>
    <div id="getUsuarios" class="table-container"></div>   
</div>         
<!-- modal para registro o actualizacion de usuarios -->
<div id="m_insert" class="bgModal ocultar">
    <div class="modal m700">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="updated()" id="guardar" class="btn_img le ocultar"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <div class='table-title'>Editar usuario</div>
        <form action="#" method="POST"  enctype="multipart/form-data" id="formInsert" name="formInsert">
            <table>
                <tbody>
                    <tr><th>Unidad</th><th>Rol</th><th>Estado</th></tr>
                    <tr>
                        <td><select id="unidades" name="unidades" onchange="validar_password()"></select></td>
                        <td><select id="roles" name="roles"></select></td>
                        <td>
                            <select id="estado" name="estado">
                                <option value="0">Disponible</option>
                                <option value="2">Bloqueo</option>
                                <option value="3">Baja</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Grado</th>
                        <th colspan="2">Especialidad</th>
                    </tr>
                    <tr>
                        <td><select id="grados" name="grados" onchange="validar_password()"></select></td>
                        <td colspan="2"><select id="especialidades" name="especialidades" onchange="validar_password()"></select></td></tr>
                    
                    <tr>
                        <td rowspan="9" class='w150'><output id="archivo_t" class="archivo_t"><img src="../resource\images\fotos\default.png" alt=""></output></td>
                        <th colspan="2">Nombre de usuario</th>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text" placeholder="Nombre de usuario" onkeyup="validar_password()" id="nombreUsuario" name="nombreUsuario" required></td></tr>
                    <tr>
                        <th colspan="2">Matricula</th></tr>
                    <tr>
                        <td colspan="2"> <input type="text" placeholder="matricula" onkeyup="validar_password()" id="matricula" name="matricula" required></td><tr>
                    <tr>
                        <th colspan="2">Usuario</th></tr>
                    <tr>
                        <td colspan="2"> <input type="text" placeholder="Usuario" onkeyup="validar_password()" id="usuario" name="usuario"  required></td><tr>
                    <tr>
                        <th colspan="2">Password</th></tr>
                    <tr>
                        <td><input type="file" id="archivo" class="btn b_subir_archivo" name="archivo" /></td>    
                        <td colspan="2"><input type="text" placeholder="Mas de 15 caracteres, numeros y letras (Una mayuscula)" id="password" name="password" onkeyup="validar_password()" required></td>
                    <tr>
                    <tr><input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"><tr>
                </tbody>
                <input type="hidden" id="nombreArchivoDB" name="nombreArchivoDB" value="">
                <input type="hidden" id="idUsuario" name="idUsuario" value="">
            </table>
        </form>
    </div>
</div>
<!--Modal eliminar -->
<div id="m_delete" class="bgModal ocultar"> 
    <div class="modal m500">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="deleted()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
        <div class='table-title'>¿Esta seguro de eliminar?</div>
        <form action="#" method="POST" id="formDelete" name="formDelete">
            <table>
                <tbody>
                    <tr><td><input type="text" name="nombreEliminar" id="nombreEliminar"></td></tr>
                </tbody>
                <td><input type="hidden" name="idEliminar" id="idEliminar" value=""></td>
                <input type="hidden" name="archivoEliminar" id="archivoEliminar" value="">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
            </table>
        </form>
    </div> 
</div>

<!-- modal para agregar un rol a un usuario -->
<div id="m_insert1" class="bgModal ocultar">
    <div class="modal m500">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div class='table-title'>Roles asignados a:</div>
        <h2 id="nURonl" ></h2>
        <table id="bRolesU"></table>
        <form action="#" method="POST" id="formInsert1" name="formInsert1"> 
            <table>
                <caption>- - - - - - - - - - - -- - - -  - - - - - - - - - - -</caption>
                <tbody>
                    <tr>
                        <td><input type="hidden" name="idU" id="idU" value=""></td>
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
                        <td><select id="rolesa" name="rolesa" require></select></td>
                        <td><button type="submit" class="btn" onclick='valida()'>Agregar</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<script>
   function archivo(evt) {
        var files = evt.target.files; // FileList object
        // Obtenemos la imagen del campo "file".
        for (var i = 0, f; f = files[i]; i++) {
           //Solo admitimos imágenes.
            if (!f.type.match('image.*')) {
                continue;
             }
            var reader = new FileReader();
            reader.onload = (function(theFile) {
               return function(e) {
               // Insertamos la imagen
               document.getElementById("archivo_t").innerHTML = ['<img class="archivo" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
            })(f);
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('archivo').addEventListener('change', archivo, false);
    get_usuarios();  
</script>



