// JavaScript Document

//PROCESO DE LOGUE / INGRESO AL SISTEMA
//----------------------------------------

/*
btn-ingresar
*/

$('#tabla-historial-ots').DataTable( {
     "language": {
 				"sProcessing":    "Procesando...",
     "sLengthMenu":     "Mostrar _MENU_ registros",
     "sZeroRecords":    "No se encontraron resultados",
     "sEmptyTable":     "Ningún dato disponible en esta tabla",
     "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
     "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
     "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
     "sInfoPostFix":    "",
     "sSearch":         "Buscar:",
     "sUrl":            "",
     "sInfoThousands":  ",",
     "sLoadingRecords": "Cargando...",
     "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
 					},
	    "oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    			}
				}
});


var Ingresar_Sistema = function( Parametros ) {
			$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/cripack/terceros/Ingreso_Sistema_Validaciones',
							type:     'post',
       success:  function (Respuesta){

       		 if ( Respuesta.Resultado_Logueo =='NO-Logueo_OK'){
       		 		$(".modal-body #contenido").val( "EEOEOEO" );
       		 		 $('#modal_error').modal('show');
       		 }
       		 if ( Respuesta.Resultado_Logueo =='Logueo_OK'){
       		 			window.location.href = "/cripack/Terceros/Historial/";
       		 }
      	 	 }


				});
}



$("#btn-ingresar").on('click', function() {
		var $email 		 = $("#email").val();
		var $password = $("#password").val();
		$Parametros 	 = {'email':$email,'Password':$password  } ;
		Ingresar_Sistema ( $Parametros)
});



var Ion = {

	init : function()
	{
		//console.log("RUN ION");

		$(document).ready(function() {

			var alto = $(window).height();
			var ancho = $(window).width();

			$(".closeModalion").on('click', function() {
				$('.modal').modal('hide');
		  	});


			$(".bIngreso").on('click', function() {
				$('.botonoes').slideUp(300);
				$('.dIngreso').slideDown(300);
				$('.dRegistro').slideUp(300);
		  	});
			$(".bRegistro").on('click', function() {
				$('.botonoes').slideUp(300);
				$('.dRegistro').slideDown(300);
				$('.dIngreso').slideUp(300);
		  	});

			$(window).resize(function() {
				var alto = $(window).height();
				var ancho = $(window).width();
				setTimeout('Ion.calcularAlturas()', 10);
				setTimeout('Ion.calcularAlturas()', 1000);
			});

		});

		Ion.calcularAlturas();
		setTimeout('Ion.calcularAlturas()', 100);
		setTimeout('Ion.calcularAlturas()', 1000);

	},

	calcularAlturas : function(){
		var alto = $(window).height();
		var ancho = $(window).width();

		$(".allion").height(alto);
		$(".allionIn").height(alto-200);

	},

};

Ion.init();



