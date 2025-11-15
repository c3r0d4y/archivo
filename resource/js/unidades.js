$(document).ready(function() {
    get_unidades();

     $('.cancelar').click(function() { 
         $("#m_insert").addClass("ocultar");
         $("#m_delete").addClass("ocultar");
        
    });
        
});
var get_unidades = () =>{
    $.ajax({
        type: "POST",
        url: "get_unidades",
        success: function(response){$('#bUnidades').html(response);}
     });
 }
 var insert_unidad = () =>{
    $("#m_insert").removeClass("ocultar");
    document.formInsert.action = "insert_unidad";//Asignamor url al formulario
    document.getElementById("idUnidadU").value = "";
    document.getElementById("nombreUnidadU").value = "";
    document.getElementById("claveUnidadU").value = "";
 }
var update_unidad = (datos) =>{
    $("#m_insert").removeClass("ocultar");
    document.formInsert.action = "update_unidad";//Asignamor url al formulario
    document.getElementById("idUnidadU").value = datos[0];
    document.getElementById("nombreUnidadU").value = decode(datos[1]);
    document.getElementById("claveUnidadU").value = decode(datos[2]);
 }
var delete_unidad = (datos)=>{
    $("#m_delete").removeClass("ocultar");//Quitamos la clase para mostrar
    document.formDelete.action = "delete_unidad";//Asignamor url al formulario
    var idDelete = datos[0];
    document.getElementById("nombreDelete").innerHTML = datos[1];
    document.getElementById("idDelete").value = idDelete;
        
}

var enlace_unidad = (datos)=>{
    console.log(datos[0]);
    document.formE.action = "enlace_unidad";
    document.getElementById("id_unidad").value = datos[0];
    document.formE.submit();
 }
 var secciones = (datos)=>{
    url = "secciones";
    $(location).attr('href',url);   
}
var deleted = () => {
    document.formDelete.submit();
}
var guardar_unidad = () => {
    document.formInsert.submit();
}
var verE=()=>{document.getElementById("ver").innerHTML = "Editar"; $("#ver").removeClass("ocultar");}
var verEl=()=>{document.getElementById("ver").innerHTML = "Eliminar"; $("#ver").removeClass("ocultar");}
var ocultar=()=>{ $("#ver").addClass("ocultar");}


 