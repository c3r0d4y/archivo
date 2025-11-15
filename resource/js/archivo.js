$(document).ready(function() {
   get_documentos(0);
   getEditor();
   getTipo();
   getTipoDocumento();
   getProcedenciaDocumento();
   
   $('#m_ver_pdf .cancelar').click(function() {
            $("#m_ver_pdf").addClass("ocultar");
            $("#m_menu_secundario").removeClass("ocultar");
        
    });
   $('.cancelar').click(function() {
        $("#m_insert").addClass("ocultar");//Mostramos el bg del registro
        $("#m_campo_vacio").addClass("ocultar");//Mostramos el bg del registro
        
    });
   $('#m_delete .cancelar').click(function() {
            $("#m_delete").addClass("ocultar");
    });
    $('#limpiar').click(function() {
        document.getElementById("tipoBusqueda").value="numero";
        document.getElementById("editor").value="";
        document.getElementById("buscarTipo").value="";
        document.getElementById("getNumeroDocumento").value="";
        document.getElementById("getAsuntoDocumento").value="";
        document.getElementById("getFechaDocumento").value="";


        $("#nombre").addClass("ocultar");
        $("#numero").removeClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#dia1").addClass("ocultar");
    
        get_documentos("0");
    });
    $('#pendientes').click(function() {
         document.getElementById("getNumeroDocumento").value="";
         document.getElementById("getFechaDocumento").value="";
         document.getElementById("getAsuntoDocumento").value="";
         get_documentos("pendientes");
    });

});

 var get_documentos = (dato)=>{
    var tipoBusqueda = document.getElementById("tipoBusqueda").value;
    
    if(tipoBusqueda=="numero"){
        $("#nombre").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#numero").removeClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#dia1").addClass("ocultar");
    }
    else if(tipoBusqueda=="usuario"){
        $("#nombre").removeClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#dia1").addClass("ocultar");
    }
    else if(tipoBusqueda=="tDocumento"){
        $("#nombre").addClass("ocultar");
        $("#numero").addClass("ocultar");
         $("#asunto").addClass("ocultar");
        $("#tDocumento").removeClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#dia1").addClass("ocultar");
    }
    else if(tipoBusqueda=="dia"){
        $("#nombre").addClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").removeClass("ocultar");
        $("#dia1").addClass("ocultar");
    }
    else if(tipoBusqueda=="asunto"){
        $("#nombre").addClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#dia1").addClass("ocultar");
        $("#asunto").removeClass("ocultar");
    }
    else if(tipoBusqueda=="tipoasunto"){
        $("#nombre").addClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#dia1").addClass("ocultar");
        $("#asunto").removeClass("ocultar");
        $("#tDocumento").removeClass("ocultar");
    }
    else if(tipoBusqueda=="tiponumero"){
        $("#nombre").addClass("ocultar");
        $("#numero").removeClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").addClass("ocultar");
        $("#dia1").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#tDocumento").removeClass("ocultar");
    }
    else if(tipoBusqueda=="periodo"){
        $("#nombre").addClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").removeClass("ocultar");
        $("#dia1").removeClass("ocultar");
    }
    else if(tipoBusqueda=="usuarioperiodo"){
        $("#nombre").removeClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#tDocumento").addClass("ocultar");
        $("#dia").removeClass("ocultar");
        $("#dia1").removeClass("ocultar");
    }
    else if(tipoBusqueda=="tipoperiodo"){
        $("#nombre").addClass("ocultar");
        $("#numero").addClass("ocultar");
        $("#asunto").addClass("ocultar");
        $("#tDocumento").removeClass("ocultar");
        $("#dia").removeClass("ocultar");
        $("#dia1").removeClass("ocultar");
    }

    var editor = document.getElementById("editor").value;
    var buscarTipo = document.getElementById("buscarTipo").value;
    var getNumeroDocumento = document.getElementById("getNumeroDocumento").value;
    var getAsuntoDocumento = document.getElementById("getAsuntoDocumento").value;
    var getFechaDocumento = document.getElementById("getFechaDocumento").value;
    var getFechaDocumento1 = document.getElementById("getFechaDocumento1").value;
    var pendientes = 0;
    
    if(pendientes == "pendientes"){
        document.getElementById("editor").value="";
        document.getElementById("buscarTipo").value="";
        document.getElementById("getNumeroDocumento").value="";
        document.getElementById("getAsuntoDocumento").value="";
        document.getElementById("getFechaDocumento").value="";
    }
    var datos= {
        'tipoBusqueda':tipoBusqueda,
        'numeroDocumento':getNumeroDocumento,
        'fechaDocumento':getFechaDocumento,
        'fechaDocumento1':getFechaDocumento1,
        'asuntoDocumento':getAsuntoDocumento,
        'editor':editor,
        'buscarTipo':buscarTipo,
        'pendientes':dato
    };
    $.ajax({
        type: "POST",
        url: "get_documentos",
        data:datos,
        success: function(response){$('#getDocumentos').html(response).fadeIn();}
    });
}
var visualizar = (datos)=>{
        var path="../resource/archivos/documentos/";
        if(datos[11]!=""){
             var scr=path+datos[11];
        }else{
            var scr="#";
        }
       
        document.getElementById('vista').src = scr;
        $("#m_ver_pdf").removeClass("ocultar");      
 }
 var insert_documento = () => {
      document.formInsert.action = "insertDocumento";
      $("#m_insert").removeClass("ocultar");//Mostramos el bg del registro

      //Blanqueamos los campos
        
      document.getElementById("numeroDocumento").value="";
      document.getElementById("numeroDocumentoTem").value="";

      document.getElementById("fechaDocumento").value="";
      document.getElementById("fechaTem").value="";

      document.getElementById("asuntoDocumento").value="";
      document.getElementById("acuerdoDocumento").value="";
      document.getElementById("expediente").value="";  
}
var getTipoDocumento = () => {
    $.ajax({
        type: "POST",
        url: "getTipoDocumento",
        success: function(response){
            $('#tipoDocumento').html(response).fadeIn();
            $('#sTipoDocumento').html(response).fadeIn();
        }
     });
}
var getEditor = () => {
    $.ajax({
        type: "POST",
        url: "getEditor",
        success: function(response){$('#editor').html(response).fadeIn();}
     });
}
var getTipo = () => {
    $.ajax({
        type: "POST",
        url: "getTipo",
        success: function(response){$('#buscarTipo').html(response).fadeIn();}
     });
}
var getProcedenciaDocumento = () => {
    $.ajax({
        type: "POST",
        url: "getProcedenciaDocumento",
        success: function(response){$('#procedenciaDocumento').html(response).fadeIn();
             }
     });
}
var delete_documento = (datos)=>{
        document.getElementById("idDelete").value=datos[0];
        document.getElementById("nombre_archivo").value=datos[11];
        document.getElementById("nombreDelete").value=datos[2];    
        document.formDelete.action = "delete_documento";
        $("#m_delete").removeClass("ocultar");//Mostramos el bg del registro
 }
 var update_documento = (datos)=>{      
       $("#m_insert").removeClass("ocultar");//Ocultar el campo file      
        document.getElementById("formulario").value="updateDocumento";
        document.formInsert.action = "updateDocumento";

        document.getElementById("idDocumento").value=datos[0];
        document.getElementById("tipoDocumento").value=datos[1];
        document.getElementById("procedenciaDocumento").value=datos[3];
       
        document.getElementById("numeroDocumento").value=decode(datos[2]);
        document.getElementById("numeroDocumentoTem").value=decode(datos[2]);

        document.getElementById("fechaDocumento").value=datos[5];
        document.getElementById("fechaTem").value=datos[5];

        document.getElementById("asuntoDocumento").value=decode(datos[6]);
        document.getElementById("acuerdoDocumento").value=decode(datos[8]);
        document.getElementById("expediente").value=decode(datos[7]);
        document.getElementById("esDocumento").value=datos[4];
        document.getElementById("nombreArchivoDB").value=datos[11];   
 }

 var guardar_documento = () => {
    nd=document.getElementById("numeroDocumento").value;
    ndT=document.getElementById("numeroDocumentoTem").value;

    fd=document.getElementById("fechaDocumento").value;
    fdt=document.getElementById("fechaTem").value;

    asd=document.getElementById("asuntoDocumento").value;
    ac=document.getElementById("acuerdoDocumento").value;
    ed=document.getElementById("expediente").value;

    if(nd=="" || fd=="" || asd=="" || ac=="" || ed==""){
        $("#m_campo_vacio").removeClass("ocultar");//Ocultar el campo file
    }else{
        document.formInsert.submit();
    }
}
var eliminar_documento = () => {
    document.formDelete.submit();
}
var asociar_documento = (datos) => {
    idDocumento=datos[0];
    numeroDocumento=datos[2];
    datos={'idDocumento':idDocumento, 'numeroDocumento':numeroDocumento};
    $.ajax({
            type: "POST",
            url: "asociar",
            data: datos,
            success: function(response)
            {                     
               url = "asociar";
               $(location).attr('href',url);
            }
    });
}
var validar_documento = (datos) => {
    idDocumento=datos[0];
    numeroDocumento=datos[2];
    //console.log("validando"+idDocumento+"==="+numeroDocumento);
    
    datos={'idDocumento':idDocumento, 'numeroDocumento':numeroDocumento};
    $.ajax({
            type: "POST",
            url: "validar_documento",
            data: datos,
            success: function(response)
            {                     
               url = "archivo";
               $(location).attr('href',url);
                //console.log(response);
            }
    });
}
var verC=()=>{document.getElementById("ver").innerHTML = "Ver documento"; $("#ver").removeClass("ocultar");}
var verAS=()=>{document.getElementById("ver").innerHTML = "Asociar documento"; $("#ver").removeClass("ocultar");}
var verE=()=>{document.getElementById("ver").innerHTML = "Editar"; $("#ver").removeClass("ocultar");}
var verEl=()=>{document.getElementById("ver").innerHTML = "Eliminar"; $("#ver").removeClass("ocultar");}
var verV=()=>{document.getElementById("ver").innerHTML = "Validar"; $("#ver").removeClass("ocultar");}
var ocultar=()=>{ $("#ver").addClass("ocultar");}
