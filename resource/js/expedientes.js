$(document).ready(function() {
    get_id_tipo_documento();
    get_documentos();
   $('.cancelar').click(function() {
        $("#m_insert_documento").addClass("ocultar");
    });
   $('.b_volver').click(function() {
        url = "detalleCaso";
        $(location).attr('href',url);            
   });   
});
var get_id_tipo_documento = () => {
    $.ajax({
        type: "POST",
        url: "get_id_tipo_documento",
        success: function(response){$('#tipoDocumento').html(response).fadeIn();}
     });
}
var insert_documento = ()=>{
    document.formEvidencia.action = "insert_documento";
    document.getElementById('img').src="../resource/images/iconos/guardar.png";
    document.getElementById("tituloModal").innerHTML = "¿Desea guardar este documento?";
    document.getElementById("idDocumento").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("nombreArchivoDB").value = "";
    $("#archivo").removeClass("ocultar");
    $("#m_insert_documento").removeClass("ocultar");
}
get_documentos=()=>{
    var idUsuario = document.getElementById("idUsuario").value;
    datos = 'idUsuario'+idUsuario;
     $.ajax({
        type: "POST",
        url: "get_documentos",
        data: datos,
        success: function(response)
        {          
        	var divisiones = response.split("*");
            document.getElementById("docs1").innerHTML = divisiones[0];
            document.getElementById("docs2").innerHTML = divisiones[1];
            document.getElementById("docs3").innerHTML = divisiones[2];
            document.getElementById("docs4").innerHTML = divisiones[3];
            document.getElementById("docs5").innerHTML = divisiones[4];
            document.getElementById("docs6").innerHTML = divisiones[5];
            document.getElementById("docs7").innerHTML = divisiones[6];
            document.getElementById("docs8").innerHTML = divisiones[7];
    
        }
    });
 }
 var update_documento = (datos)=>{
    document.formEvidencia.action = "update_documento";
    document.getElementById('img').src="../resource/images/iconos/guardar.png";
    document.getElementById("tituloModal").innerHTML = "¿Desea guardar los cambios en este documento?";
    document.getElementById("archivo").value = "";
    $("#m_insert_documento").removeClass("ocultar"); 
    document.getElementById("idDocumento").value = datos[0];
    document.getElementById("descripcion").value = decode(datos[4]);
    document.getElementById("tipoDocumento").value = datos[1];
    document.getElementById("nombreArchivoDB").value = decode(datos[3]);
}
var delete_documento = (datos)=>{
    document.formEvidencia.action = "delete_documento";
    document.getElementById('img').src="../resource/images/iconos/eliminar.png";
    document.getElementById("tituloModal").innerHTML = "¿Desea eliminar este documento?";
    $("#m_insert_documento").removeClass("ocultar");
    $("#archivo").addClass("ocultar");
        
    document.getElementById("idDocumento").value = datos[0];
    document.getElementById("descripcion").value = datos[4];
    document.getElementById("nombreArchivoDB").value = datos[3];
    document.getElementById("tipoDocumento").value = datos[1];
}

