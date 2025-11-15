<div class="modal m500">
     <form action="update_usuario" method="POST"  enctype="multipart/form-data" id="formPerfil" name="formPerfil">   
        <table class='t_perfil'>
            <div onclick="update_usuario()" class="btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
            <div class='table-title'>Editar mi perfil</div>
            <tbody>
                <tr>
                    <td colspan='2' class='w200'><output id="archivo_t" class="archivo_t w200"><img src="../resource/images/fotos_usuarios/default.png" alt=""></output></td>
                </tr>
                <tr><th colspan='2'>Nombre</th></tr>
                <tr><td colspan='2'><input type="text" placeholder="nombre de usuario" id="nombreUsuario" name="nombreUsuario" readonly ></td></tr>
                <tr><th colspan='2'>Matricula</th></tr>
                <tr><td colspan='2'><input type="text" placeholder="Matricula" id="matricula" name="matricula" readonly ></td></tr>
                <tr>
                    <td class="btn" onclick='muestraModalPass()'>Cambiar Contaseña</td>
                    <td class="btn" onclick='muestraModalPin()'>Configurar PIN</td>
                </tr>
                <tr><td colspan='2'><input type="file" id="foto" name="foto" class="btn" /></td></tr>
            </tbody>
            <input type="hidden" id="nombreArchivoDB" name="nombreArchivoDB" value=0>
            <input type="hidden" id="imagen" name="imagen" value=0>
            <input type="hidden" id="idUsuario" name="idUsuario" value="">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
        </table>
    </form>   
<!-- Modal para cambio de contraseña -->
<div class="bgModal ocultar" id="m_insert">
    <div class="modal m500">
        <div class="cancelar btn_img ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="guardar_password()" class="btn_img le ocultar" id='guardar'><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <div class='table-title'>Cambiar contraseña</div>
        <form action="updatePassword" id="formPassword" name="formPassword" method="POST">
            <table>
                <tr>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                </tr>
                <tr>
                    <td> <input type="text" placeholder="Usuario" id="usuario" name="usuario" minlength="16"></td>
                    <td><input type="text" placeholder="Contraseña" id="password" name="password" required></td>
                <tr>
                <tr>
                    <th>Nuevo Usuario</th>
                    <th>Nueva contraseña</th>
                </tr>
                <tr>
                    <td> <input type="text" placeholder="minimo 4 caracteres" id="usuarioN" name="usuarioN" minlength="16" onkeyup="validar_password()"></td>
                    <td><input type="text" placeholder="16 caracteres, 1 mayuscula, un numero" id="passwordN" name="passwordN" onkeyup="validar_password()"></td>
                <tr>
                       
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
            </table>
        </form>
    </div>
</div>
<!-- Modal para cambio de pin -->
<div class="bgModal ocultar" id="m_insert1">
    <div class="modal m500">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="updatePin()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <div class='table-title'>Configurar PIN</div>
        <form action="#" id="formPin" name="formPin" method="POST">
            <table>
                <tr>
                    <td> <input type="text" placeholder="Nuevo PIN" id="pin" name="pin"  minlength="7" required></>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
                <tr>
                <tr>
                    <td><input type="text" placeholder="Verifique PIN" id="pinV" name="pinV"  minlength="7" required></td>
                <tr>  
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
               document.getElementById("archivo_t").innerHTML = ['<img class="foto" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
            };
            })(f);
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('foto').addEventListener('change', archivo, false);
</script>