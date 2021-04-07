// JavaScript Document



var $RespuestaAjax        ='';
var $Titulo               = '¡ ERROR EN REGISTRO !';
var $Respuesta_Validacion ='';

$("#dv-img-cargando").hide();


var Mostrar_Mensajes = function( $Titulo, $Contenido ){
     $('.modal-header #contenido').html($Titulo);
     $('.modal-body #contenido').html($Contenido);
     $('#modal_error').modal('show');
}

$("#btn-ingresar").on('click', function() {
		var $email 		 = $("#email").val();
		var $password = $("#password").val();
		$Parametros 	 = {'email':$email,'Password':$password  } ;
		Ingresar_Sistema ( $Parametros)
});


//=========================================================================================================
/// PROCESO DE INGRESO AL SISTEMA   btn-ingresar
//=========================================================================================================
var Ingresar_Sistema = function( Parametros ) {
			$.ajax({
							data:  Parametros,
 
							url:      '/terceros/Ingreso_Sistema_Validaciones',
              type: 'post',

        success: function (Respuesta) {
           
          
           if ( parseInt(Respuesta.DiasSinCompra) > 180){
            $('#mensaje_inactivo').modal('show');
           }else {
         		 if ( Respuesta.Resultado_Logueo =='NO-Logueo_OK'){
         		 		 $('#modal_error').modal('show');
         		 }
         		 if ( Respuesta.Resultado_Logueo =='Logueo_OK'){
         		 			window.location.href = "/terceros/Historial";
         		 }
            }
        },
            error: function (xhr, textStatus, errorMessage) {
              console.log("ERROR ->... " + errorMessage);
              console.log(xhr);
              console.log(textStatus);
            } 
				});
}

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
	 				Mostrar_Mensajes( "Datos Incompletos ", 'Debe diligenciar el campo: Respuesta del proveedor');
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
		window.location.href = "/";
});

$("#btn-inicio-no-token").on('click',function(){
		window.location.href = "/";
});
//=========================================================================================================
/// FIN PARA CAMBIO DE CONTRASEÑA
//=========================================================================================================




//=========================================================================================================
// REGISTRO DE DATOS EN FERIA
//=========================================================================================================

 var Validaciones_Previas_Registro_Feria = function(identificacion,nomtercero, cliente, proveedor,email, otro) {
    var texto = '';
    if ( $.trim( identificacion ) =='') { texto ='Debe registrar el número de identificación.<br>'; }
    if ( $.trim( nomtercero )     =='') { texto = texto +'Debe registrar el nombre o razón social.<br>'; }
    if ( cliente == false && proveedor == false && otro == false){
        texto = texto +'Indique si el registro es de un cliente, proveeor u otro.<br>';
       }
    if ( $.trim( email )     =='') { texto = texto +'Registro el correo electrónico.<br>'; }
    $Respuesta_Validacion = texto;
 }

$('#identificacion_feria').on('blur',function(){
   var $identificacion    = $("#identificacion_feria").val();
  $Parametros            = {'identificacion':$identificacion } ;
  Valida_Exista_Identificacion ( $Parametros );
  if ( $RespuestaAjax == 'ok'){
      window.location.href = "/terceros/Registro_Visitantes/"+$identificacion;
  }

})

$('.areas-interes').on('click',function(){
    var IdTercero  = $(this).data('idtercero');
    var NomTercero = $(this).data('nomtercero');
    Parametros ={'idtercero':IdTercero};
    alert ( "Pendiente mostrar otros tipos de trabajo en los que el cliente está interesado."   );

  /*  $.ajax({
         data:  Parametros,
         dataType: 'json',
         url:      '/terceros/Visitantes_Areas_Interes_Consultar/',
         type:     'get',
          success:  function ( MyServerResponse ) {
                $('#modal_areas_interes').modal('show');
            },
      });
      */

})



$('#entrega-tarjeta').on('click',function(){
  var entrega_tarj      = $('#entrega-tarjeta').is(':checked');
  if ( entrega_tarj  == true ) {
    $('.entrega-tarj').text('SI');
  }else{
   $('.entrega-tarj').text('NO');
  }
})


