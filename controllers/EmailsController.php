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


      public function Enviar_PQR( $Empresa, $Persona, $email, $TipoProblema, $Problema,$Causa ) {
         /** ABRIL 25 DE 2018
         **  ENVÍA CORREOS A TERCRO SOBRE PQR O NO CONFORMIDADES
         */
          $this->Configurar_Cuenta('Radicación PQR Cripack S.A.S.');
          $Texto_Correo       = file_get_contents(BASE_EMAILS.'pqr.phtml','r');
          $Texto_Correo      = str_replace("#_EMPRESA_#"            ,  $Empresa       , $Texto_Correo);
          $Texto_Correo      = str_replace("#_PERSONA_#"            ,  $Persona       , $Texto_Correo);
          $Texto_Correo      = str_replace("#_TIPO_PROBLEMA_#"      ,  $TipoProblema  , $Texto_Correo);
          $Texto_Correo      = str_replace("#_PROBLEMA_#"           ,  $Problema      , $Texto_Correo);
          $Texto_Correo      = str_replace("#_CAUSA_#"              ,  $Causa         , $Texto_Correo);

          $this->Email->Body = $this->Unir_Partes_Correo ( $Texto_Correo ) ;
          $this->Email->AddAddress( $email);
          $this->Email->AddCC("serviclientes@cripack.com");
          $Respuesta  = $this->Enviar_Correo();
          return $Respuesta;
      }



      public function Recuperar_Password( $email ) {
         /** ENERO 31 DE 2015
         **  PROCEDIMIENTO PARA RECUPERAR CONTRASEÑA DE USUARIOS
         */

          $this->Configurar_Cuenta('Recuperación de Contraseña.');
          $this->Email->AddAddress($email );
          $codigo_confirmacion = General_Functions::Generar_Codigo_Confirmacion();
          $enlace              = '<a href=' . BASE_URL .'terceros/Reset_Password/'. $codigo_confirmacion .'> Cambio de Contraseña </a>';
          $Pagina_Correo       = file_get_contents(BASE_EMAILS.'password_cambiar.phtml','r');
          $Pagina_Correo       = str_replace("#_ENLACE_RECUPERA_PASSWORD_#"   , $enlace  ,$Pagina_Correo);

          $this->Email->Body   = $this->Unir_Partes_Correo ($Pagina_Correo );

          if ( $this->Email->Send()) {
              $this->Email->clearAddresses();
              Session::Set('codigo_confirmacion',$codigo_confirmacion);
              $CorreoEnviado ='Ok';
            }
            else {
              $CorreoEnviado='NoOk';
            }
            return $CorreoEnviado ;
      }





    public function Cotizaciones_Enviar_Notificacion ($Email, $Destinatario , $Cotizacion_H , $Cotizacion_Dt  ){
      /*  OCTUBRE 03 DE 2016
            REALIZA ENVÍO DE CORREOS DE NOTIFICACIÓN PARA LAS COTIZACIONES  A LAS QUE HACEMOS SEGUIMIENTO
      */
        $Empresa        =  $Cotizacion_H[0]['nomtercero'];
        $FechaCotiz     =  Fechas::Formato( $Cotizacion_H[0]['fecha']) ;
        $NroCotizacion  = $Cotizacion_H[0]['numcotizacion'];
        $Texto_Correo   = file_get_contents(BASE_EMAILS.'cotizaciones.phtml','r');
        $Texto_Correo   = str_replace("#_EMPRESA_#"              , $Empresa        , $Texto_Correo);
        $Texto_Correo   = str_replace("#_DESTINATARIO_#"         , $Destinatario   , $Texto_Correo);
        $Texto_Correo   = str_replace("#_FECHA_COTIZACION_#"     , $FechaCotiz     , $Texto_Correo);
        $Texto_Correo   = str_replace("#_NUMERO_COTIZACION_#"    , $NroCotizacion  , $Texto_Correo);

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
        $this->Email->AddCC("serviclientes@cripack.com");

        $Respuesta   = $this->Enviar_Correo();

    }

    public function Clientes_Bloqueados_Correo_Semanal ( $destinatario,  $Email, $Empresa   ){
           $this->Configurar_Cuenta('Bloqueo crédito en Cripack S.A.S.' );
           $fecha        = date('j M Y');
           $nuevafecha   = strtotime ( '-3 day' , strtotime ( $fecha ) ) ;
           $nuevafecha   = date ( 'j M Y' , $nuevafecha );
           $Texto_Correo = file_get_contents(BASE_EMAILS.'clientes_bloqueados_correo_semanal.phtml','r');
           $Texto_Correo = str_replace("#_EMPRESA_#"             , $Empresa,$Texto_Correo);
           $Texto_Correo = str_replace("#_DESTINATARIO_#"        , $destinatario,$Texto_Correo);
           $Texto_Correo = str_replace("#_FECHA_CORTE_#"        ,  $nuevafecha,$Texto_Correo);
            $Header             = file_get_contents(EMAILS . 'header.php','r');
            $this->Email->Body = $Header.$Texto_Correo  ;
            $this->Email->AddAddress( $Email);
            $this->Email->AddCC("cartera@cripack.com.co");
            $Respuesta  = $this->Enviar_Correo();
          }


        public function otsExteriorInfomeGestionInterna ( $OTs  ){
          /*  OCTUBRE 25 2018
                RECORDATORIO PARA OTS QUE SE ENCUENTRAN BLOQUEADAS POR DIBUJO EN APROBACIÓN
          */
              
                $Tabla    = '';
                  foreach ( $OTs as $Ot ) {
                    $Tabla =  $Tabla ."<tr>" ;
                      $Tabla = $Tabla . "<td>" . trim($Ot['numero_ot'])        . "</td>" ;
                      $Tabla = $Tabla . "<td>" . trim($Ot['nomtercero'] )      . "</td>" ;
                      $Tabla = $Tabla . "<td>" . trim($Ot['referencia'] )      . "</td>" ;
                    $Tabla = $Tabla . '</tr>';
                  }
              
                $this->Configurar_Cuenta("Órdenes de trabajo del exterior pendientes por despacho" );
                $Texto_Correo    = file_get_contents(BASE_EMAILS.'ots_exterior_infome_gestion_interna.phtml','r');
                $Texto_Correo    = str_replace("#_TABLA_#"      ,  $Tabla  , $Texto_Correo);        
                $this->Email->Body = $this->Unir_Partes_Correo ( $Texto_Correo ) ;
                $this->Email->AddAddress( 'jhonjamesmg@hotmail.com');
                $this->Email->AddAddress( 'jhonjamesmg@gmail.com');
                $this->Email->AddAddress( 'sistemas@balquimia.com');
                
                $Respuesta  = $this->Enviar_Correo();
                
          }




    public function OtBloquedasDibujoEnAprobacion ( $Empresa, $Emails, $Ots   ){
       /*  OCTUBRE 25 2018
            RECORDATORIO PARA OTS QUE SE ENCUENTRAN BLOQUEADAS POR DIBUJO EN APROBACIÓN
      */
           $this->Configurar_Cuenta("Informe Ot's bloquedas por dibujo en aprobación" );
             $Tabla    = '';
            foreach ( $Ots  as $OT ) {
              $Tabla =  $Tabla ."<tr>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['referencia'] )        . "</td>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['nomestilotrabajo'] )  . "</td>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['nomtipotrabajo'])     . "</td>" ;
              $Tabla = $Tabla . '</tr>';
            }
            $Texto_Correo    = file_get_contents(BASE_EMAILS.'ots_bloqueadas_dib_aprobacion.phtml','r');
            $Texto_Correo    = str_replace("#_EMPRESA_#"    , $Empresa , $Texto_Correo);
            $Texto_Correo    = str_replace("#_TABLA_#"      ,  $Tabla  , $Texto_Correo);
            $this->Email->Body = $this->Unir_Partes_Correo ( $Texto_Correo ) ;
                foreach ( $Emails as $Email) {
                $this->Email->AddAddress( $Email['email']);
              }
             $this->Email->AddCC("serviclientes@cripack.com");
             $Respuesta  = $this->Enviar_Correo();
      }


    public function Informe_Ots_Pendientes ( $Empresa, $Sucursal, $Email, $Datos_Ots    ){
           $this->Configurar_Cuenta('Informe Trabajos Pendientes' );
           $Texto_Correo    = file_get_contents(BASE_EMAILS.'ots_pendientes.phtml','r');
           $Texto_Correo    = str_replace("#_EMPRESA_#"        , $Empresa,$Texto_Correo);
           $Texto_Correo    = str_replace("#_SUCURSAL_#"   , $Sucursal , $Texto_Correo);

            $Tabla    = '';
            foreach ($Datos_Ots  as $OT) {

              $Tabla =  $Tabla ."<tr>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['referencia'] )        . "</td>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['nomestilotrabajo'] )  . "</td>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['nomtipotrabajo'])     . "</td>" ;
                 $Tabla = $Tabla . "<td style='text-align: center;'>" . trim($OT['cabida'] )            . "</td>" ;
                 $Tabla = $Tabla . "<td style='text-align: center;'>" . $OT['cantidad']                 . "</td>" ;
                 $Tabla = $Tabla . "<td style='text-align: left;'>" . $OT['abreviatura_labor']        . "</td>" ;
               $Tabla = $Tabla . '</tr>';

            }
            $Texto_Correo      = str_replace("#_TABLA_#"      ,  $Tabla       , $Texto_Correo);
            $this->Email->Body = $this->Unir_Partes_Correo ( $Texto_Correo ) ;
            $this->Email->AddAddress( $Email);
            $this->Email->AddCC("serviclientes@cripack.com");
            $Respuesta  = $this->Enviar_Correo();
      }



 public function Informe_Clientes_Bloqueados ( $Empresa, $Destinatarios, $Datos_Ots, $Texto_Email   ){

           $this->Configurar_Cuenta('Informe Trabajos Bloqueados ' . APP_NAME );
           $Texto_Correo    = file_get_contents(BASE_EMAILS.'clientes_bloqueados.phtml','r');
           $Texto_Correo    = str_replace("#_EMPRESA_#"        , $Empresa,$Texto_Correo);

           $Cabecera ='<table   width="100%">
                      <thead  style="text-align: center; color: #fff; background-color: #272C6B;">
                        <tr>
                          <th>Referencia</th>
                          <th>Estilo</th>
                          <th>Trabajo</th>
                          <th>Cab.</th>
                          <th>Cant.</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>';
           $Tabla    = '';

            foreach ($Datos_Ots  as $OT) {
              $Tabla =  $Tabla ."<tr>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['referencia'] )        . "</td>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['nomestilotrabajo'] )  . "</td>" ;
                 $Tabla = $Tabla . "<td>" . trim($OT['nomtipotrabajo'])     . "</td>" ;
                 $Tabla = $Tabla . "<td style='text-align: center;'>" . trim($OT['cabida'] )            . "</td>" ;
                 $Tabla = $Tabla . "<td style='text-align: center;'>" . $OT['cantidad']                 . "</td>" ;
                 $Tabla = $Tabla . "<td style='text-align: left;'>" . $OT['abreviatura_labor']        . "</td>" ;
               $Tabla = $Tabla . '</tr>';
            }
            $PieTabla ='      </tbody>    </table>' ;

            if (  $Tabla != '' ) {
              $Texto_Correo      = str_replace("#_TABLA_#"      ,  $Cabecera.$Tabla  .$PieTabla      , $Texto_Correo);
            }else  {
               $Texto_Correo      = str_replace("#_TABLA_#"      ,  ''      , $Texto_Correo);
            }
            $this->Email->Body = $Texto_Correo  ;
            $this->Email->AddAddress($Destinatarios);
            $this->Email->AddCC("serviclientes@cripack.com");
            $this->Email->AddCC("cartera@cripack.com.co");
            $this->Email->AddCC("produccion@cripack.com");
            $this->Email->AddCC("auxiliarcontable@cripack.com");
            $Respuesta  = $this->Enviar_Correo();
            return $Respuesta;
          }


