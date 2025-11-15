$(document).ready(function() {
   
    //al presionar boton nuevo
    $('#registro').click(function() {
        document.registroForm.action = "registroUsuario";
        $("#modalRegistro").toggleClass("ocultar");//Mostramos el bg del registro
        $("#registroForm").toggleClass("ocultar");//Mostramos el formulario de registro

        $("#c_busqueda").addClass("ocultar");//Ocultamos la tabla de busqueda
        //$("#buscarUsuarios").val("");//Vaciamos el input de busqueda
        $("#tablaR").toggleClass("ocultar");//Ocultamos boton nuevo
        $("#cerrar").toggleClass("ocultar");//mostramos boton cerrar
        document.getElementById("usuario").value = ""; //blanqueamos los campos
        document.getElementById("password").value = "";//blanqueamos los campos
        document.getElementById("roles").disabled = false;
        document.getElementById("imagen_t").innerHTML = 
        ['<img src="', "../resource/images/fotos/default.png", '" title = "', 'default.png', '" class="imagen_t"/>']
        .join('');
    });
    //Al presionar boton cerrar
    $('.cancelar').click(function() {
        $("#modalRegistro").toggleClass("ocultar");//Mostramos el bg del registro
        $("#registroForm").toggleClass("ocultar");//Ocultamos el formulario de registro
        $("#tablaR").toggleClass("ocultar");//Mostramos boton nuevo
        //$(".cancelar").toggleClass("ocultar");//ocultamos boton cerrar
        $("#c_busqueda").removeClass("ocultar");//Ocultamos la tabla de busqueda
        //Blanquemos los input
        document.getElementById("usuario").value = "";
        
    });

    //selec Rol
    $.ajax({
        type: "POST",
        url: "getRoles",
        success: function(response)
            {
                $('#roles').html(response).fadeIn();
                $('#rolesa').html(response).fadeIn();
             }
     });
     
    $('.cancelar').click(function() {
        $("#m_insert").addClass("ocultar");
        $("#m_insert1").addClass("ocultar");

    });
     //Cargamos la informacion del usuario
     var dataString = "";
    $.ajax({
        type: "POST",
        url: "buscarUsuarios",
        data: dataString,
        success: function(ask)
            {
                separador = "/";
                datos = ask.split(separador);
                               
                idUsuario = datos[0];
                matricula= datos[3];
                nombreUsuario= datos[4];
                nombreArchivoDB = datos[5];
                imagen = datos[5];
                                
                document.getElementById("idUsuario").value = idUsuario;
                document.getElementById("matricula").value = decode(matricula);
                document.getElementById("nombreUsuario").value = decode(nombreUsuario);
                document.getElementById("nombreArchivoDB").value = nombreArchivoDB;
                document.getElementById("archivo_t").innerHTML = 
    ['<img src="', "../resource/images/fotos_usuarios/" + imagen, '" title = "', escape(imagen), '" class="archivo_t"/>']
    .join('');
             }
    });
});
var validar_password = () => {
    password=document.getElementById("passwordN").value;
    if(password==""){
        $('#guardar').removeClass('ocultar');
    }else{
        if (password.length > 15 &&  password.match(/[A-z]/) &&password.match(/[A-Z]/) && password.match(/\d/)) {
            $('#guardar').removeClass('ocultar');
        }else{
            $('#guardar').addClass('ocultar');
        }
    }
}
var update_usuario = (datos)=>{
    document.formPerfil.submit()
}
var muestraModalPin = ()=>{
     $("#m_insert1").removeClass("ocultar");
}
var updatePin = ()=>{
   var pin = document.getElementById("pin").value;
    var pinV = document.getElementById("pinV").value;

    if(pin==pinV){
        document.formPin.action = "updatePin";
    }else{
        alert("¡La verificacion no fue correcta!");
    }
    document.formPin.submit();
}
var muestraModalPass = ()=>{
      $("#m_insert").removeClass("ocultar");
}

var guardar_password = () => {
    document.formPassword.submit();
}


