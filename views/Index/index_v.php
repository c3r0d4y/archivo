
<div class="circulos">
    <div class="cyber-circle"></div>
    <div class="cyber-circle"></div>
    <div class="cyber-circle"></div>
    <div class="c_index">
        <form action=<?php echo URL.'Validacion/validacion'; ?> method="POST" id="login">
                <table>
                    <h1>Archivo</h1>
                    <tbody>
                        <tr><td><input value="ceroday" id="usuario" name="usuario" type="password" minlength="4" required placeholder="Usuario"></td></tr>
                        <tr><td><input value="Cerodaycerodayceroday1" id="password" name="password" type="password" minlength="16" required placeholder="Contraseña"></td></tr>
                        <tr><td><button type='submit' class='btn'>Acceder</button></td></tr>
                        <input type="hidden" name="token" value="<?php //echo $_SESSION['token'] ?>">  
                    </tbody>
                </table>        
        </form>
    </div>
</div>