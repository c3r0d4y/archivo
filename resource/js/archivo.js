$(document).ready(function() {
   get_documentos(0);
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
       
        document.getElementById("buscarTipo").value="";
        document.getElementById("getNumeroDocumento").value="";
        document.getElementById("getAsuntoDocumento").value="";
        document.getElementById("getFechaDocumento").value="";
        //===========================================================
        
        document.getElementById("buscarTipo").disabled=false;
        document.getElementById("getNumeroDocumento").disabled=false;
        document.getElementById("getAsuntoDocumento").disabled=false;
        document.getElementById("getFechaDocumento").disabled=false;
        get_documentos("0");
    });
    $('#pendientes').click(function() {
         document.getElementById("getNumeroDocumento").value="";
         document.getElementById("getFechaDocumento").value="";
         document.getElementById("getAsuntoDocumento").value="";
         document.getElementById('getAsuntoDocumento').disabled=false;
         document.getElementById('getNumeroDocumento').disabled=false;
         get_documentos("1");
    });

});

 var get_documentos = (dato)=>{
    var editor = "";
    var buscarTipo = document.getElementById("buscarTipo").value;
    var getNumeroDocumento = document.getElementById("getNumeroDocumento").value;
    var getAsuntoDocumento = document.getElementById("getAsuntoDocumento").value;
    var getFechaDocumento = document.getElementById("getFechaDocumento").value;
    
    
    //Busqueda por tipo
    if(buscarTipo!=""){
        document.getElementById("getFechaDocumento").value="";
        //=========================================================
        document.getElementById("getFechaDocumento").disabled=true;
    }
    if(getNumeroDocumento!=""){
        document.getElementById("getAsuntoDocumento").value="";
        document.getElementById("getAsuntoDocumento").disabled=true;
    }
    if(getAsuntoDocumento!=""){
        document.getElementById("getNumeroDocumento").value="";
        document.getElementById("getNumeroDocumento").disabled=true;
        document.getElementById("getFechaDocumento").value="";
        document.getElementById("getFechaDocumento").disabled=true;
    }
    //Buscar por editor
    if(getFechaDocumento!=""){
        document.getElementById("buscarTipo").value="";
        document.getElementById("getNumeroDocumento").value="";
        document.getElementById("getAsuntoDocumento").value="";
        
        //===========================================================
        document.getElementById("buscarTipo").disabled=true;
        document.getElementById("getNumeroDocumento").disabled=true;
        document.getElementById("getAsuntoDocumento").disabled=true;
        
    }
    var pendientes = 0;
    
    if(pendientes == 1){
          
        document.getElementById("buscarTipo").value="";
        document.getElementById("getNumeroDocumento").value="";
        document.getElementById("getAsuntoDocumento").value="";
        document.getElementById("getFechaDocumento").value="";
    }
    var datos= {
         'numeroDocumento':getNumeroDocumento,
         'fechaDocumento':getFechaDocumento,
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