/* MAYO 30 DE 2017
   ENVIA CORREO DE AGRADECIMIENTO PARA LAS PERSONAS QUE ASISTIERON A LA FERIA
*/
    public function Visitantes_Agradecer_Visita ( $Registro, $Areas_Interes = array(), $Fecha_Visita, $Cargo, $Municipio ){

           $Empresa  = $Registro[0]['nomtercero'];
           $Contacto = $Registro[0]['contacto'];
           $Email    = $Registro[0]['email'];

           $this->Configurar_Cuenta('Agradecimiento Visita' );
           $Texto_Correo    = file_get_contents(BASE_EMAILS.'visitantes_agradecimiento_visita.phtml','r');
           $Texto_Correo    = str_replace("#_EMPRESA_#"        , $Empresa,$Texto_Correo);
           $Texto_Correo    = str_replace("#_CONTACTO_#"   , $Contacto , $Texto_Correo);
           $Texto_Correo    = str_replace("#_FECHA_VISITA_#"   , $Fecha_Visita , $Texto_Correo);
           $Texto_Correo    = str_replace("#_CARGO_#"   , $Cargo , $Texto_Correo);
           $Texto_Correo    = str_replace("#_MUNICIPIO_#"   , $Municipio , $Texto_Correo);

            $Tabla    = '';
            foreach ($Areas_Interes  as $Area) {
               $Tabla = $Tabla . "<ul>" ;
               $Tabla = $Tabla . "<li>" . trim( $Area['nomestilotrabajo'] )        . "</li>" ;
               $Tabla = $Tabla . '</ul>';
            }
            $Texto_Correo    = str_replace("#_TABLA_#"      ,  $Tabla       , $Texto_Correo);
            $this->Email->Body    = $this->Unir_Partes_Correo ( $Texto_Correo ) ;
            $this->Email->AddAddress( $Email);
            $Respuesta              = $this->Enviar_Correo();
            return $Respuesta ;
          }





    public function Invitacion_Clientes ($Empresa,$Contacto, $Cargo, $Email ){

           $this->Configurar_Cuenta('Invitación Andigráfica 2017/Cripack' );
           $Texto_Correo    = file_get_contents(BASE_EMAILS.'invitacion_ferias.phtml','r');
           $Texto_Correo    = str_replace("#_EMPRESA_#"   , $Empresa  ,$Texto_Correo);
           $Texto_Correo    = str_replace("#_CONTACTO_#"  , $Contacto ,$Texto_Correo);
           $Texto_Correo    = str_replace("#_CARGO_#"     , $Cargo    ,$Texto_Correo);
           $this->Email->Body    =  $Texto_Correo  ;
           $this->Email->AddAddress($Email);
           $Respuesta              = $this->Enviar_Correo();
           return $Respuesta ;
      }