function Visitantes_Grabar_Datos( Parametros ){

   $("#dv-img-cargando").show();

   $.ajax({
       data:  Parametros,
       dataType: 'json',
       url:      '/terceros/Visitantes_Grabar_Datos/',
       type:     'post',
        success:  function ( MyServerResponse ) {
          if ( MyServerResponse.Respuesta == 'Todo-Ok'){
                alert('Registro almacenado con éxito !!!');
                window.location.href = "/terceros/Registro_Visitantes";
                //window.location.href = "/terceros/Listado_Visitantes";
               $("#dv-img-cargando").hide();
              }else{
                Mostrar_Mensajes('REGISTRO DE VISITANTES', MyServerResponse.Respuesta);
              }
          },
       complet: function(){
             $("#dv-img-cargando").hide();
        }
    });
}

//--------------------------------------------------------
/* MAYO 30 2017-    ELIMINAR EL REGISTRO DE UN VISITANTE
-----------------------------------------------------------
*/
$('.container-fluid').on('click','.visitante-eliminar',function(){
   var IdRegistro = $(this).data('idregistro');
   $('.modal-body #idregistro').val(IdRegistro);
   $('#modal_eliminar').modal('show');
})
//-----------------------------------------------------------------
$('#btn-eliminar').on('click',function(){
   var IdRegistro = $("#idregistro").val();

    $.ajax({
              data:  {"idregistro" :IdRegistro},
              dataType: 'text',
              url:      '/terceros/Eliminar_Registro_Visitante/',
              type:     'post',
        success:  function (resultado)  {
               window.location.href = "/terceros/Listado_Visitantes";
            },

        });


})
//-----------------------------------------------------------------
/* MAYO 30 2017     ENVIAR AGRADECIMIENTO A LOS VISITANTES
//-----------------------------------------------------------------
*/
$('.container-fluid').on('click','.btn-agradecer',function(){
  var IdRegistro = $(this).data('idregistro');


      $.ajax({
              data:  {"idregistro" :IdRegistro},
              dataType: 'text',
              url:      '/terceros/Visitantes_Agradecer_Visita/',
              type:     'post',
        success:  function (resultado)  {

                  if ( $.trim(resultado) != 'correo_OK'){

                    Mostrar_Mensajes('ERROR EN EL ENVÍO DEL MENSAJE', "El mensaje no pudo ser enviado. Intente más tarde." );
                  }else{
               window.location.href = "/terceros/Listado_Visitantes";
             }
            },

        });
})

$('.table-responsive').on('click','.btn-invitacion-cliente',function(){
   var IdTercero = $(this).data('idtercero');
   var Empresa   = $(this).data('nomtercero');
   var Contacto  = $(this).data('contacto');
   var Nom_Cargo = $(this).data('nom_cargo');
   var Email     = $(this).data('email');
   var IdRegistro     = $(this).attr('id')
   var Btn = document.getElementById(IdRegistro);

      $.ajax({
              data:  {"idtercero" :IdTercero, 'empresa':Empresa, "email":Email, 'contacto':Contacto, 'nom_cargo':Nom_Cargo},
              dataType: 'text',
              url:      '/terceros/Invitacion_Clientes/',
              type:     'post',
        success:  function (resultado)  {
              if ( $.trim(resultado) != 'correo_OK'){
                  Mostrar_Mensajes('ERROR EN EL ENVÍO DEL MENSAJE', "El mensaje no pudo ser enviado. Intente más tarde." );
              }else{
                   Btn.classList.remove('btn-success');
                   Btn.className += " disabled";
                   Btn.className += " btn-danger";
              }
            },

        });
})



$('.table-responsive').on('click','.btn-registrar-cliente',function(){
   var Identificacion = $(this).data('identificacion');
   window.location.href='/terceros/Registro_Visitantes/' + $.trim(Identificacion);
})




//-----------------------------------------------------------------
/* MAYO 30 2017     ENVIAR AGRADECIMIENTO A LOS VISITANTES
//-----------------------------------------------------------------
*/
$('.container-fluid').on('click','.btn-agregar-cliente',function(){
  var IdRegistro = $(this).data('idregistro');
      $.ajax({
              data:  {"idregistro" :IdRegistro},
              dataType: 'text',
              url:      '/terceros/Visitantes_Convertir_Cliente/',
              type:     'post',
        success:  function (resultado)  {

                if ( $.trim(resultado) =='correo_OK'){
                    window.location.href = "/terceros/Listado_Visitantes";
                  }else{
                    Mostrar_Mensajes('ERROR EN ENVÍO DE MENSAJE', 'El mensaje no pudo ser enviado. Por favor intente más tarde.' );
                  }
            },

        });


})



