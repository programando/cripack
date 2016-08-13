// JavaScript Document

//=========================================================================================================
/// PROCESO DE INGRESO AL SISTEMA			btn-ingresar
//=========================================================================================================

var $RespuestaAjax='';
var $Titulo           = '¡ ERROR EN REGISTRO !';

var Ingresar_Sistema = function( Parametros ) {

			$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/cripack/terceros/Ingreso_Sistema_Validaciones',
							type:     'post',
       success:  function ( Respuesta ){
       		 if ( Respuesta.Resultado_Logueo =='NO-Logueo_OK'){
       		 		//$('.modal-body #contenido').html('Modificar país: ');
       		 		 $('#modal_error').modal('show');
       		 }
       		 if ( Respuesta.Resultado_Logueo =='Logueo_OK'){
       		 			window.location.href = "/cripack/terceros/Historial";
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


var Mostrar_Mensajes = function( $Titulo, $Contenido ){
	    $('.modal-header #contenido').html($Titulo);
     $('.modal-body #contenido').html($Contenido);
     $('#modal_error').modal('show');
}
//=========================================================================================================
/// FIN PROCESO DE INGRESO			btn-ingresar
//=========================================================================================================



//=========================================================================================================
/// REGISTRO DE INFORMACIÓN 		btn-registrarse
//=========================================================================================================
var Valida_Exista_Identificacion = function( Parametros ) {
//1.		Valida que el Nit Exista dentro de nuestra base de datos.
				$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/cripack/terceros/Buscar_Por_Identificacion',
							type:     'post',
							async:    false,
       success:  function ( Respuesta ){
       	if (Respuesta.Respuesta=='IdentificacionExiste'){
       			$('#nomtercero').val(Respuesta.nomtercero);
       		$RespuestaAjax = 'ok'
       	}else{
       		$RespuestaAjax = 'No-Ok';
       	}
       }
				});
};

var Valida_Exista_Email = function( Parametros ) {
//2.		Valida que el email exista dentro de cripak y que no esté registrado
				$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/cripack/terceros/Consultar_Emails',
							type:     'post',
							async:    false,
       success:  function ( Respuesta ){

       	if (Respuesta.Respuesta=='Email-Ok'){
       		$RespuestaAjax = 'ok'
       	}else{
       		$RespuestaAjax = 'No-Ok';
       	}
       }
				});
};

var Registro_Grabar = function( Parametros ) {
//2.		Valida que el email exista dentro de cripak y que no esté registrado
				$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/cripack/terceros/Grabar_Registro',
							type:     'post',
       success:  function ( Respuesta ){
       	if (Respuesta.Respuesta=='RegistroGrabado'){
       	 		window.location.href = "/cripack/index/";
       	}
       }
				});
};

$('#email-registro').on('blur',function(){
		var $email 		 = $("#email-registro").val();
		$Parametros 	 						   = {'email':$email } ;
		Valida_Exista_Email ( $Parametros);
		if ( $RespuestaAjax == 'No-Ok'){
				Mostrar_Mensajes( $Titulo, 'El correo electrónico que ha digitado no existe o ya se encuentra registrado dentro de nuestra base de datos.');
			}
});

$('#identificacion').on('blur',function(){
		var $identificacion 		 = $("#identificacion").val();
		$Parametros 	 						   = {'identificacion':$identificacion } ;
		Valida_Exista_Identificacion ( $Parametros);
		if ( $RespuestaAjax == 'No-Ok'){
			Mostrar_Mensajes( $Titulo, 'La identificación no se encuentra registrada en Cripack S.A.S.');
		}
});

$("#btn-registrarse").on('click', function() {
				var $identificacion   = $("#identificacion").val();
				var $email            = $("#email-registro").val();
				var $password         = $("#password-registro").val();
				var $passwordconfirma = $("#password-confirma").val();

				$Parametros 	 						   = {'identificacion':$identificacion } ;
				Valida_Exista_Identificacion ( $Parametros);
				if ( $RespuestaAjax == 'No-Ok'){
						Mostrar_Mensajes( $Titulo, 'La identificación no se encuentra registrada en Cripack S.A.S.');
						return ;
				}

				$Parametros 	 						   = { 'email':$email } ;
				Valida_Exista_Email ( $Parametros);

				if ( $RespuestaAjax == 'No-Ok'){
						Mostrar_Mensajes( $Titulo, 'El correo electrónico que ha digitado no existe o ya se encuentra registrado dentro de nuestra base de datos.');
						return ;
				}

				if ( $password != $passwordconfirma ){
						Mostrar_Mensajes( $Titulo, 'La contraseña y su confirmación debe ser iguales.');
						return ;
				}
				$Parametros 	 						   = {'email':$email,'password':$password } ;
				Registro_Grabar ($Parametros  )

});
//=========================================================================================================
/// FIN REGISTRO DE INFORMACIÓN 		btn-registrarse
//=========================================================================================================






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
		$(".allionIn").height(alto-164);


	},

};

Ion.init();



