$(document).ready(function() {
    get_id_evidencia();
    get_evidencias();

   $('.cancelar').click(function() {
        $("#m_insert_evidencia").addClass("ocultar");
        $("#m_ver_evidencia").addClass("ocultar");
    });
   $('.b_volver').click(function() {
        url = "detalleCaso";
        $(location).attr('href',url);    
            
   });
    
});
var get_id_evidencia = () => {
    $.ajax({
        type: "POST",
        url: "get_id_adjunto",
        success: function(response){$('#tipoEvidencia').html(response).fadeIn();}
     });
}
var insert_evidencia = ()=>{
    document.formEvidencia.action = "insert_adjunto";
    document.getElementById('img').src="../resource/images/iconos/guardar.png";
    document.getElementById("tituloModal").innerHTML = "¿Desea guardar este archivo adjunto?";
    document.getElementById("idEvidencia").value = "";
    document.getElementById("verEvidencia").innerHTML = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("path").value = "";
    $("#archivo").removeClass("ocultar");
    $("#m_insert_evidencia").removeClass("ocultar");
}
get_evidencias=()=>{
    var idCaso = document.getElementById("idCaso").value;
    datos = 'idCaso='+idCaso;
     $.ajax({
        type: "POST",
        url: "get_adjuntos",
        data: datos,
        success: function(response)
        {  
          $("#evidencias").html(response).fadeIn();
        }
    });
 }
 var delete_evidencia = (datos)=>{
    document.formEvidencia.action = "delete_adjunto";
    document.getElementById('img').src="../resource/images/iconos/eliminar.png";
    document.getElementById("tituloModal").innerHTML = "¿Desea eliminar esta evidencia?";

    $("#m_insert_evidencia").removeClass("ocultar");
    $("#verEvidencia").removeClass("ocultar");
    $("#archivo").addClass("ocultar");
    
    url="../resource/casos/"
    caso=document.getElementById("idCaso").value;
    url=url+caso+"/";
    nombre=datos[3];
    url=url+nombre;
    extension=nombre.substring(nombre.length-3, nombre.length);

    if(extension=="jpg" || extension=="png"){path="<img src="+url+">";}
    if(extension=="mp4"){path="<video src="+url+" controls></video>";}
    descripcion=datos[4];
     
    document.getElementById("tituloModal").innerHTML = "¿Desea eliminar esta evidencia?";
    
    document.getElementById("idEvidencia").value = datos[0];
    document.getElementById("verEvidencia").innerHTML = path;
    document.getElementById("descripcion").value = datos[3];
    document.getElementById("path").value = "resource/casos/"+caso+"/"+nombre;

}
var update_evidencia = (datos)=>{
    document.formEvidencia.action = "update_adjunto";
    document.getElementById('img').src="../resource/images/iconos/guardar.png";
    document.getElementById("tituloModal").innerHTML = "¿Desea guardar los cambios en este archivo?";

    $("#m_insert_evidencia").removeClass("ocultar");
    $("#verEvidencia").removeClass("ocultar");
    //$("#archivo").addClass("ocultar");

    url="../resource/casos/"
    caso=document.getElementById("idCaso").value;
    url=url+caso+"/";
    nombre=datos[3];
    url=url+nombre;
    extension=nombre.substring(nombre.length-3, nombre.length)

    if(extension=="jpg" || extension=="png"){path="<img src="+url+">";}
    if(extension=="mp4"){path="<video src="+url+" controls></video>";}
    descripcion=datos[4];
    
    document.getElementById("idEvidencia").value = datos[0];
    document.getElementById("verEvidencia").innerHTML = path;
    document.getElementById("descripcion").value = datos[4];
    document.getElementById("path").value = "resource/casos/"+caso+"/"+nombre;
}
var ver_evidencia = (datos)=>{
    $("#m_ver_evidencia").removeClass("ocultar");
    url="../resource/casos/"
    caso=document.getElementById("idCaso").value;
    url=url+caso+"/";
    nombre=datos[3];
    url=url+nombre;
    extension=nombre.substring(nombre.length-3, nombre.length)

    if(extension=="jpg" || extension=="png"){path="<img src="+url+">";}
    if(extension=="mp4"){path="<video src="+url+" controls></video>";}
    console.log(path);
    document.getElementById("verFoto").innerHTML = path;
    document.getElementById("path").value = "resource/casos/"+caso+"/"+nombre;
}