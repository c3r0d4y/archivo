
$(document).ready(function() {
	//var intervalo = setInterval(function(){get_logs ('', '');},1000);
	get_logs();
	$('#limpiar').click(function() {
		document.getElementById("tipoBusqueda").value="pornumero";
        document.getElementById("usuario").value="";
		document.getElementById("documento").value="";
		document.getElementById("fechaInicio").value="";
		document.getElementById("fechaFin").value="";

		$("#documento").removeClass("ocultar");
		$("#usuario").addClass("ocultar");
		$("#fechaInicio").addClass("ocultar");
		$("#fechaFin").addClass("ocultar");
		get_logs();
    });
});

var get_logs = ()=>{
	var tipoBusqueda = document.getElementById("tipoBusqueda").value;

	if(tipoBusqueda=="pornumero"){
		$("#usuario").addClass("ocultar");
		$("#fechaInicio").addClass("ocultar");
		$("#fechaFin").addClass("ocultar");
		$("#documento").removeClass("ocultar");
	}
	else if(tipoBusqueda=="pornombre"){
		$("#documento").addClass("ocultar");
		$("#fechaInicio").addClass("ocultar");
		$("#fechaFin").addClass("ocultar");
		$("#usuario").removeClass("ocultar");
	}
	else if(tipoBusqueda=="porperiodo"){
		$("#documento").addClass("ocultar");
		$("#usuario").addClass("ocultar");
		$("#fechaInicio").removeClass("ocultar");
		$("#fechaFin").removeClass("ocultar");
	}
	else if(tipoBusqueda=="pornombreyperiodo"){
		$("#documento").addClass("ocultar");
		$("#usuario").removeClass("ocultar");
		$("#fechaInicio").removeClass("ocultar");
		$("#fechaFin").removeClass("ocultar");
	}

	var usuario = document.getElementById("usuario").value;
	var documento = document.getElementById("documento").value;
	var fechaInicio = document.getElementById("fechaInicio").value;
	var fechaFin = document.getElementById("fechaFin").value;

	//console.log(tipoBusqueda+"=|="+usuario+"=|="+documento+"=|="+fechaInicio+"=|="+fechaFin);
	var datos= {'tipoBusqueda':tipoBusqueda,'usuario':usuario, 'documento':documento, 'fechaInicio':fechaInicio, 'fechaFin':fechaFin};
		$.ajax({
	        type: "POST",
	        url: "get_logs",
	        data: datos,
	        success: function(response)
	        {
	        	//console.log(response);
	       		$('#logs').html(response).fadeIn();
	       	}
		})
		
}