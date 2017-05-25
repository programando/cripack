// JavaScript Document



var $RespuestaAjax        ='';
var $Titulo               = '¡ ERROR EN REGISTRO !';
var $Respuesta_Validacion ='';


var Mostrar_Mensajes = function( $Titulo, $Contenido ){
     $('.modal-header #contenido').html($Titulo);
     $('.modal-body #contenido').html($Contenido);
     $('#modal_error').modal('show');
}


//=========================================================================================================
/// PROCESO DE INGRESO AL SISTEMA   btn-ingresar
//=========================================================================================================
var Ingresar_Sistema = function( Parametros ) {

			$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/terceros/Ingreso_Sistema_Validaciones',
							type:     'post',
       success:  function ( Respuesta ){
       		 if ( Respuesta.Resultado_Logueo =='NO-Logueo_OK'){
       		 		 $('#modal_error').modal('show');
       		 }
       		 if ( Respuesta.Resultado_Logueo =='Logueo_OK'){
       		 			window.location.href = "/terceros/Historial";
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

//=========================================================================================================
/// FIN PROCESO DE INGRESO			btn-ingresar
//=========================================================================================================



//=========================================================================================================
/// REGISTRO DE INFORMACIÓN 		btn-registrarse
//=========================================================================================================
var Valida_Exista_Identificacion = function( Parametros, $Reemplazar_Nombre ) {
//1.		Valida que el Nit Exista dentro de nuestra base de datos.

				$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/terceros/Buscar_Por_Identificacion',
							type:     'post',
							async:    false,
       success:  function ( Respuesta ){

       	if (Respuesta.Respuesta=='IdentificacionExiste'){
           if ( $Reemplazar_Nombre != 'undefined' ) {
       			     $('#nomtercero').val(Respuesta.nomtercero);
            }
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
							url:      '/terceros/Consultar_Emails',
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
							url:      '/terceros/Grabar_Registro',
							type:     'post',
       success:  function ( Respuesta ){
       	if (Respuesta.Respuesta=='RegistroGrabado'){
       	 		window.location.href = "/index";
       	}
       }
				});
};




$('#identificacion').on('blur',function(){
		var $identificacion 		 = $("#identificacion").val();
		$Parametros 	 						   = {'identificacion':$identificacion } ;
		Valida_Exista_Identificacion ( $Parametros, true );
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
				Valida_Exista_Identificacion ( $Parametros, true);
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



//=========================================================================================================
/// CUMPLIMIENTO EN ENTREGAS
//=========================================================================================================


$("#btn-cumplimiento-entregas").on('click', function() {

		 $.ajax({
           data:  '',
           dataType: 'json',
           url:      '/terceros/Cumplimiento_Entregas/',
           type:     'post',
           async:    true,
       success:function(data){

            var valores = eval(data);

            var e   = valores[0];
            var f   = valores[1];


            var Datos = {
                    labels : ['Mes Anterior', 'Este Mes'],
                    datasets : [
                        {
                            fillColor : 'rgba(91,228,146,0.6)', //COLOR DE LAS BARRAS
                            strokeColor : 'rgba(57,194,112,0.7)', //COLOR DEL BORDE DE LAS BARRAS
                            highlightFill : 'rgba(73,206,180,0.6)', //COLOR "HOVER" DE LAS BARRAS
                            highlightStroke : 'rgba(66,196,157,0.7)', //COLOR "HOVER" DEL BORDE DE LAS BARRAS
                            data : [e, f ]
                        },
                    ]
                }
                var contexto = document.getElementById('grafico').getContext('2d');
                window.Barra = new Chart(contexto).Bar(Datos, { responsive : true });
               }
        });
			});
//

//=========================================================================================================
/// REPORTE DE PROVEEDORES ACTUALIZAR REPORTE
//=========================================================================================================

$("#btn-actualizar-reporte").on('click', function() {
			var $Solucion      = $("#solucion_implementada").val();
			var $Pasos         = $("#Pasos").val();
			var $Observaciones = $("#observaciones").val();
		 var $IdRegistro    = $(this).attr("data-idregistro");


	 if ( $Solucion  === '' ) {
	 				Mostrar_Mensajes( "Datos Incompletos ", 'Debe diligneciar el campo: Respuesta del proveedor');
							return ;
				}
			$Parametros 	 						   = {'Solucion':$Solucion ,'Pasos':$Pasos,'Observaciones':$Observaciones, "idregistro":$IdRegistro   } ;
			$.ajax({
							data:  $Parametros,
							dataType: 'text',
							url:      '/terceros/Mantenimiento_Actualizar',
							type:     'post',
   				success:  function ( Respuesta ){

   							if ( $.trim(Respuesta)=='OK'){
   	 								window.location.href = "/terceros/maquinas/";
   						}
   				}
					});
});



//=========================================================================================================
/// PROCESOS PARA CAMBIO DE CONTRASEÑA
//=========================================================================================================

var Mensaje_Resultado_Cambio_Password_OK = function()
{
		 var $html =''
			$('#dv-img-cargando').hide();
			$('.modal-body').html('');
			$('.header-login').html('');
			$('.header-login').html('Correo enviado correctamente');
			$html ='<br>Hemos enviado a la cuenta de correo electrónico registrada las instrucciones necesarias para que cambies tu contraseña.<br>';
			$html = $html + '<br><br>';
			$('.modal-body').html($html);
			$('.btn-enviar').hide();

}


var Mensaje_Resultado_Cambio_Password_NoEnvio_Correo = function()
{
	$('#dv-img-cargando').hide();
	$("#msgbox").removeClass().addClass('messagebox').text('El correo no pudo ser enviado. Tal vez se deba a saturación del servidor. Favor inténtelo más tarde.').fadeIn(3000);
}

var Mensaje_Resultado_Cambio_Password_Cuenta_No_Ok = function()
{
		$('#dv-img-cargando').hide();
		$("#msgbox").removeClass().addClass('messagebox').text('La cuenta de correo no tiene un formato válido para el envío de correos electrónicos.').fadeIn(3000);
}

var Mensaje_Resultado_Cambio_Password_Correo_No_Existe = function()
{
			$('#dv-img-cargando').hide();
			$("#msgbox").removeClass().addClass('messagebox').text('La cuenta de correo digitada no se encuentra registrada en nuestra base de datos.').fadeIn(3000);
}


function Recuperar_Password(Parametros)
{
			$("#dv-img-cargando").show();

			$.ajax({
							data:  Parametros,
							dataType: 'json',
							url:      '/terceros/Recuperar_Password_Paso_01/',
							type:     'post',
        success:  function (resultado)
      	 {

      	 		if (resultado.CorreoEnviado=='Ok'){
      	 					 Mensaje_Resultado_Cambio_Password_OK();
      	 					}
      	 		if (resultado.CorreoEnviado=='NoOk'){
      	 						Mensaje_Resultado_Cambio_Password_NoEnvio_Correo();
      	 					}
	     	 		if (resultado.CorreoEnviado=='Correo_No_OK'){
	     	 					Mensaje_Resultado_Cambio_Password_Cuenta_No_Ok();
	     	 				 }
	     	 		if (resultado.CorreoEnviado=='NoUsuario')		{
	     	 			   Mensaje_Resultado_Cambio_Password_Correo_No_Existe();
	     	 			  }

	     	 		},
	     	complet: function(){
	     	 					$("#dv-img-cargando").hide();
      	 }
				});

}



$("#dv-img-cargando").hide();
$("#btn-cambio_password-inicio").hide();

$("#modal_cambiar_password").on('click', function() {
	$('#modal_cambio_password').modal('show');
});

// BOTON PARA RECUPERAR CONTRASEÑA $("#btn-recupera-pass").on('click',function(){
$("#btn-recupera-pass").on('click',function(){
		var $email 			  = $('#login-username').val();
		var $Parametros = { "Email": $email };
		Recuperar_Password($Parametros);

});


 $("#btn-cambio_password").on('click',function(){
		var $password 			  					= $('#password-nuevo').val();
		var $password_confirma 	= $('#password-nuevo-confirma').val();
		var $token 												 = $('#codigo-verificacion').val();
		var $idtercero 								 = $('#idtercero').val();
		$Titulo ='CAMBIO DE CONTRASEÑA';


		 if( $("#password-nuevo").val().length < 1) {
		 	 		Mostrar_Mensajes( $Titulo, 'La contraseña es un campo obligatorio, no puede estar en blanco.' );
		 }else{

		if ( ( $password != $password_confirma )  ){
				 Mostrar_Mensajes( $Titulo, 'La constraseña y su confirmación deben ser iguales y no pueden estar en blanco.' );
				}else {
						var $Parametros = { "password": $password , "idtercero" : $idtercero };
						$.ajax({
							data:  $Parametros,
							dataType: 'json',
							url:      '/terceros/Password_Modificar/',
							type:     'post',
        success:  function (resultado) 	 {
      	 		if (resultado.PasswordCambiado=='Ok'){
      	 					Mostrar_Mensajes( $Titulo, 'La constraseña ha sido cambiada con éxito. Ahora podrá hacer uso del nuestro sistema de información' );
      	 					}
	     	 		},
	     	complete: function(){
	     					$('#btn-cambio_password').hide();
	     					$("#btn-cambio_password-inicio").show();
      	 }
				});
				}
			}
});

// BOTON PARA RECUPERAR CONTRASEÑA $("#btn-recupera-pass").on('click',function(){
$("#btn-cambio_password-inicio").on('click',function(){
		window.location.href = "/index/";
});

$("#btn-inicio-no-token").on('click',function(){
		window.location.href = "/index/";
});
//=========================================================================================================
/// FIN PARA CAMBIO DE CONTRASEÑA
//=========================================================================================================




//=========================================================================================================
// REGISTRO DE DATOS EN FERIA
//=========================================================================================================

$('#identificacion_feria').on('blur',function(){
   var $identificacion    = $("#identificacion_feria").val();
  $Parametros            = {'identificacion':$identificacion } ;
  Valida_Exista_Identificacion ( $Parametros );
  if ( $RespuestaAjax == 'ok'){
       Mostrar_Mensajes('REGISTRO DATOS BÁSICOS', 'La identificación : ' + $identificacion +' ya se encuentra registrada en Cripack S.A.S.');
       $("#identificacion_feria").val('');
  }

})


$('#feria-grabar-registro').on('click',function(){
  var identificacion  = $("#identificacion_feria").val();
  var Tipo_Doc        = $("select[name='idtpdoc']").val();
  var nomtercero      = $("#nomtercero").val();
  var cliente         = $('#cliente').is(':checked');
  var proveedor       = $('#proveedor').is(':checked');
  var direccion       = $("#direccion").val();
  var telefono        = $("#telefono").val();
  var idmcipio        = $("select[name='idmcipio']").val();
  var idzona_ventas   = $("select[name='idzona_ventas']").val();
  var contacto        = $("#contacto").val();
  var idcargo_externo = $("select[name='idcargo_externo']").val();
  var idarea          = $("select[name='idarea']").val();
  var celular         = $("#celular").val();
  var email           = $("#email").val();
  var sector          = $("#sector").val();
  var tipo_producto   = $("#tipo_producto").val();
  var observacion     = $("#observacion").val();



})

//=========================================================================================================
// FIN REGISTRO DE DATOS EN FERIA
//=========================================================================================================





var Ion = {

	init : function()
	{

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
		$(".allionIn").height(alto-84-40);


	},

};

Ion.init();
