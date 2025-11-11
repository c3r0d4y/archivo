
<div class="c_main">
    <h1>Archivo</h1>
    <div>
        <table>
            <tr>
                <td>
                    <td><select id="buscarTipo" name="buscarTipo" onChange="get_documentos('0')"></select></td>
                <td>
                <td>
                    <input type="text" id="getNumeroDocumento" name="getNumeroDocumento" value="" onKeyUp="get_documentos('0')" placeholder="Buscar No. documento" >
                <td>
                    <input type="text" id="getAsuntoDocumento" name="getAsuntoDocumento" value="" onKeyUp="get_documentos('0')" placeholder="Buscar por asunto" >
                </td>
                <td class="date">
                    <input type="date" id="getFechaDocumento" value="" onChange="get_documentos('0')">
                </td>
                <td class='btn_img'><div class='btn_img' id="limpiar"><img src='../resource/images/iconos/limpiar.png'></div></td>
                <td class='btn_img'><div id="pendientes"><img src='../resource/images/iconos/pendientes.png' ></div></td>
                <td class='btn_img'><div onclick="insert_documento()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></div>
            </td>
            </tr>
        </table>
    </div>
    <table id="getDocumentos" class="scroll"></table>
</div>         
<div id="m_insert" class="bgModal ocultar" >
    <div class="modal4">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="guardar_documento()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <form action="#" method="POST" name="formInsert" id="formInsert" enctype="multipart/form-data">
            <table>
                <caption ><label id="mp">Menu principal</label>
                </caption>
                </tbody>
                    <tr>
                        <th>Tipo de documento</th>
                        <th>Procedencia</th>
                        <th>E/S</th>
                    </tr>
                    <tr>
                        <td><select id="tipoDocumento" name="tipoDocumento"></select></td>
                        <td><select id="procedenciaDocumento" name="procedenciaDocumento"></select></td>
                        <td><select id="esDocumento" name="esDocumento" required>
                                <option selected="selected" value="ENTRADA">Entrada</option>
                                <option value="SALIDA">Salida</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha del Documento</th>
                        <th>Expediente</th>
                        <th>No. del documento</th>
                    </tr>
                    <tr>
                        <td class="date"><input type="date" placeholder="fechaDocumento" id="fechaDocumento" name="fechaDocumento" required></td>
                        <td><input type="text" placeholder="Expediente" id="expediente" name="expediente"></td>
                        <td><input type="text" placeholder="Numero de documento" id="numeroDocumento" name="numeroDocumento" required></td>
                    </tr>     
                    <tr><th colspan="3">Asunto del documento</th></tr>
                    <tr><td colspan="3"><input type="text" placeholder="asunto del documento" id="asuntoDocumento" name="asuntoDocumento" required></td></tr>
                    <tr><th colspan="3">Acuerdo</th></tr>
                    <tr><td colspan="3"><input type="text" placeholder="Acuerdo del documento" id="acuerdoDocumento" name="acuerdoDocumento" required></td></tr> 
                    <tr><th colspan="3">Cargar un archivo</th></tr>
                    <tr id="subirImagen">
                        <td colspan="3"><input type="file" name="archivo" ></td>
                    </tr>
                    
                </tbody>
                <input type="hidden" name="idDocumento" id="idDocumento" placeholder="idDocumento">
                <input type="hidden" name="nombreArchivoDB" id="nombreArchivoDB" placeholder="Sin imagen">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>">
                <input type="hidden" name="formulario" id="formulario" value="">
                <tr><td><input type="hidden" placeholder="Usuario" id="usuarioRegistra" name="usuarioRegistra" value="<?php echo $idUsuarioSession;?>" readonly></td></tr>
                <!-- Para actualizar -->
                <tr><td><input type="hidden" name="numeroDocumentoTem" id="numeroDocumentoTem"  placeholder="numeroDocumentoTem"></td></tr>
                <tr><td><input type="hidden" name="fechaTem" id="fechaTem"></td></tr>
            </table>
        </form>
    </div>
</div>
<div id="m_ver_pdf" class="bgModal ocultar">
     <div class="m_ver_pdf">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <iframe src="#" id="vista" frameborder="0"></iframe>
    </div>   
</div>
<!--Modal
 eliminar -->
<div id="m_delete" class="bgModal ocultar"> 
    <div class="modal1">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="eliminar_documento()" class="btn_img le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
        <h1>¿Esta seguro de eliminar este No. de Documento?</h1>
        
        <form action="#" method="POST" id="formDelete" name="formDelete">
            <table>
                <tr> <td><input type="text" name="nombreDelete" id="nombreDelete" value=""></td></tr>
                <tr>
                   
                    <td><input type="hidden" name="idDelete" id="idDelete" value=""></td>
                    <td><input type="hidden" name="nombre_archivo" id="nombre_archivo" value=""></td>
                              
                </tr>
            </table>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
        </form>
    </div>
</div>
<div id="m_campo_vacio" class="bgModal ocultar"> 
    <div class="modal1 m_eliminar">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <h1>Los campos no pueden quedar vacios</h1> 
    </div>
</div>

