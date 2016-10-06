<?php
	/* AGOSTO 24 DE 2014
			Realiza la llamada a la vista correspondiente y traslada los parametros que necesita
			a Cada controlador el corresponde una vista. en el proyecto se encuentran dentro de carpetas
			La extensión de estas vistas es PHTML, dentro del rectorio views
	 */
class CotizacionesController extends Controller {

    public function __construct()  {
        parent::__construct();
        $this->Emails                = $this->Load_Controller('Emails');
        $this->Cotizaciones           = $this->Load_Model('Cotizaciones');

    }

    public function Index(  ) { }




    public function Consulta_Notificaciones() {
      /* SEPTIEMBRE 30 2016
      **    ENVIA CORREOS A LOS CLIENTES QUE A QUEINES SE HA COTIZACDO PARA HACER SEGUIMIENTO
      */
      $Notificaciones = $this->Cotizaciones->Consulta_Notificaciones();
      foreach ( $Notificaciones as $Notificacion ) {
           $IdControl       = $Notificacion ['idcontrol'];
           $Email           = $Notificacion ['email'];
           $Destinatario    = $Notificacion ['destinatario'];
           $FechaHoy        = $Notificacion ['hoy'];
           $Fecha_Correo_1  = $Notificacion ['correo1'];
           $Fecha_Correo_2  = $Notificacion ['correo2'];
           $Fecha_Correo_3  = $Notificacion ['correo3'];
           $Fecha_Rechazado = $Notificacion ['rechazada'];

           if ( $FechaHoy  === $Fecha_Correo_1 ){
                $this->Consultar_Datos_Envia_Correo ($IdControl, $Email, $Destinatario );
              }

            if ( $FechaHoy  === $Fecha_Correo_2 ){
                $this->Consultar_Datos_Envia_Correo ( $IdControl, $Email, $Destinatario );
              }

            if ( $FechaHoy  === $Fecha_Correo_3 ){
                $this->Consultar_Datos_Envia_Correo ( $IdControl, $Email, $Destinatario );
              }

            if ( $FechaHoy  === $Fecha_Rechazado ){
                $this->Cotizaciones->Actualizar_Estado_Rechazada( $IdControl, $Email, $Destinatario );
              }


      }// Fin Foreach Notificaciones
    }// Fin Consulta_Notificaciones


    private function Consultar_Datos_Envia_Correo ( $IdControl, $Email, $Destinatario ){
      /* SEPTIEMBRE 30 2016
      **    CONSULTA LOS DATOS DE LA COTIZACION Y ENVÍA EL CORREO DE SEGUIMIENTO
      */
          $Cotizacion_H  = $this->Cotizaciones->Consulta_Cotizacion   ( $IdControl  );
          $Cotizacion_Dt = $this->Cotizaciones->Consulta_Detalle      ( $IdControl  );
          $this->Emails->Cotizaciones_Enviar_Notificacion ( $Email, $Destinatario , $Cotizacion_H , $Cotizacion_Dt );
    }// Fin Consultar_Datos_Envia_Correo


}?>