$('#feria-grabar-registro').on('click',function(){
  var identificacion  = $("#identificacion_feria").val();
  var Tipo_Doc        = $("select[name='idtpdoc']").val();
  var nomtercero      = $("#nomtercero").val();
  var cliente         = true ;//$('#cliente').is(':checked');
  var proveedor       = false; //$('#proveedor').is(':checked');
  var otro            = $('#otro').is(':checked');
  var direccion       = $("#direccion").val();
  var telefono        = $("#telefono").val();
  var idmcipio        = $("select[name='idmcipio']").val();
  var idpais          = $("select[name='idpais']").val();
  var idzona_ventas   = $("select[name='idzona_ventas']").val();
  var sector          = $("#sector").val();
  var idestilotrabajo = $("select[name='idestilotrabajo[]']").val();
  var observacion     = $("#observacion").val();
  var atendido_por    = $("#atendido-por").val();

  var contacto        = $("#contacto").val();
  var idcargo_externo = $("select[name='idcargo_externo']").val();
  var idarea          = $("select[name='idarea']").val();
  var celular         = $("#celular").val();
  var email           = $("#email").val();

  var clien_existe    = $('#cliente-existente').is(':checked');
  var posible_clien   = $('#posible-cliente').is(':checked');
  var informacion     = $('#informacion').is(':checked');
  var competencia     = $('#competencia').is(':checked');
  var entrega_tarj    = $('#entrega-tarjeta').is(':checked');


  var persona_visita  = $("#persona-visita").val();
  var contactar_por   = $('input:radio[name=optradio]:checked').val();


   Validaciones_Previas_Registro_Feria( identificacion,nomtercero, cliente, proveedor,email );
  if ( $Respuesta_Validacion != '' ){
       $("#dv-img-cargando").hide();
       Mostrar_Mensajes('INFORMACIÓN REQUERIDA', $Respuesta_Validacion );
       return;
  }

  parametros ={'identificacion':identificacion,'Tipo_Doc':Tipo_Doc,'nomtercero':nomtercero, 'cliente':cliente,'proveedor':proveedor, 'direccion':direccion,'telefono':telefono, 'idmcipio':idmcipio, 'idpais':idpais,'idzona_ventas':idzona_ventas, 'sector':sector,  'idestilotrabajo':idestilotrabajo,'observacion':observacion, 'atendido_por':atendido_por,'contacto':contacto,  'idcargo_externo':idcargo_externo, 'idarea':idarea, 'celular':celular, 'email':email, 'clien_existe':clien_existe, 'posible_clien':posible_clien,'informacion':informacion, 'competencia':competencia, 'entrega_tarj':entrega_tarj, 'persona_visita':persona_visita, 'contactar_por':contactar_por,'otro':otro     };

  Visitantes_Grabar_Datos ( parametros );


});

$("#consulta-ventas").on('click', function() {
   var fecha_ini = $("#fecha_ini").val();
   var fecha_fin = $("#fecha_fin").val();

   if ( $.trim(fecha_ini )=='' || $.trim( fecha_fin )=='' ) {
       Mostrar_Mensajes('ERROR EN LAS FECHAS', "Alguna de las fechas parece no tener un formato válido." );
       return;
   }
   if ( fecha_ini > fecha_fin ){
       Mostrar_Mensajes('ERROR EN LAS FECHAS', "La fecha inicial no puede ser mayor a la fecha final." );
       return;
   }


  $.ajax({
            data:  {'fecha_ini':fecha_ini,'fecha_fin':fecha_fin},
            dataType: 'html',
            url:      '/terceros/Ventas_x_Cliente_x_Fechas/',
            type:     'post',
      success:  function (MyServerResponse)  {

             $('#datos-ventas').html('');
             $('#datos-ventas').html( MyServerResponse );

        }
      });


});


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
