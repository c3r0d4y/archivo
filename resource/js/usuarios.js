$(document).ready(function() {
    get_roles();
    get_grados();
    get_especialidades();
    get_unidades();
    
    //Al presionar boton cancelar
    $('.cancelar').click(function() {
        $("#m_insert").addClass("ocultar");//Mostramos el bg del registro
        $("#m_insert1").addClass("ocultar");//Mostramos el bg del registro
        $("#m_roles").addClass("ocultar");
        $("#m_delete").addClass("ocultar");
        //Blanquemos los input
        document.getElementById("nombreUsuario").value = "";
  });
  
});

var get_roles = () => {
    console.log("g_r");
    $.ajax({
        type: "POST",
        url: "get_roles",
        success: function(response){$('#roles').html(response).fadeIn();$('#rolesa').html(response).fadeIn();
             }
     });
}
var get_grados = () => {
    console.log("g_r");
    $.ajax({
        type: "POST",
        url: "get_grados",
        success: function(response){$('#grados').html(response).fadeIn();$('#gradosa').html(response).fadeIn();
             }
     });
}
var get_especialidades = () => {
    console.log("g_r");
    $.ajax({
        type: "POST",
        url: "get_especialidades",
        success: function(response){$('#especialidades').html(response).fadeIn();$('#especialidadesa').html(response).fadeIn();
             }
     });
}
var get_unidades = () => {
    $.ajax({
        type: "POST",
        url: "get_unidades",
        success: function(response){$('#unidades').html(response).fadeIn();$('#unidadesa').html(response).fadeIn();
             }
     });
}
 //Buscar usuarios
 var get_usuarios = ()=>{
    var getUsuario = document.getElementById("getUsuario").value;
    //console.log("g_u="+getUsuario);
    var dataString = 'getUsuario='+getUsuario;
    $.ajax({
        type: "POST",
        url: "get_usuarios",
        data: dataString,
        success: function(response)
            {
               $('#getUsuarios').html(response);
              
               if(response.length== 0){
                   $("#c_busqueda").addClass("ocultar");
               }else{
                    $("#c_busqueda").removeClass("ocultar");
               }
             }
     });
}
var insert_usuario = () => {

    document.formInsert.action = "insert_usuario";
    $("#m_insert").removeClass("ocultar");//Mostramos el bg del registro
    document.getElementById("usuario").value = ""; //blanqueamos los campos
    document.getElementById("password").value = "";//blanqueamos los campos
    document.getElementById("roles").disabled = false;
    document.getElementById("archivo_t").innerHTML = 
    ['<img src="', "../resource/images/fotos_usuarios/default.png", '" title = "', 'default.png', '" class="archivo_t"/>']
    .join('');
    document.getElementById("nombreUsuario").value = "";
}

var validar_password = () => {
    nombreUsuario=document.getElementById("nombreUsuario").value;
    matricula=document.getElementById("matricula").value;
    usuario=document.getElementById("usuario").value;
    password=document.getElementById("password").value;
    console.log(password);
    if (password.length > 15 &&  password.match(/[A-z]/) &&password.match(/[A-Z]/) && password.match(/\d/) || password=='****************') {
        $('#guardar').removeClass('ocultar');
    }else{
        $('#guardar').addClass('ocultar');
    }
}
//datos para actualizar usuarios
var update_usuario = (datos)=>{
    console.log("1");
    getUsuario = document.getElementById("getUsuario").value;
    document.formInsert.action = "update_usuario";
    $("#m_insert").removeClass("ocultar");//Mostramos el bg del registro
    $("#getUsuario").val("");//Vaciamos el input de busqueda
    //console.log(datos);
    console.log("2");
    document.getElementById("archivo_t").innerHTML = 
    ['<img src="', "../resource/images/fotos_usuarios/" + datos[5], '" title = "', escape(datos[5]), '" class="archivo_t"/>']
    .join('');
    console.log("3");
    document.getElementById("idUsuario").value = decode(datos[0]);
    console.log("4");
    document.getElementById("grados").value = decode(datos[1]);
    console.log("5");
    document.getElementById("especialidades").value = decode(datos[2]);
    console.log("6");
    document.getElementById("matricula").value = decode(datos[3]);
    document.getElementById("nombreUsuario").value = decode(datos[4]);
    document.getElementById("nombreArchivoDB").value = decode(datos[5]);
    document.getElementById("unidades").value = decode(datos[7]);
    console.log("4");
    document.getElementById("estado").value = decode(datos[11]);
    console.log("5");
    document.getElementById("roles").disabled = true;
    document.getElementById("usuario").value = "****";
    document.getElementById("password").value = "****************";
}
var updated = () => {document.formInsert.submit();}

var delete_usuario = (datos)=>{
    document.formDelete.action = "delete_usuario";//Asignamor url al formulario
    var idDelete = datos[0];
    var imagenDelete = datos[5];
    $("#m_delete").removeClass("ocultar");
    document.getElementById("nombreEliminar").value = datos[4];
    document.getElementById("idEliminar").value = idDelete;
    document.getElementById("archivoEliminar").value = imagenDelete;
}
var deleted = () => {document.formDelete.submit();}

var update_rol = (datos) =>{
    
    $("#m_insert1").removeClass("ocultar");//Ocultamos el modal de roles
    document.getElementById("nURonl").innerHTML = datos[4];
    document.getElementById("idU").value = datos[0];
    idUsuario=datos[0];
    var dataString = 'idUsuario='+idUsuario;
    $.ajax({
        type: "POST",
        url: "get_rol",
        data: dataString,
        success: function(response)
            {
               $('#bRolesU').html(response);
               $("#m_roles").removeClass("ocultar");
                
             }
     });
}
var delete_rol = (datos)=>{
    
    $("#m_delete").removeClass("ocultar");//Quitamos la clase para mostrar
    $("#m_insert1").addClass("ocultar");//Ocultamos el modal de roles
    document.formDelete.action = "delete_rol";//Asignamor url al formulario
    document.getElementById("nombreEliminar").value = datos[1];
    document.getElementById("idEliminar").value = datos[0];
    console.log(datos[0]);
}
var valida = () => {
    valor = document.getElementById("rolesa").value;
    //$("#modalRoles").addClass("ocultar");//Ocultamos el modal de roles
    if(valor!=""){
        document.formInsert1.action = "insert_rol";//Asignamor url al formulario

    }else{ 
        alert("Debe elegir un rol");
    }
}

var expediente = (datos) => {
    console.log("expediente1");
    idUsuario=datos;
    datos={'idUsuario':idUsuario};
    $.ajax({
            type: "POST",
            url: "expedientes",
            data: datos,
            success: function(response)
            {  
               url = "expedientes";
               $(location).attr('href',url);
            }
    });
}



var verEx=()=>{document.getElementById("ver").innerHTML = "Expediente"; $("#ver").removeClass("ocultar");}
var verE=()=>{document.getElementById("ver").innerHTML = "Editar"; $("#ver").removeClass("ocultar");}
var verR=()=>{document.getElementById("ver").innerHTML = "Roles"; $("#ver").removeClass("ocultar");}
var verEl=()=>{document.getElementById("ver").innerHTML = "Eliminar"; $("#ver").removeClass("ocultar");}
var ocultar=()=>{ $("#ver").addClass("ocultar");}