/* MAYO 30 DE 2017
   ENVIA CORREO DE AGRADECIMIENTO PARA LAS PERSONAS QUE ASISTIERON A LA FERIA
   ----------------------------------------------------------------------------
*/
    public function Visitantes_Convertir_Cliente ( $Registro, $Areas_Interes = array(), $Fecha_Visita, $Cargo, $Municipio ){

           $Empresa  = $Registro[0]['nomtercero'];
           $Contacto = $Registro[0]['contacto'];
           $Email    = $Registro[0]['email'];

           $this->Configurar_Cuenta('Agradecimiento Visita' );
           $Texto_Correo    = file_get_contents(BASE_EMAILS.'visitantes_convertir_en_cliente.phtml','r');
           $Texto_Correo    = str_replace("#_EMPRESA_#"        , $Empresa,$Texto_Correo);
           $Texto_Correo    = str_replace("#_CONTACTO_#"   , $Contacto , $Texto_Correo);
           $Texto_Correo    = str_replace("#_FECHA_VISITA_#"   , $Fecha_Visita , $Texto_Correo);
           $Texto_Correo    = str_replace("#_CARGO_#"   , $Cargo , $Texto_Correo);
           $Texto_Correo    = str_replace("#_MUNICIPIO_#"   , $Municipio , $Texto_Correo);

            $Tabla    = '';
            foreach ($Areas_Interes  as $Area) {
               $Tabla = $Tabla . "<ul>" ;
               $Tabla = $Tabla . "<li>" . trim( $Area['nomestilotrabajo'] )        . "</li>" ;
               $Tabla = $Tabla . '</ul>';
            }
            $Texto_Correo    = str_replace("#_TABLA_#"      ,  $Tabla       , $Texto_Correo);


            $this->Email->Body    = $this->Unir_Partes_Correo ( $Texto_Correo ) ;

            $this->Email->AddAddress( $Email);
            $Respuesta              = $this->Enviar_Correo();
            return $Respuesta ;
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
        $this->Email->AddCC("serviclientes@cripack.com");
        $Respuesta              = $this->Enviar_Correo();
        return  $Respuesta;
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
       $Header             = file_get_contents(EMAILS . 'header.php','r');
       $Footer             = file_get_contents(EMAILS . 'footer.php','r');
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



