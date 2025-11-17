$(document).ready(function() {
   get_documentos(0);
   getTipoDocumento();
   getProcedenciaDocumento();
   
   $('#m_ver_pdf .b_cancelar').click(function() {
            $("#m_ver_pdf").addClass("ocultar");
            $("#m_menu_secundario").removeClass("ocultar");
        
    });
   $('.b_cancelar').click(function() {
        $("#m_registro_documento").addClass("ocultar");//Mostramos el bg del registro
        $("#m_campo_vacio").addClass("ocultar");//Mostramos el bg del registro
        
    });
   $('#m_eliminar .b_cancelar').click(function() {
            $("#m_eliminar").addClass("ocultar");
    });
    $('#limpiar').click(function() {
         document.getElementById("getNumeroDocumento").value="";
         document.getElementById("getAsuntoDocumento").value="";
         document.getElementById('getAsuntoDocumento').disabled=false;
         document.getElementById('getNumeroDocumento').disabled=false;
         get_documentos(0);

    });
      
});
var get_documentos = (dato)=>{
	var idActivo = document.getElementById("idActivo").value;
    var getNumeroDocumento = document.getElementById("getNumeroDocumento").value;
    var getAsuntoDocumento = document.getElementById("getAsuntoDocumento").value;
    var pendientes = 0;
    
    document.getElementById('getAsuntoDocumento').disabled=false;
    document.getElementById('getNumeroDocumento').disabled=false;
   
    if(getNumeroDocumento != ""){
      document.getElementById('getAsuntoDocumento').disabled=true;
    }
    if(getAsuntoDocumento != ""){
      document.getElementById('getNumeroDocumento').disabled=true;
    }
    var datos= {
         'numeroDocumento':getNumeroDocumento,
         'asuntoDocumento':getAsuntoDocumento,
         'idActivo':idActivo
      };
    $.ajax({
        type: "POST",
        url: "get_documentos",
        data:datos,
        success: function(response){$('#getDocumentos').html(response).fadeIn();}
    });

}
var visualizar = (datos)=>{
        console.log(datos[11]);

        var path="../resource/archivos/documentos/";
        if(datos[11]!=""){
             var scr=path+datos[11];
        }else{
            var scr="#";
        }
       
        console.log(scr);
        document.getElementById('vista').src = scr;
        $("#m_ver_pdf").removeClass("ocultar");
        
 }
 var getTipoDocumento = () => {
    console.log("tipoDocumento");
    $.ajax({
        type: "POST",
        url: "getTipoDocumento",
        success: function(response){$('#tipoDocumento').html(response).fadeIn();$('#sTipoDocumento').html(response).fadeIn();}
     });
}
var getProcedenciaDocumento = () => {
    console.log("procedenciaDocumento");
    $.ajax({
        type: "POST",
        url: "getProcedenciaDocumento",
        success: function(response){$('#procedenciaDocumento').html(response).fadeIn();
             }
     });
}
var delete_documento_asociado = (datos)=>{
      document.getElementById("idEliminar").value=datos;
      $("#m_eliminar").removeClass("ocultar");//Mostramos el bg del registro
 }
 var eliminar = () => {
    document.formDelete.submit();
}