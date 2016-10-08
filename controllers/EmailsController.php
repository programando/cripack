<?php

  class EmailsController extends Controller
  {
  	  private $Email ;

      public function __construct() {
          parent::__construct();
          $this->Remisiones = $this->Load_Model('Remisiones');
          $this->Email      = $this->Load_External_Library('class.phpmailer');
          $this->Email      = new PHPMailer();
      }

      public function Index() { }


    public function Cotizaciones_Enviar_Notificacion ($Email, $Destinatario , $Cotizacion_H , $Cotizacion_Dt  ){
      /*  OCTUBRE 03 DE 2016
            REALIZA ENVÍO DE CORREOS DE NOTIFICACIÓN PARA LAS COTIZACIONES  A LAS QUE HACEMOS SEGUIMIENTO
      */

        $Empresa       =  $Cotizacion_H[0]['nomtercero'];
        $FechaCotiz    =  Fechas::Formato( $Cotizacion_H[0]['fecha']) ;
        $NroCotizacion = $Cotizacion_H[0]['numcotizacion'];
        $Texto_Correo  = file_get_contents(BASE_EMAILS.'cotizaciones.phtml','r');

        $Texto_Correo    = str_replace("#_EMPRESA_#"              , $Empresa        , $Texto_Correo);
        $Texto_Correo    = str_replace("#_DESTINATARIO_#"         , $Destinatario   , $Texto_Correo);
        $Texto_Correo    = str_replace("#_FECHA_COTIZACION_#"     , $FechaCotiz     , $Texto_Correo);
        $Texto_Correo    = str_replace("#_NUMERO_COTIZACION_#"    , $NroCotizacion  , $Texto_Correo);

         $Tabla    = '';

        foreach ($Cotizacion_Dt  as $CotizDt) {

           $Tabla =  $Tabla ."<tr>" ;

           $Tabla = $Tabla . "<td>" . trim( $CotizDt['referencia']        )    . "</td>" ;
           $Tabla = $Tabla . "<td>" . trim( $CotizDt['nomestilotrabajo']  )    . "</td>" ;
           $Tabla = $Tabla . "<td>" . trim( $CotizDt['nomtipotrabajo']    )    . "</td>" ;
           $Tabla = $Tabla . "<td>" . trim( $CotizDt['nommaterial']       )    . "</td>" ;
           $Tabla = $Tabla . "<td style='text-align: center'>" . trim( $CotizDt['cabida']            )    . "</td>" ;
           $Tabla = $Tabla . "<td style='text-align: center'>" . trim( $CotizDt['cantidad']            )    . "</td>" ;
           $Tabla = $Tabla . "<td style='text-align: center'>" . trim( $CotizDt['encauche']            )    . "</td>" ;
           $Tabla = $Tabla . "<td>" . Numeric_Functions::Formato_Numero( $CotizDt['vr_precio_vta_dado'] )                . "</td>" ;
           $Tabla = $Tabla . '</tr>';
        }
        $Texto_Correo       = str_replace("#_TABLA_#"      ,  $Tabla       , $Texto_Correo);
        $this->Email->Body  = $this->Unir_Partes_Correo ( $Texto_Correo ) ;

        $this->Configurar_Cuenta('Seguimiento Cotización Nro.: ' .$NroCotizacion  . ' Cripack S.A.S '   );
        $this->Email->AddAddress( $Email  );
        $this->Email->AddCC("Serviclientes@cripack.net");
        $this->Email->AddCC("jhonjamesmg@hotmail.com");
        $Respuesta   = $this->Enviar_Correo();
    }



      public function Remisiones_Enviar_Informe_Correo ( $Empresa, $Destinatario, $NumeroGuia, $Datos_Ots, $Email   ){

        $this->Configurar_Cuenta('Notificación despacho desde Cripack S.A.S. Guía Nro.: ' . $NumeroGuia );
       $Url = 'https://www.tcc.com.co/rastreo?tipo=RE&documento='.$NumeroGuia;
       $Texto_Correo    = file_get_contents(BASE_EMAILS.'remisiones_despachadas.phtml','r');
       $Texto_Correo    = str_replace("#_EMPRESA_#"        , $Empresa,$Texto_Correo);
       $Texto_Correo    = str_replace("#_DESTINATARIO_#"   , $Destinatario , $Texto_Correo);
       $Texto_Correo    = str_replace("#_DESTINATARIO_#"   , $Destinatario , $Texto_Correo);
       $Texto_Correo    = str_replace("#_NUMERO_GUIA_#"    ,  $NumeroGuia   , $Texto_Correo);
       $Texto_Correo    = str_replace("#_URL_#"            ,  $Url  , $Texto_Correo);


         $Tabla    = '';
         $Paquetes = 1 ;
         $Kilos    = 0;
        foreach ($Datos_Ots  as $OT) {

           $Tabla =  $Tabla ."<tr>" ;
           $Tabla = $Tabla . "<td>" . $Paquetes                 . "</td>" ;
           $Tabla = $Tabla . "<td>" . $OT['numero_ot']          . "</td>" ;
           $Tabla = $Tabla . "<td>" . trim($OT['nomestilotrabajo'])   . "</td>" ;
           $Tabla = $Tabla . "<td>" . trim($OT['referencia'] )        . "</td>" ;
           $Tabla = $Tabla . '</tr>';
           $Kilos =  $OT['kilos_reales'] ;
        }
        $Texto_Correo    = str_replace("#_TABLA_#"      ,  $Tabla       , $Texto_Correo);
        $Texto_Correo    = str_replace("#_PAQUETES_#"   ,  $Paquetes    , $Texto_Correo);

        if ( $Kilos > 0 ) {
            $TextoKilos = "Total : <strong> $Paquetes paquetes/unidades </strong> con un peso aproximado de : <strong> $Kilos Kilos. </strong>";
        }else{
          $TextoKilos = '';
        }

        $Texto_Correo    = str_replace("#_KILOS_#"      ,  $TextoKilos      , $Texto_Correo);
        $this->Email->Body    = $this->Unir_Partes_Correo ( $Texto_Correo ) ;

        $this->Email->AddAddress( $Email  );
        $this->Email->AddCC("Serviclientes@cripack.net");
        $this->Email->AddCC("jhonjamesmg@hotmail.com");
        $Respuesta              = $this->Enviar_Correo();
      }







    public function Configurar_Cuenta( $asunto ) {

       $this->Email->IsSMTP();
       $this->Email->SMTPDebug     =0;
       $this->Email->SMTPAuth      = true;
       $this->Email->IsHTML        = true;                      // enable SMTP authentication
       $this->Email->ContentType   = "text/html";
       $this->Email->CharSet       = "utf-8";
       $this->Email->SMTPSecure    = 'ssl';                     // sets the prefix to the servier
       $this->Email->Host          = 'smtpcal.une.net.co';         // sets GMAIL as the SMTP server
       $this->Email->Port          = 465;
       $this->Email->SMTPKeepAlive = true;
       $this->Email->Mailer        = "smtp";                   // set the SMTP port
       $this->Email->Username      = CORREO_MASIVO;         // GMAIL username
       $this->Email->Password      = PASS_CORREO_MASIVO;    // GMAIL password
       $this->Email->From          = CORREO_MASIVO;
       $this->Email->FromName      = 'Cripack S.A.S.';
       $this->Email->Subject       = $asunto;
       $this->Email->AltBody       = ""; //Text Body
       $this->Email->WordWrap      = 50; // set word wrap                                // send as HTML
    }


    public function Enviar_Correo(){
        if ( $this->Email->Send()){
            $this->Email->clearAddresses();
            return "correo_OK";
        }else {
          $this->Email->clearAddresses();
          echo "Error: " . $this->Email->ErrorInfo;
         return "correo_No_OK";
        }
     }

   private function Unir_Partes_Correo (   $Body ){
       $Header             = file_get_contents(APPLICATION_SECTIONS . 'emails/header.php','r');
       $Footer             = file_get_contents(APPLICATION_SECTIONS . 'emails/footer.php','r');
       $Texto_Final_Correo = $Header.$Body.$Footer;

       return $Texto_Final_Correo ;
    }


/* PAGINAS QUE HABILITAN EL EVÍO DE CORREOS EN CUENTAS
    https://www.google.com/settings/u/1/security/lesssecureapps
    https://accounts.google.com/b/0/DisplayUnlockCaptcha
    https://security.google.com/settings/security/activity?hl=en&pli=1
*/
 }
?>



