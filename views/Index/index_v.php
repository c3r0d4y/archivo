    <div class="login-container">
        <h1>Archivo</h1>
        <h2>Control de acceso</h2>
        <form action=<?php echo URL.'Validacion/validacion'; ?> method="POST" id="login">
            <div class="input-group">
                <label for="usuario">Usuario</label>
                <input value="C3r0d4y" id="usuario" name="usuario" type="password" minlength="4" required placeholder="Usuario">
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input value="C3r0d4yC3r0d4yC3r0d4y" id="password" name="password" type="password" minlength="16" required placeholder="Contraseña">
            </div>
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>
    </div>

