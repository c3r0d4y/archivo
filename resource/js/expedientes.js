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
            document.getElementById("em").innerHTML = divisiones[0];
            document.getElementById("ec").innerHTML = divisiones[1];
            document.getElementById("ciber").innerHTML = divisiones[2];
            document.getElementById("comi").innerHTML = divisiones[3];
            document.getElementById("per").innerHTML = divisiones[4];
            document.getElementById("dh").innerHTML = divisiones[5];
            document.getElementById("ot").innerHTML = divisiones[6];
            document.getElementById("ed").innerHTML = divisiones[7];
    
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

