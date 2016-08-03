$(document).ready(function(){

$(document).tooltip();


$( "#resultado_anterior" ).tooltip({
   content: "Resultado de la visita anterior.",
   track:true
});

//x=$("select[name=selectorZona]");
//x.change(mostrarPartido);

		//BUSQUEDA POR IDTERCERO
		$('#nomtercero').on('change', function(){
				Consulta_Datos_Cliente();
				return false;
		 });

//BUSQUEDA DE CLIENTE POR CÓDIGO
$('#codigo_tercero').on('blur',function(){
		$("#nomtercero").html('');
		Consulta_Datos_Cliente();
		return false;
});

$(".submit").click(function(event){
	 event.preventDefault();
 		var idtercero        = $(".idtercero").val();
			var fecha_visita     = $(".text-fecha_visita").val();
			var idmtvovisita     = $(".select-idmtvovisita").val();
			var resultados       = $.trim($(".text-resultado_hoy").val());
			var siguiente_paso   = $.trim($(".text-siguiente_paso_hoy").val());
			var tipo_visita      = $(".select-tipo_visita").val();
			var fecha_proxvisita = $(".text-fecha_proxvisita").val();
			var contacto         = $(".text-atendido_por").val();
			var parametros 					 =  {"idtercero"			: idtercero,   			"fecha_visita"					: fecha_visita, 	 				"idmtvovisita":idmtvovisita ,
		 																	 					 "resultados"		: resultados,					"siguiente_paso" 		: siguiente_paso,
		 																	 						"tipo_visita" : tipo_visita, 			"fecha_proxvisita" : fecha_proxvisita,			"contacto" 			: contacto
		 																							};

	 var Resultado_Validacion = 	Validar_Datos_Requeridos(parametros);
	 if (Resultado_Validacion === true)
	 {
	 		$.ajax({
								data:  parametros,
								dataType: 'json',
								url:      '/cripack/terceros/Terceros_Visitas_Grabar_Registro/',
								type:     'post',
	       success:  function (resultado) {
	       				 if (resultado.registro_grabado==0) {
	       				 		Mostrar_Mensaje_Error("Registro grabado con éxito.",180,280);
	       				 		window.location.href = "/cripack/terceros/visitas_nuevo";
	       				 }
	       }
					});


	 }


	 return false;
});




var Mostrar_Datos_Cliente = function(resultado){
		 $("#nommcipio").val(resultado.nommcipio );
		 $("#contacto").val(resultado.contacto );
		 $("#nomvendedor").val(resultado.nomvendedor );
		 $("#codigo_tercero").val(resultado.codigo_tercero);
		 $("#nomtercero").append('<option value="' + resultado.idtercero+ '">' + resultado.nomtercero + '</option>');
		 $("#siguiente_paso_anterior").val(resultado.siguiente_paso_anterior);
		 $(".text-resultado_anterior").val(resultado.resultado_anterior);
		 $(".idtercero").val(resultado.idtercero);
		 $("#siguiente_paso_anterior").focus();
	 	return false;
	}

var Mostrar_Mensaje_Error = function(texto, alto,ancho){
			$("#error").html(texto);
					    $( "#dialog-confirm" ).dialog({
					      resizable: false,
					      height:alto,
					      width :ancho,
					      modal: true,
					      buttons: {
					        "Cerrar": function() {
					          $( this ).dialog( "close" );
					        }
					      }
					    });
				return false;
	}

var Consulta_Datos_Cliente = function()	{
		var codigo_tercero = $.trim($('#codigo_tercero').val());
		var idtercero      = $('#nomtercero').val();

		if (idtercero==null){
			idtercero=0;
		}
	    var parametros = {"codigo_tercero" : codigo_tercero,"idtercero" : idtercero ,"tipo_retorno" : 'json' };
	    $.ajax({
								data:  parametros,
								dataType: 'json',
								url:      '/cripack/terceros/Terceros_Buscar_Datos_Por_Codigo_Id_Vendedor/',
								type:     'post',
	       success:  function (resultado) {
	       				 if (resultado.con_resultado>0) {
	       				 		Mostrar_Datos_Cliente(resultado);
	       				 }else{
	       				 		Mostrar_Mensaje_Error("Código de tercero no registrado en la base de datos o no se encuentra asociado al vendedor.",180,280);
	       				 }
	       }
					});

		return false;
	}

var Validar_Datos_Requeridos = function(parametros){
				var error												='';
				if (parametros.idtercero== -1 || parametros.idtercero==""){
						error = '* Debe seleccionar uno de los clientes.\n';
				}
			if (parametros.fecha_visita.length==0 ){
					 error = error + '* Debe registrar la fecha de la visita.\n';
			}
			if (parametros.idmtvovisita==0){
					error = error + '* Debe seleccionar el tipo de visita.\n';
			}
			if (parametros.idmtvovisita==0){
						error = error + '* Debe seleccionar el motivo de la visita.\n';
			}
		 if (parametros.resultados.length==0){
		 		error = error + '* No ha registrado el resultado de la visita.\n';
		 }
		  if (parametros.siguiente_paso.length==0){
		 		error = error + '* No ha registrado el siguiente paso, resultado de la visita.\n';
		 }
		 if (parametros.fecha_proxvisita.length==0){
		 	error = error + '* Debe registrar fecha de la próxima visita.\n';
		 }

		 error = $.trim(error);
		 error = error.replace(new RegExp("\n","g"), "<br>");// EXPRESION PARA RESPETAR LOS SALDOS DE LINEA \n
		 if (error.length>0)
		 {
		 		 Mostrar_Mensaje_Error(error,250,450);
		 			return false;
		 }else
		 {
		 	return true;
		 }

		 return false;
		}

});


