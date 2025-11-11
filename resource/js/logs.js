
$(document).ready(function() {
	//var intervalo = setInterval(function(){get_logs ('', '');},1000);
	get_logs();
	$('#limpiar').click(function() {
        var usuario = document.getElementById("usuario").value="";
		var documento = document.getElementById("documento").value="";
		var fecha = document.getElementById("fecha").value="";
		get_logs();
    });

});

var get_logs = ()=>{
	var usuario = document.getElementById("usuario").value;
	var documento = document.getElementById("documento").value;
	var fecha = document.getElementById("fecha").value;

	console.log(usuario+"=="+documento+"=="+fecha);

	var datos= {'usuario':usuario, 'documento':documento, 'fecha':fecha};

		$.ajax({
	        type: "POST",
	        url: "get_logs",
	        data: datos,
	        success: function(response)
	        {
	        	console.log("sale de logs");
	       		$('#logs').html(response).fadeIn();
	       	}
		})
}