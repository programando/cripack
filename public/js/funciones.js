
var  Funciones = {


  Mostrar_Mensajes : function( $Titulo, $Contenido ){
   $('.modal-header #contenido').html($Titulo);
   $('.modal-body #contenido').html($Contenido);
   $('#modal_error').modal('show');
    },// fin  Mostrar_Mensajes





}// Fin Funciones

