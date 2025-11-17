$(document).ready(function() {
    $.ajax({
        type: "POST",
        url: "getRoles",
        success: function(response)
            {
                $('#bRoles').html(response);
            }
     });
     $.ajax({
        type: "POST",
        url: "selectRoles",
        success: function(response)
            {
                $('#tipoRol').html(response).fadeIn();
                $('#tipoRolU').html(response).fadeIn();
             }
     });
     $('.cancelar').click(function() {
        $("#m_delete").addClass("ocultar");
        $("#m_insert").addClass("ocultar");
    });
    
});
var insert_rol = ()=>{
    console.log("insert");
    $("#m_insert").removeClass("ocultar");
    document.formInsert.action = "insertRol";
    document.getElementById("nombreRolU").value = "";
    document.getElementById("idRolU").value = "";
}
var delete_rol = (datos)=>{
    document.formDelete.action = "delete_rol";//Asignamor url al formulario
    var idDelete = datos[0];
    document.getElementById("nombreDelete").innerHTML = datos[1];
    document.getElementById("idDelete").value = idDelete;
    $("#m_delete").removeClass("ocultar");//Quitamos la clase para mostrar
}
var update_rol = (datos) =>{
    console.log("update");
    document.formInsert.action = "updateRol";//Asignamor url al formulario
    document.getElementById("nombreRolU").value = datos[1];
    document.getElementById("idRolU").value = datos[0];
    document.getElementById("tipoRolU").value = datos[2];
    $("#m_insert").removeClass("ocultar");
}

var updated = () => {document.formInsert.submit();}
var deleted = () => {document.formDelete.submit();}
var verE=()=>{document.getElementById("ver").innerHTML = "Editar"; $("#ver").removeClass("ocultar");}
var verEl=()=>{document.getElementById("ver").innerHTML = "Eliminar"; $("#ver").removeClass("ocultar");}
var ocultar=()=>{ $("#ver").addClass("ocultar");}