<?php
$idActivo=$_SESSION['idActivo'];
?>

<div class="c_main">
    <h1><a href="<?php echo URL."Expedientes/expedientes"; ?>"><div class='btn_img le'><img src='../resource/images/iconos/volver.png'></div></a>Expediente</h1>
    
    <div>
        <table>
            <tr>
                <td>
                    <input type="text" id="getNumeroDocumento" name="getNumeroDocumento" value="" onKeyUp="get_documentos('0')" placeholder="Buscar No. documento" >
                <td>
                    <input type="text" id="getAsuntoDocumento" name="getAsuntoDocumento" value="" onKeyUp="get_documentos('0')" placeholder="Buscar por asunto" >
                </td>
                <td>
                    <input type="date" id="getFechaDocumento" value="" onChange="get_documentos('0')">
                    <input type="hidden" id="idActivo" value="<?php echo $idActivo; ?>">
                </td>
                <td class='btn_img'><div id="pendientes"><img src='../resource/images/iconos/pendientes.png' ></div></td>
                <td class='btn_img'><div id="limpiar"><img src='../resource/images/iconos/limpiar.png'></div></td>
            </td>
            </tr>
        </table>
    </div>
        <table>
            <thead>
                <tr class='trth'>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Unidad</th>
                    <th>No.</th>
                    <th>Asunto</th>
                    <th>E/S</th>
                    <th>Copia</th>
                </tr>
            </thead>
            <tbody id="getDocumentos"></tbody>
        </table>
</div>         

<div id="m_registro_documento" class="bgModal ocultar" >
    <div class="modal m_registro_documento">
        <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="guardar_documento()" class="b_guardar le"><img src="<?php echo URL; ?>resource/images/iconos/guardar.png"></div>
        <form action="#" method="POST" name="registroForm" id="registroForm" enctype="multipart/form-data">
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
                        <td><input type="date" placeholder="fechaDocumento" id="fechaDocumento" name="fechaDocumento" required></td>
                        <td><input type="text" placeholder="Expediente" id="expediente" name="expediente"></td>
                        <td><input type="text" placeholder="Numero de documento" id="numeroDocumento" name="numeroDocumento" required></td>
                    </tr>     
                    <tr><th colspan="3">Asunto del documento</th></tr>
                    <tr><td colspan="3"><input type="text" placeholder="asunto del documento" id="asuntoDocumento" name="asuntoDocumento" required></td></tr>
                    <tr><th colspan="3">Acuerdo</th></tr>
                    <tr><td colspan="3"><input type="text" placeholder="Acuerdo del documento" id="acuerdoDocumento" name="acuerdoDocumento" required></td></tr> 
                    <tr><th>Cargar un archivo</th><th>Asociar a un caso</th><th>Asociar a un Activo</th></tr>
                    <tr id="subirImagen">
                        <td><input type="file" name="archivo" ></td>
                        <td><select id="casos" name="casos"></select></td>
                        <td><select id="activos" name="activos"></select></td>
                    </tr>
                    
                </tbody>
                <input type="hidden" name="idDocumento" id="idDocumento" placeholder="idDocumento">
                <input type="hidden" name="imagen" id="imagen" placeholder="Sin imagen">
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
        <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <iframe src="#" id="vista" frameborder="0"></iframe>
    </div>   
    
</div>
<!--Modal
 eliminar -->
<div id="m_eliminar" class="bgModal ocultar"> 
    <div class="modal m_eliminar">
        <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="eliminar_documento()" class="b_eliminar le"><img src="<?php echo URL; ?>resource/images/iconos/eliminar.png"></div>
        <h1>¿Esta seguro de eliminar este No. de Documento?</h1>
        
        <form action="#" method="POST" id="formDelete" name="formDelete">
            <table>
                <tr> <td><input type="text" name="nombre_eliminar" id="nombre_eliminar" value=""></td></tr>
                <tr>
                   
                    <td><input type="hidden" name="id_eliminar" id="id_eliminar" value=""></td>
                    <td><input type="hidden" name="nombre_archivo" id="nombre_archivo" value=""></td>
                              
                </tr>
            </table>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>"> 
        </form>
    </div>
</div>
<div id="m_campo_vacio" class="bgModal ocultar"> 
    <div class="modal m_eliminar">
        <div class="b_cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <h1>Los campos no pueden quedar vacios</h1> 
    </div>
</div>

