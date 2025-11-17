$(document).ready(function() {
	var id_unidad=document.getElementById("id_unidad").value;
	console.log(id_unidad);
	var datos = 'id_unidad='+id_unidad;
	$.ajax({
        type: "POST",
        url: "get_secciones_a",
        data:datos,
        success: function(response){$('#secciones').html(response);}
     });
	$.ajax({
        type: "POST",
        url: "get_secciones_select",
        success: function(response)
            {
                $('#id_seccion').html(response).fadeIn();
            }
     });


	$('.b_cancelar').click(function() { 
         $("#m_eliminar").addClass("ocultar");
    });
    $('#m_asignacion .b_cancelar').click(function() { 
         $("#m_asignacion").addClass("ocultar");
    });




});
var deleteAsignacion = (datos)=>{
    $("#m_eliminar").removeClass("ocultar");//Quitamos la clase para mostrar
    document.deleteForm.action = "deleteAsignacion";//Asignamor url al formulario
    var id_eliminar = datos[0];
    document.getElementById("nombre_eliminar").innerHTML = datos[2];
    document.getElementById("id_eliminar").value = id_eliminar;
}
var insertAsignacion = (datos) =>{
    $("#m_asignacion").removeClass("ocultar");
    document.formA.action = "insertAsignacion";//Asignamor url al formulario
}
var enlaceSub = (datos)=>{
    console.log(datos[0]);
    document.formE.action = "enlace_sub";
    document.getElementById("id_sec").value = datos[0];
    document.formE.submit();
 }