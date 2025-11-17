<?php
    $datosUsuario=$_SESSION['datosUsuario'];
    $idUsuario=$datosUsuario[0];
    $_SESSION['idUsuario']=$idUsuario;
    $nombreUsuario=$datosUsuario[4];
?>
    <div class="container">
        <div class="btn_img le"><a href='usuarios'><img src="<?php echo URL; ?>resource/images/iconos/volver.png"></a></div>
        <div> <a class='btn_img ri' onclick="insert_documento()"><img src="<?php echo URL; ?>resource/images/iconos/add.png"></a></div>
        <div class='table-title'>Expediente de (<?php echo $nombreUsuario; ?>)</div>
        
        <ul class="tab-menu">
            <li class="tab-item active" data-tab="tab1">Estudios</li>
            <li class="tab-item" data-tab="tab2">Cursos</li>
            <li class="tab-item" data-tab="tab3">Familia</li>
            <li class="tab-item" data-tab="tab4">X1</li>
            <li class="tab-item" data-tab="tab5">X2</li>
            <li class="tab-item" data-tab="tab6">X3</li>
            <li class="tab-item" data-tab="tab7">X4</li>
            <li class="tab-item" data-tab="tab8">X5</li>
        </ul>
        <div class="">
            <div id="tab1" class="tab-pane active">
                <div id="em"></div>
            </div>
            <div id="tab2" class="tab-pane">
                <div id="ec"></div>
            </div>
            <div id="tab3" class="tab-pane">
                <div id="ciber"></div>
            </div>
            <div id="tab4" class="tab-pane">
                <div id="comi"></div>
            </div>
            <div id="tab5" class="tab-pane">
                <div id="per"></div>
            </div>
            <div id="tab6" class="tab-pane">
                <div id="dh"></div>
            </div>
            <div id="tab7" class="tab-pane">
                <div id="ed"></div>
            </div>
            <div id="tab8" class="tab-pane">
                <div id="ot"></div>
            </div>
        </div>
    </div>
    <!--  insertar documento -->
    <div id="m_insert_documento" class="bgModal ocultar">
    <div class="modal m700">
        <div class="btn_img cancelar ri"><img src="<?php echo URL; ?>resource/images/iconos/cancelar.png"></div>
        <div onclick="$(document).ready(function() {document.formEvidencia.submit()});" class="btn_img le"><img id="img"></div>
        <div class='table-title' id="tituloModal"></div>
        <form method="post" action="" name="formEvidencia" id="formEvidencia" enctype="multipart/form-data">
            <table class="t_insert">
                <tr><th>Tipo de documento</th><th>Cargar documento</th></tr>
                <tr>
                    <td ><select id="tipoDocumento" name="tipoDocumento"></select></td>
                    <td ><input type="file" id="archivo" class="archivo" name="archivo"/></td>
                </tr>
                <tr><th colspan="2">Descripcion del documento</th></tr>
                <tr><td colspan="2"><input type="text" name="descripcion" id="descripcion"></td></tr>
                <input type="hidden" id="idUsuario" name="idUsuario"  value="<?php echo $idUsuario;?>">
                <input type="hidden" id="idDocumento" name="idDocumento">
                <input type="hidden" id="nombreArchivoDB" name="nombreArchivoDB">
                
            </table>
        </form>
    </div> 
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabItems = document.querySelectorAll('.tab-item');
            const tabPanes = document.querySelectorAll('.tab-pane');
            tabItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remover la clase 'active' de todos los ítems del menú y paneles
                    tabItems.forEach(i => i.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));

                    // Agregar la clase 'active' al ítem del menú clicado
                    this.classList.add('active');

                    // Obtener el ID de la pestaña a mostrar
                    const targetTabId = this.dataset.tab;
                    const targetTabPane = document.getElementById(targetTabId);

                    // Agregar la clase 'active' al panel de la pestaña correspondiente
                    if (targetTabPane) {
                        targetTabPane.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
