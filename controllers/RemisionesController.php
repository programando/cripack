<?php
	/* AGOSTO 24 DE 2014
			Realiza la llamada a la vista correspondiente y traslada los parametros que necesita
			a Cada controlador el corresponde una vista. en el proyecto se encuentran dentro de carpetas
			La extensión de estas vistas es PHTML, dentro del rectorio views
	 */
class RemisionesController extends Controller {

    public function __construct()  {
        parent::__construct();
        $this->Emails                = $this->Load_Controller('Emails');
        $this->Remisiones            = $this->Load_Model('Remisiones');

    }

    public function Index(  ) { }


    public function Remisiones_Informar_Clientes (){
      /*  SEPTIEMBRE 05 2016
      **      ENVIA CORREOS A PARTIR DE LAS GUÍAS DE TCC GENERADAS EN EL SISTEMA
      */

        $Remesas = $this->Remisiones->Consulta_Remisiones_Informar_Email();                             //    00
        foreach ( $Remesas as $Remesa ) {
            $Id_Remesa      = $Remesa['idregistro'] ;
            $NumeroGuia     = $Remesa['num_remesa'] ;
            $Datos_Emails   = $this->Remisiones->Datos_Enviar_x_Remesa               ( $Id_Remesa );     //     01
            $Datos_Empresas = $this->Remisiones->Datos_Enviar_x_Remesa_Datos_Empresa ( $Id_Remesa );     //     02
            $Datos_Ots      = $this->Remisiones->Datos_Enviar_x_Remesa_Datos_Ots     ( $Id_Remesa );     //     03

            foreach ( $Datos_Empresas as $Datos_Empresa ) {
               $Destinatario = trim( $Datos_Empresa['contacto'] );
               $Email        = trim( $Datos_Empresa['email'] );
               $Empresa      = $this->Unir_Empresa_Sucursal (  $Datos_Empresa['nomtercero'], $Datos_Empresa['nom_sucursal'] );
               $this->Emails->Remisiones_Enviar_Informe_Correo (  $Empresa, $Destinatario, $NumeroGuia, $Datos_Ots , $Email  ) ;
            }

          $this->Remisiones->Despachos_Actualizar_Enviados( $Id_Remesa ,0 );
        }
    }// Fin  Remisiones_Informar_Clientes


    public function Notificaciones_Alternas_Remisiones() {
      /* SEPTIEMBRE 20 2016
      **    ENVIA CORREOS A LOS CLIENTES QUE SE LES REMISIONA PERO SUS DESPACHOS SE ENVÍAS A BOGOTÁ PARA QUE DESDE ALLI
      **    SEAN ENTREGADOS
      */
      $Remisiones = $this->Remisiones->Notificacion_Clientes_Datos_Remision();
      foreach ( $Remisiones as $Remision ) {
            $IdRegistro   = $Remision['idregistro'];
            $Destinatario = trim( $Remision['contacto'] );
            $Email        = trim( $Remision['email'] );
            $NumeroGuia   = $Remision['nro_guia'] ;
            $Empresa      = $this->Unir_Empresa_Sucursal (  $Remision['nomtercero'], $Remision['nom_sucursal'] );
            $Datos_Ots    = $this->Remisiones->Notificacion_Clientes_Datos_Remision_Ots     ( $Remision['idremision'] );
            $Respuesta = $this->Emails->Remisiones_Enviar_Informe_Correo (  $Empresa, $Destinatario, $NumeroGuia, $Datos_Ots , $Email  ) ;
            if ( $Respuesta == 'correo_OK'){
              $this->Remisiones->Despachos_Actualizar_Enviados( 0 , $IdRegistro );
            }

      }// Fin Foreach Remisiones

    }// Fin Notificaciones_Alternas_Remisiones


    private function Unir_Empresa_Sucursal($Empresa, $Sucursal ){
         $Sucursal = trim (  $Sucursal );
         $Empresa  = trim ( $Empresa   ) ;

        if ( !empty( $Sucursal  ) && strlen($Sucursal ) > 0 ) {
                $Empresa  = $Empresa . ' - ' .  $Sucursal ;
           }
           return trim( $Empresa ) ;
    }// fin Unir_Empresa_Sucursal


}?>

