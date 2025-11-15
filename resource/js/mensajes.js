$(document).ready(function() {

    get_mensajes();
   
           
    var intervalo = setInterval(function(){get_mensajes();},1000);
    
    $('#m_mensaje .b_cancelar').click(function() {
       $("#m_mensaje").addClass("ocultar");
           
    });
  
});
var get_mensajes = ()=>{
    console.log("mensajes");
     $.ajax({
    type: "POST",
    url: "get_mensajes",
    success: function(response)
        {$('#c_mensajes').html(response).fadeIn();}
    });
}

var insertMensaje = ()=>{
    document.getElementById("formulario").value = "insertMensaje";
    $("#m_mensaje").removeClass("ocultar");//Quitamos la clase para mostrar
    document.formMensajes.action = "insert_mensaje";
    document.getElementById("asunto").value = "";
    document.getElementById("mensaje").value = "";
}
var updateVictima = (datos) =>{
    $("#guardar").removeClass("ocultar");//Quitamos la clase para mostrar
    
    document.formObjetivo.action = "update_objetivo";
    $("#m_objetivo").removeClass("ocultar");
    document.getElementById("correo_objetivo").value = datos[1];
    document.getElementById("envios").value = datos[4];
    document.getElementById("id_objetivo").value = datos[0];
    
  }
  var updateAtacante = (datos) =>{
    document.formAtacante.action = "update_atacante";
    $("#m_atacante").removeClass("ocultar");
    document.getElementById("correo_atacante").value = datos[1];
    document.getElementById("password").value = datos[2];
    document.getElementById("id_atacante").value = datos[0];
  }
  var updateMensaje = (datos) =>{
    document.formMensajes.action = "update_mensaje";
    $("#m_mensaje").removeClass("ocultar");
    document.getElementById("asunto").value = datos[1];
    document.getElementById("mensaje").value = datos[2];
    document.getElementById("id_mensaje").value = datos[0];
  }
 var deleteAtacante = (datos) =>{
    document.formDelete.action = "delete_atacante";//Asignamor url al formulario
    $("#m_eliminar").removeClass("ocultar");
    document.getElementById("id_eliminar").value = datos[0];
    document.getElementById("nombre_eliminar").innerHTML = datos[1];
 }
 var deleteMensaje = (datos) =>{
    document.formDelete.action = "delete_mensaje";//Asignamor url al formulario
    $("#m_eliminar").removeClass("ocultar");
    document.getElementById("id_eliminar").value = datos[0];
    document.getElementById("nombre_eliminar").innerHTML = datos[1];
 }