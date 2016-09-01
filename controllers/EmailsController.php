<?php

  class EmailsController extends Controller
  {
  	  private $Email ;

      public function __construct()
      {
          parent::__construct();
          $this->Remisiones = $this->Load_Model('Remisiones');
          $this->Email    = $this->Load_External_Library('class.phpmailer');
          $this->Email    = new PHPMailer();
      }

      public function Index() { }




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
           $Kilos  = $Kilos  + $OT['kilos_reales'] ;
           $Paquetes ++;

        }
        $Paquetes        = $Paquetes - 1;
        $Texto_Correo    = str_replace("#_TABLA_#"      ,  $Tabla       , $Texto_Correo);
        $Texto_Correo    = str_replace("#_PAQUETES_#"   ,  $Paquetes    , $Texto_Correo);
        $Texto_Correo    = str_replace("#_KILOS_#"      ,  $Kilos       , $Texto_Correo);

        $this->Email->Body    = $this->Unir_Partes_Correo ( $Texto_Correo ) ;

        $this->Email->AddAddress( $Email  );
        $this->Email->AddCC("Serviclientes@cripack.net");
        $Respuesta              = $this->Enviar_Correo();
        //Debug::Mostrar( $Respuesta  );
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



