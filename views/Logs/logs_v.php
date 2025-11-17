<div class="container">
    <div class="table-search">
        <table class="table-input">
            <tr>
                <td class='btn_img'><a href="<?php echo URL."Archivo/archivo"; ?>"><img src='../resource/images/iconos/volver.png'></a></td>
                <td>
                    <select name="tipoBusqueda" id="tipoBusqueda" onchange="get_logs();">
                        <option value="pornumero">Busqueda por numero de documento</option>
                        <option value="pornombre">Buscar por nombre del usuario</option>
                        <option value="pornombreyperiodo">Buscar por nombre de usuario y periodo</option>
                        <option value="porperiodo">Buscar por periodo</option>
                    </select>
                </td>
                <td><input class="ocultar" type="text" id="usuario" placeholder="Usuario" onkeyup="get_logs();" value="" ></td>
                <td><input class="ocultar" type="text" id="documento" placeholder="No. Documento" onkeyup="get_logs();" value="" ></td>
                <td><input class="ocultar" type="date" id="fechaInicio" onchange="get_logs();" value=""></td>
                <td><input class="ocultar" type="date" id="fechaFin" onchange="get_logs();" value=""></td>
                <td><div class='btn_img' id="limpiar"><img src='../resource/images/iconos/limpiar.png'></div></td>
            </tr>
        </table>
    </div>
    <div class='table-title'>Registro de eventos</div>
    <div id="logs" class="table-container"></div>
</div>
