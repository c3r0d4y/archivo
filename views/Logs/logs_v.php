<div class="c_main">
    <h1>Logs</h1>
    <table>
        <tr>
            <td><input type="text" id="usuario" placeholder="Usuario" onkeyup="get_logs();" value="" ></td>
            <td><input type="text" id="documento" placeholder="No. Documento" onkeyup="get_logs();" value="" ></td>
            <td class="date"><input type="date" id="fecha" onchange="get_logs();" value=""></td>
            <td class='btn_img'><img src='../resource/images/iconos/limpiar.png'></td>
        </tr>
    </table>
    <div id="logs" class="scroll"></div>
</div>
