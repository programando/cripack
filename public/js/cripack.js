// JavaScript Document

//PROCESO DE LOGUE / INGRESO AL SISTEMA
//----------------------------------------

/*
btn-ingresar
*/


var Ingresar_Sistema = function( Parametros ) {


			$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/cripack/terceros/Ingreso_Sistema_Validaciones',
							type:     'post',
       success:  function (Respuesta){

       		 if ( Respuesta.Resultado_Logueo =='NO-Logueo_OK'){
       		 		alert(Respuesta.Email);
       		 }
       		 if ( Respuesta.Resultado_Logueo =='Logueo_OK'){
       		 			window.location.href = "/cripack/Index";
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



