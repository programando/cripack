<?php
	/* AGOSTO 24 DE 2014
			Realiza la llamada a la vista correspondiente y traslada los parametros que necesita
			a Cada controlador el corresponde una vista. en el proyecto se encuentran dentro de carpetas
			La extensión de estas vistas es PHTML, dentro del rectorio views
	 */
class TercerosController extends Controller
{



    public function __construct()  {
        parent::__construct();
        $this->Terceros = $this->Load_Model('Terceros');
        $this->Emails   = $this->Load_Controller('Emails');
    }




  public function Pendientes_Produccion(){
    /*  NOV. 26 2016
          CONSULTA Y ENVIA CORREOS DE LAS OTS QUE ESTÁN EN PROCESO DE PRODUCCIÓN
          1. CONSULTA OT ( CREA TABLA TEMPORAL)         2. DEVUELVE CLIENTES
          3. SE CONSULTAN CONTACTOS                     4. SE CONSULTAN OTS PENDIENTES
          5. SE ENVÍAN CORREOS
    */
    $Clientes = $this->Terceros->Consulta_Ots_Pendientes_Produccion();
    foreach ($Clientes as $Cliente) {
        $idtercero = $Cliente['idtercero'];
        $cliente   = trim( $Cliente['nomtercero'] );
        $sucursal  = trim( $Cliente['nom_sucursal'] );
        $Contactos = $this->Terceros->Contactos_Por_IdTercero      ( $idtercero );
        $Ots       = $this->Terceros->Ots_Pendientes_Por_IdTercero ( $idtercero );
        $Destinatarios ='';
        foreach ($Contactos as $Contacto) {
          $email = trim( $Contacto['email']);
          if ( !empty($email )){
            $Destinatarios = $Destinatarios . $email .';';
          }
        }

        // ENVIAR CORREO AL TERCERO
        $this->Emails->Informe_Ots_Pendientes ( $cliente, $sucursal, $Destinatarios, $Ots  );

    }

  } // Pendientes_Produccion



  public function Recuperar_Password_Paso_01(){
         $email     = General_Functions::Validar_Entrada('Email','TEXT');
         $Es_email  = General_Functions::Validar_Entrada('Email','EMAIL');
         $Tercero   = $this->Terceros->Consulta_Datos_Por_Email($email);


          if ($Es_email  == false) {
              $CorreoEnviado ='Correo_No_OK';
            } else {
                if (!$Tercero) {
                         $CorreoEnviado ='NoUsuario';
                    }else{
                     $CorreoEnviado = $this->Emails->Recuperar_Password($email);
                     $idtercero     = $Tercero[0]['idtercero'];
                     if (  $CorreoEnviado =='Ok'){
                        $this->Terceros->Clave_Temporal_Grabar_Cambio_Clave($idtercero ,Session::Get('codigo_confirmacion'));
                        Session::Destroy('codigo_confirmacion');
                        }
                      }
                    }
       $Datos = compact('CorreoEnviado');
       echo  json_encode($Datos,256);
    }

    public function Reset_Password( $numero_confirmacion ) {

      $this->View->Verificacion_Token = FALSE ;
      $Token_Verificado = $this->Terceros->Verificar_Token_Cambio_Contrasenia( $numero_confirmacion );
      if ( !$Token_Verificado ){
        $this->View->Verificacion_Token = FALSE ;
      }else
        {
          $this->View->Verificacion_Token = TRUE ;
          $this->View->idtercero  = $Token_Verificado[0]['idtercero'];
        }

      $this->View->Numero_Confirmacion = $numero_confirmacion;

      $this->View->Mostrar_Vista('password_cambiar');

    }


  public function Password_Modificar(){
         $password     = General_Functions::Validar_Entrada('password','TEXT');
         $idtercero    = General_Functions::Validar_Entrada('idtercero','NUM');
         $password     = md5($password );
         if ( empty($password)){
            $PasswordCambiado ='No-Ok';
          }else{
                $this->Terceros->Password_Actualizar ( $idtercero,$password );
                $PasswordCambiado ='Ok';
       }

       $Datos = compact('PasswordCambiado');
       echo  json_encode($Datos,256);

    }





   public function Cumplimiento_Entregas($IdTercero = 0){
       if ( $IdTercero == 0 ){
            $IdTercero        = Session::Get('idtercero');
          }
      Session::Set('logueado', TRUE );
      Session::Set('Cliente', TRUE );
      $Registro         = $this->Terceros->Cumplimiento_Entregas ( $IdTercero );
      $Cumplimiento_0   = $Registro[0]['cumplimiento']   ;
      $Cumplimiento_1   = $Registro[1]['cumplimiento'];

      $this->View->Cumplimiento_0 = $Registro[0]['cumplimiento'];
      $this->View->Cumplimiento_1 = $Registro[1]['cumplimiento'];
      $this->View->Mostrar_Vista('cumplimiento_entregas');

   }




    public function Index() { }


    public function Contacto() {
      $this->View->Mostrar_Vista('contactos');
    }

    public function Visitantes_Convertir_Cliente (){
        $idregistro    = General_Functions::Validar_Entrada('idregistro','NUM');
        $Registro      = $this->Terceros->Visitantes_Agradecer_Visita ( $idregistro  );
        $IdTercero      = $Registro[0]['idtercero'];
        $Nom_Cargo     = $Registro[0]['nom_cargo'];
        $Municipio     = $Registro[0]['nommcipio'];
        $Fecha_Visita  = Fechas::Formato( $Registro[0]['fecha_registro'] );
        $Areas_Interes = $this->Terceros->Visitantes_Areas_Interes_Consultar ( $IdTercero);
        //ENVIAR CORREO AL TERCERO
        $RespuestaEmail = $this->Emails->Visitantes_Convertir_Cliente ( $Registro,$Areas_Interes,$Fecha_Visita,$Nom_Cargo, $Municipio     );
        if ( $RespuestaEmail == 'correo_OK'){
              $Registro      = $this->Terceros->Visitantes_Convertir_Cliente ( $idregistro  );
              echo "ok";}
              else {
                echo 'Nocorreo_OK';
              }

    }

    public function Visitantes_Agradecer_Visita(){
        $idregistro    = General_Functions::Validar_Entrada('idregistro','NUM');
        $Registro      = $this->Terceros->Visitantes_Agradecer_Visita ( $idregistro  );
        $IdTercero      = $Registro[0]['idtercero'];
        $Nom_Cargo     = $Registro[0]['nom_cargo'];
        $Municipio     = $Registro[0]['nommcipio'];
        $Fecha_Visita  = Fechas::Formato( $Registro[0]['fecha_registro'] );
        $Areas_Interes = $this->Terceros->Visitantes_Areas_Interes_Consultar ( $IdTercero );

        //ENVIAR CORREO AL TERCERO
       $Respuesta_Email = $this->Emails->Visitantes_Agradecer_Visita ( $Registro,$Areas_Interes,$Fecha_Visita,$Nom_Cargo, $Municipio     );
       //MARCAR REGISTRO COMO AGRADECIMIENTO ENVIADO
       if ($Respuesta_Email =='correo_OK') {
            $this->Terceros->Visitantes_Agradecer_Visita_Email_Enviado ( $idregistro   );
            echo 'correo_OK';
        }else{
          echo 'Nocorreo_OK';
        }

    }

    public function Eliminar_Registro_Visitante (){
        $idregistro  = General_Functions::Validar_Entrada('idregistro','NUM');
        $this->Terceros->Visitantes_Eliminar_Registro ( $idregistro  );
        echo "ok";
    }

    public function Listado_Visitantes (){
          $this->View->Visitantes = $this->Terceros->Visitantes_Listado();
          $this->View->Cantidad   = $this->Terceros->Cantidad_Registros;
          $this->View->Mostrar_Vista('registro_feria_listado');
    }

    public function Registro_Visitantes( $Identificacion = '') {

          $this->View->idtercero          = 0;
          $this->View->identificacion     = '';
          $this->View->nomtercero         = '';
          $this->View->cliente            = 0;
          $this->View->proveedor          = 0;
          $this->View->direccion          = '';
          $this->View->telefono           = '';
          $this->View->idmcipio           = 0;
          $this->View->nommcipio          = '';
          $this->View->idzona_ventas      = 0;
          $this->View->nombre_zona_ventas = '';
          $this->View->idtpdoc            = 0;
          $this->View->nomtpdoc           = '';
          $this->View->contacto           = '';
          $this->View->idarea             = 0;
          $this->View->nom_area           = '';
          $this->View->celular            = '';
          $this->View->email              = '';
          $this->View->idcargo_externo    = 0;
          $this->View->nom_cargo          = '';


      if ( !isset( $this->View->Tipos_Doc  )) { $this->View->Tipos_Doc    = $this->Terceros->Terceros_Tipos_Documentos(); }
      if ( !isset($this->View->Cargos) )      { $this->View->Cargos       = $this->Terceros->Terceros_Cargos_Externos();  }
      if ( !isset($this->View->AreasEmpresa)) { $this->View->AreasEmpresa = $this->Terceros->Terceros_Areas_Empresa();    }
      if ( !isset($this->View->Municipios))   { $this->View->Municipios   = $this->Terceros->Municipios();                }
      if ( !isset($this->View->Zona_Ventas) ) { $this->View->Zona_Ventas  = $this->Terceros->Zona_Ventas();               }
      if ( !isset($this->View->Estilos) )     { $this->View->Estilos      = $this->Terceros->Estilos_Trabajos();          }
      if ( !isset($this->View->Paises ) )     { $this->View->Paises       = $this->Terceros->Paises();          }
      if ( !isset($this->View->Asistentes_Ferias ) ){
            $this->View->Asistentes_Ferias       = $this->Terceros->Asistentes_Ferias();
          }
      if ( $Identificacion != null ) {
          $Registro = $this->Terceros->Buscar_Por_Identificacion ( $Identificacion  ) ;
          $this->View->idtercero          = $Registro[0]['idtercero'];
          $this->View->identificacion     = $Registro[0]['identificacion'];
          $this->View->nomtercero         = $Registro[0]['nomtercero'];
          $this->View->cliente            = $Registro[0]['cliente'];
          $this->View->proveedor          = $Registro[0]['proveedor'];
          $this->View->direccion          = $Registro[0]['direccion'];
          $this->View->telefono           = $Registro[0]['telefono'];
          $this->View->idmcipio           = $Registro[0]['idmcipio'];
          $this->View->nommcipio          = $Registro[0]['nommcipio'];
          $this->View->idzona_ventas      = $Registro[0]['idzona_ventas'];
          $this->View->nombre_zona_ventas = $Registro[0]['nombre_zona_ventas'];
          $this->View->idtpdoc            = $Registro[0]['idtpdoc'];
          $this->View->nomtpdoc           = $Registro[0]['nomtpdoc'];
          $Registro = $this->Terceros->Buscar_Primer_Contacto ( $this->View->idtercero ) ;
          if ( $Registro ) {
            $this->View->contacto        = $Registro[0]['contacto'];
            $this->View->idarea          = $Registro[0]['idarea'];
            $this->View->nom_area        = $Registro[0]['nom_area'];
            $this->View->celular         = $Registro[0]['celular'];
            $this->View->email           = $Registro[0]['email'];
            $this->View->idcargo_externo = $Registro[0]['idcargo_externo'];
            $this->View->nom_cargo       = $Registro[0]['nom_cargo'];
          }
      }

      $this->View->Mostrar_Vista('registro_feria');
    }


    public function Visitantes_Grabar_Datos(){
      /*  MAYO 25 2017
          REGISTRO BASICO DE CLIENTES DESDE UNA FERIA O EVENTO
      */
         $Respuesta = '';

         $identificacion  = General_Functions::Validar_Entrada('identificacion','TEXT');
         $idtpdoc        = General_Functions::Validar_Entrada('Tipo_Doc','TEXT');
         $nomtercero      = General_Functions::Validar_Entrada('nomtercero','TEXT');
         $cliente         = General_Functions::Validar_Entrada('cliente','BOL');
         $proveedor       = General_Functions::Validar_Entrada('proveedor','BOL');
         $direccion       = General_Functions::Validar_Entrada('direccion','TEXT');
         $telefono        = General_Functions::Validar_Entrada('telefono','TEXT');
         $idmcipio        = General_Functions::Validar_Entrada('idmcipio','NUM');
         $idpais          = General_Functions::Validar_Entrada('idpais','NUM');
         $idzona_ventas   = General_Functions::Validar_Entrada('idzona_ventas','NUM');
         $sector          = General_Functions::Validar_Entrada('sector','TEXT');
         $contacto        = General_Functions::Validar_Entrada('contacto','TEXT');
         $idcargo_externo = General_Functions::Validar_Entrada('idcargo_externo','NUM');
         $idarea          = General_Functions::Validar_Entrada('idarea','NUM');
         $celular         = General_Functions::Validar_Entrada('celular','TEXT');

         $email           = General_Functions::Validar_Entrada('email','TEXT-EMAIL');

         $Es_email        = General_Functions::Validar_Entrada('email','EMAIL');
         $atendido_por    = General_Functions::Validar_Entrada('atendido_por','TEXT');
         $observacion     = General_Functions::Validar_Entrada('observacion','TEXT');

        if ( isset($_POST["idestilotrabajo"]  )){
        $idestilotrabajo_array = $_POST["idestilotrabajo"]; // Lo recibo de esta manera porque es un select multiseleccion
      }else
      {
        $idestilotrabajo_array ='';
      }



         $clien_existe    = General_Functions::Validar_Entrada('clien_existe','BOL');
         $posible_clien   = General_Functions::Validar_Entrada('posible_clien','BOL');
         $informacion     = General_Functions::Validar_Entrada('informacion','BOL');
         $competencia     = General_Functions::Validar_Entrada('competencia','BOL');
         $entrega_tarj    = General_Functions::Validar_Entrada('entrega_tarj','BOL');




         $parametros = compact('identificacion','nomtercero','cliente','proveedor','contacto','Es_email','clien_existe','posible_clien','informacion','competencia');

         $Respuesta  = $this->Visitantes_Validar_Datos( $parametros ) ;


         if ( $Respuesta == '' ){
              $idvendedor                        = -1;
              $idformapago                       = 0;
              $codigo_tercero                    = '0';
              $dv                                = '';
              $nom_sucursal                      ='';
              $vendedor                          = 0;
              $fax                               ='';
              $certificado_calidad               = 0;
              $comision                          = 0;
              $vr_fletes                         = 0;
              $atencion                          ='';
              $cargo                             = '';
              $despacho                          = '';
              $instrucciones                     = '';
              $costo_financiero                  = 0 ;
              $transportador                     = 0;
              $cobros_contacto                   = '';
              $cobros_telefono                   = '';
              $empleado                          = 0;
              $cod_empleado                      = '';
              $aplica_extras                     = 0;
              $idcargo                           = 0;
              $salario                           = 0;
              $fecha_ingreso                     = '1900/01/01';
              $vr_hora                           = 0 ;
              $vr_incentivo                      = 0;
              $password_operario                 = '';
              $descarga_materiales               = 0;
              $factor_salario                    = 0;
              $factor_transporte                 = 0;
              $grupo_sanguineo                   = '';
              $inactivo                          = 0;
              $maquinas                          = '';
              $presupuestoventas                 = 0 ;
              $id_rgb                            = '';
              $incremento_ventas                 = 0;
              $comision_objetivo                 = 0;
              $id_lista_precio                   = 1; // Lista en blanco
              $cupo_credito                      = 0;
              $extra_cupo                        = 0;
              $cupo_pre_aprobado                 = 0;
              $dia_limite_recibe_facturas        = 0;
              $contacto_pagos                    = '';
              $contacto_pagos_email              = '';
              $contacto_pagos_celular            = '';
              $requiere_orden_compra             = 0;
              $discrimina_materiales_factura     = 0;
              $gran_contribuyente                = 0;
              $auto_retenedor                    = 0;
              $retenedor_iva                     = 0;
              $retenedor_renta                   = 0;
              $agrupa_facturacion_estilo_trabajo = 0;
              $horario_rbo_mercancia             = '';
              $dia_pago                          = 0;
              $idbanco                           = 0;
              $plazo                             = 0;
              $empleado_abrev                    = '';
              $codigo_postal                     = '';
              $bloqueado                         = 0;
              $ultimo_bloqueo                    = '1900/01/01';
              $dias_gracia                       = 0;
              $dia_informa_pagos                 = 0 ;
              $cod_cuenta_tcc                    = '';
              $alias                             = $nomtercero;
              $fecha_nacimiento                  = '1900/01/01';
              $prioridad_costeo                  = 0;
              $aplica_ferias                     = 0 ;
              $reg_ferias                        = 1;


          $Datos_Registro = compact('idmcipio' ,'idtpdoc' ,'idvendedor' ,'idformapago' ,'idpais' ,
                            'idzona_ventas' ,'codigo_tercero' ,'identificacion' ,'dv' ,'nomtercero' ,
                            'nom_sucursal' ,'cliente' ,'proveedor' ,'vendedor' ,'direccion' ,
                            'telefono' ,'fax' ,'contacto' ,'email' ,'certificado_calidad' ,
                            'comision' ,'vr_fletes' ,'atencion' ,'cargo' ,'despacho' ,
                            'celular' ,'instrucciones' ,'costo_financiero' ,'transportador' ,'cobros_contacto' ,
                            'cobros_telefono' ,'empleado' ,'cod_empleado' ,'aplica_extras' ,'idcargo' ,
                            'salario' ,'fecha_ingreso' ,'vr_hora' ,'vr_incentivo' ,'password_operario' ,
                            'descarga_materiales' ,'factor_salario' ,'factor_transporte' ,'grupo_sanguineo' ,'inactivo' ,
                            'maquinas' ,'presupuestoventas' ,'id_rgb' ,'incremento_ventas' ,'comision_objetivo' ,
                            'id_lista_precio' ,'cupo_credito' ,'extra_cupo' ,'cupo_pre_aprobado' ,'dia_limite_recibe_facturas' ,
                            'contacto_pagos' ,'contacto_pagos_email' ,'contacto_pagos_celular' ,'requiere_orden_compra' ,'discrimina_materiales_factura' ,'gran_contribuyente' ,'auto_retenedor' ,'retenedor_iva' ,'retenedor_renta' ,'agrupa_facturacion_estilo_trabajo' ,  'idcargo_externo' ,'idarea' ,'horario_rbo_mercancia' ,'dia_pago' ,'idbanco' ,'plazo' ,'empleado_abrev' ,'codigo_postal' ,
                             'bloqueado' ,'ultimo_bloqueo' ,
                            'dias_gracia' ,'dia_informa_pagos' ,'cod_cuenta_tcc' ,'alias' ,'fecha_nacimiento' ,
                            'prioridad_costeo' ,'aplica_ferias' ,'reg_ferias' );


            $Registro = $this->Terceros->Visitantes_Grabar_Datos ( $Datos_Registro );
            $Respuesta ='Todo-Ok';
            if ( $Registro ){
                // GRABAR DATOS COMPLEMENTARIOS
                //-----------------------------
               $idtercero = $Registro [0]['idtercero'];
               $idestilotrabajo = 0 ;
               $Datos_Registro = compact('idtercero','idestilotrabajo','clien_existe','posible_clien','informacion','competencia','entrega_tarj','atendido_por','observacion' );
                 $this->Terceros->Visitantes_Grabar_Otros_Datos( $Datos_Registro );
                 if ( is_array( $idestilotrabajo_array )) {
                    $this->Visitantes_Areas_Interes_Grabar( $idtercero , $idestilotrabajo_array );
                  }
            }else {
               $Respuesta ='Todo-No-Ok';
            }

         }

        $Respuesta  = compact('Respuesta');
        echo json_encode($Respuesta,256);
    }

      private function Visitantes_Areas_Interes_Grabar ($idtercero, $idestilotrabajo = array() ) {
          $Texto_SQL         = "INSERT INTO terceros_visitantes_ferias_estilos_interes (idtercero,idestilotrabajo) VAlUES  ";
          $Valores ='';
          $Datos = '';
          for ($i=0;  $i < count($idestilotrabajo); $i++)  {
            $Valores           = $idtercero .',' .$idestilotrabajo[$i];
            $Valores           = '( ' . $Valores . ' ),';
            $Datos             = $Datos . $Valores ;
          }
          $Texto_SQL = $Texto_SQL . $Datos;
          $Texto_SQL = substr($Texto_SQL, 0, strlen($Texto_SQL)-1);
          $this->Terceros->Visitantes_Areas_Interes_Grabar ( $Texto_SQL );
      }


     public function  Listado_General(){
        $this->View->Terceros = $this->Terceros->Listado_General();
        $this->View->Mostrar_Vista('listado_general');
     }

      public function Invitacion_Clientes(){

        $idtercero = General_Functions::Validar_Entrada('idtercero','NUM');
        $empresa   = General_Functions::Validar_Entrada('empresa','TEXT');
        $contacto  = General_Functions::Validar_Entrada('contacto','TEXT');
        $nom_cargo = General_Functions::Validar_Entrada('nom_cargo','TEXT');
        $email     = General_Functions::Validar_Entrada('email','TEXT-EMAIL');
       //MARCAR REGISTRO COMO AGRADECIMIENTO ENVIADO
       $RespuestaEmail = $this->Emails->Invitacion_Clientes ( $empresa, $contacto , $nom_cargo, $email );
       if ( $RespuestaEmail == 'correo_OK' ){
          echo "correo_OK";
       }else {
          echo "NOcorreo_OK";
       }


      }

      public function Visitantes_Areas_Interes_Consultar( ){

      /* $idtercero = General_Functions::Validar_Entrada('idtercero','NUM');
       Session::Destroy('MyVar');
       Session::Set('MyVar', $idtercero);
       $Respuesta  = compact('idtercero');
       echo json_encode($Respuesta,256);
       **/



    }

    private function Visitantes_Validar_Datos( $Parametros =array()){
      $Texto = '';

      extract( $Parametros );


      if ( strlen($identificacion) == 0 ) {
          $Texto = 'La identificación no puede estar en blanco.'.'<br>' ;
        }

      if ( strlen($nomtercero) == 0 )     {
          $Texto  = $Texto. 'Especifique el nombre de la persona o empresa'. '<br>' ;
        }

      if ( $cliente == FALSE && $proveedor == FALSE ) {
          $Texto  = $Texto. 'Debe indicar si los datos que registra son de un cliente o proveedor.'. '<br>' ;
      }

      if ( strlen($contacto) == 0 )     {
          $Texto  = $Texto. 'Registre un nombre de contacto.'. '<br>' ;
          }

      if ( $Es_email == FALSE )     {
          $Texto  = $Texto. 'La dirección de correo no tiene un formato válido.'. '<br>' ;
        }

      if ( $clien_existe == FALSE && $posible_clien == FALSE && $informacion == FALSE && $competencia == FALSE ) {
          $Texto  = $Texto. 'Debe especificar si el registro corresponde a: CE , CP, IN, CO'. '<br>' ;
      }


      return $Texto;
    }



    public function estado_ordenes_trabajo ($idtercero = 0){
      /*  OCTUBRE 03 DE 2016
              CONSULTA Y MUESTRA EL ESTADO DE LAS ORDENES DE TRABAJO DEL UN CLIENTE. ES EL TABLERO DE PRODUCCIÓN
      */

          if ( $idtercero  == 0 ){
            $idtercero                     = Session::Get('idtercero') ;
          }

          if ( Session::Get('cuenta_cripack') === TRUE ){
              $this->View->Ots               = $this->Terceros->Consulta_Tablero_Produccion_Ferias_Eventos() ; // Paso 01
            }else{
              $this->View->Ots               = $this->Terceros->Consulta_Tablero_Produccion( $idtercero ) ; // Paso 01 Conformación Tabla temporal
            }
          $this->View->Ots               = $this->estado_ordenes_trabajo_ots_unicas ( $idtercero );
          $this->View->CantidadRegistros = $this->Terceros->Cantidad_Registros ;
          $this->View->Mostrar_Vista('tablero_produccion');
    }

    public function estado_ordenes_trabajo_ots_unicas( $idtercero  ) {

      $DatosTablero = array( array('numero_ot'=>0,'referencia'=>'', 'nomestilotrabajo'=>'','nomtipotrabajo'=>'',
                            'labor1'=>'', 'labor2'=>'', 'labor3'=>'', 'labor4'=>'', 'labor5'=>'',
                            'labor6'=>'', 'labor7'=>'', 'labor8'=>'', 'labor9'=>'', 'labor10'=>'',
                            'color1'=>'', 'color2'=>'', 'color3'=>'', 'color4'=>'', 'color5'=>'',
                            'color6'=>'', 'color7'=>'', 'color8'=>'', 'color9'=>'', 'color10'=>'',
                             'fecha_confirmada'=>''
                             ));
      if ( Session::Get('cuenta_cripack') === TRUE ){
          $Ots_Unicas   = $this->Terceros->Consulta_Tablero_Produccion_Ots_Unicas_Ferias_Eventos ( );
        }else{
          $Ots_Unicas   = $this->Terceros->Consulta_Tablero_Produccion_Ots_Unicas ( $idtercero  );
        }

      $I            = 0;
      foreach  ($Ots_Unicas as $Ot_Unica ) {
          $DatosTablero[$I]['numero_ot']        = $Ot_Unica['numero_ot'];
          $DatosTablero[$I]['referencia']       = trim( $Ot_Unica['referencia']       );
          $DatosTablero[$I]['nomestilotrabajo'] = trim( $Ot_Unica['nomestilotrabajo'] );
          $DatosTablero[$I]['nomtipotrabajo']   = trim( $Ot_Unica['nomtipotrabajo'] );
          $DatosTablero[$I]['fecha_confirmada'] = Fechas::Formato( $Ot_Unica['fecha_confirmada']) ;
          //CONSULTA LAS LABORES DE LA OT
          //-------------------------------
          $IdLabor = 1;
          $Labores = $this->Terceros->Consulta_Tablero_Produccion_Labores_OT( $Ot_Unica['idregistro_ot'] ) ;
          foreach ($Labores  as $Labor) {
              $Anio_Inicio = $Labor['anio_inicio'];
              $Anio_Final  = $Labor['anio_final'];
              $IdInactiva  = $Labor['id_motivo_inactiva_ot'];

              $DatosTablero[$I]["labor$IdLabor"] = $Labor['nomlabor'];

              if ( $Anio_Inicio > 0 && $Anio_Final > 0){
                $DatosTablero[$I]["color$IdLabor"] = 'VERDE';
              }
              if ( $Anio_Inicio == 0 && $Anio_Final == 0){
                $DatosTablero[$I]["color$IdLabor"] = 'AZUL';
              }
              if ( $Anio_Inicio > 0 && $Anio_Final == 0){
                $DatosTablero[$I]["color$IdLabor"] = 'AMARILLO';
              }
              if ( $IdInactiva !=0 && $IdInactiva != 7 ){
                $DatosTablero[$I]["color$IdLabor"] = 'ROJO';
              }
              $IdLabor ++;
          }// Fin For Each Labores
          if ( $IdLabor < 11 )  {
            $IdLabor = $IdLabor-1;
            for ( $K=$IdLabor; $K <=10 ; $K++ ) {
               $DatosTablero[$I]["labor$K"] = '';
               $DatosTablero[$I]["color$K"] = '';
            }
          }

        $I++;
      }

      return $DatosTablero;
    }




   public function Ingreso_Sistema_Validaciones(){

      	 Session::Set('logueado',   FALSE);
         $Email                = General_Functions::Validar_Entrada('email','TEXT-EMAIL');
         $Password             = General_Functions::Validar_Entrada('Password','TEXT');
         $Password             = md5($Password );
         $Registro             = $this->Terceros->Consulta_Datos_Por_Password_Email( $Password, $Email );

      	if (!$Registro ) {
           $Resultado_Logueo = "NO-Logueo_OK";
         }else {
              $Resultado_Logueo = "Logueo_OK";
              $Nombre           =  explode(' ',$Registro[0]['nombre_usuario']);
              Session::Set('logueado',   TRUE);
              Session::Set('idtercero',        $Registro[0]['idtercero'] ) ;
              Session::Set('nomtercero',       $Registro[0]['nomtercero'] ) ;
              Session::Set('nombre_usuario',    $Nombre[0] ) ;
              Session::Set('uso_web_empresa',  $Registro[0]['uso_web_empresa'] ) ;
              Session::Set('identificacion',   $Registro[0]['identificacion'] ) ;
              Session::Set('proveedor'      ,   $Registro[0]['proveedor'] ) ;
              Session::Set('Cliente'      ,   $Registro[0]['cliente'] ) ;
              Session::Set('email'        , $Email);

             Session::Set('cuenta_cripack'        , FALSE);
               $Email_Cripack = strpos($Email,'cripack');
              if ( $Email_Cripack > 0 ){
                Session::Set('cuenta_cripack'        , TRUE);
              }

           }

           $Datos            = compact('Resultado_Logueo','Email');
           echo json_encode($Datos,256);

     }

		public function Historial($idtercero = 0) {
          if ( $idtercero == 0 ) {
            $idtercero = Session::Get('idtercero') ;
          }
          //Session::Set('logueado', TRUE );
          //Session::Set('Cliente', TRUE );
          if ( Session::Get('cuenta_cripack') === TRUE ){
            $this->View->Ots               = $this->Terceros->Consulta_Trabajos_Ferias_Eventos( ) ;
          }else{
            $this->View->Ots               = $this->Terceros->Consulta_Trabajos_x_Tercero( $idtercero ) ;
          }


          $this->View->CantidadRegistros =  $this->Terceros->Cantidad_Registros ;
	        $this->View->Mostrar_Vista('historial');
	    }





    public function Buscar_Por_Identificacion() {
          $Respuesta = '';
          $identificacion                = General_Functions::Validar_Entrada('identificacion','TEXT');
          Session::Set('nomtercero',      '' );
          if ( empty( $identificacion  ) ){
            $Respuesta ='La identificación no puede estar en blanco.' ;
          }
          $Registro = $this->Terceros->Buscar_Por_Identificacion ( $identificacion  ) ;
          if ( $Registro && !empty( $identificacion  )){
            Session::Set('idtercero',       $Registro[0]['idtercero']) ;
            Session::Set('identificacion',  $identificacion );
            Session::Set('nomtercero',      $Registro[0]['nomtercero'] );
            $Respuesta ='IdentificacionExiste';
          }
          $nomtercero = Session::Get('nomtercero');
          $Datos      = compact('Respuesta','nomtercero');
          echo json_encode($Datos,256);
      }

    public function Consultar_Emails(){
          $Respuesta = '';
          $idtercero = Session::Get('idtercero');
          $email                = General_Functions::Validar_Entrada('email','TEXT');
          $Registro = $this->Terceros->Consulta_Emails ( $idtercero, $email );
          if ( !$Registro ){
            $Respuesta ='Email-No-Existe';
          }
          if ( $Registro && $Registro[0]['email_registrado'] != 'NO' ){
              $Respuesta ='Email-Ya-Registrado';
          }
          if ( $Registro && $Registro[0]['email_registrado'] == 'NO' ){
               $Respuesta ='Email-Ok';
               Session::Set('idtercero',$Registro[0]['idtercero'] ) ;
          }
          $Datos            = compact('Respuesta');
          echo json_encode($Datos,256);
    }

    public function Grabar_Registro(){
          $idtercero = Session::Get('idtercero');
          $email     = General_Functions::Validar_Entrada('email','TEXT');
          $password  = General_Functions::Validar_Entrada('password','TEXT');
          $password  = md5($password );
          $Registro  = $this->Terceros->Grabar_Registro ( $idtercero, $email, $password );
          $Respuesta = 'RegistroGrabado';
          $Datos     = compact('Respuesta');
          echo json_encode($Datos,256);
    }



   public function consulta_remisiones () {

        $idtercero = Session::Get('idtercero');
        $Registro  = $this->Terceros->Consulta_Remisiones ( $idtercero);

        $IdRemision = 0;
        $I          = 0;

       $DatosUnicos = array(array('idremision'      =>  0,
                                   'nro_remision'   =>  0,
                                   'fecha_remision' =>  '',
                                   'nro_guia'       =>  0,
                                   'observaciones'  =>  0));

        if ( $this->Terceros->Cantidad_Registros > 0){
           $IdRemision                        = $Registro [0]['idremision'];
           $DatosUnicos[$I]['idremision']     = $Registro [0]['idremision'];
           $DatosUnicos[$I]['nro_remision']   = $Registro [0]['nro_remision'];
           $DatosUnicos[$I]['fecha_remision'] = $Registro [0]['fecha_remision'];
           $DatosUnicos[$I]['nro_guia']       = $Registro [0]['nro_guia'];
           $DatosUnicos[$I]['observaciones']  = $Registro [0]['observaciones'];
           $I++;

            foreach ($Registro as $Dato  ) {
                if ( $IdRemision != $Dato['idremision'] ) {
                 $DatosUnicos[$I]['idremision']     = $Dato['idremision'];
                 $IdRemision                        = $Dato['idremision'] ;
                 $DatosUnicos[$I]['nro_remision']   = $Dato['nro_remision'];
                 $DatosUnicos[$I]['fecha_remision'] = $Dato['fecha_remision'];
                 $DatosUnicos[$I]['nro_guia']       = $Dato['nro_guia'];
                 $DatosUnicos[$I]['observaciones']  = $Dato['observaciones'];
                 $I++;
                }
            }
        }
        $this->View->CantidadRegistros = $this->Terceros->Cantidad_Registros ;
        $this->View->Datos_Unicos      = $DatosUnicos;
        $this->View->Remisiones        = $Registro;
        $this->View->Mostrar_Vista('remisiones');


   } // Fin Consulta_Remsiones





   public function Maquinas($IdTercero = 0){
     if ( $IdTercero  == 0 ){
        $IdTercero                     = Session::Get('idtercero');
      }
      Session::Set('Cliente', FALSE ) ;
       //$IdTercero                     = 143 ;
       $Registro                      = $this->Terceros->Proveedores_Consulta_Mantenimientos_Pendientes ( $IdTercero );
       $this->View->CantidadRegistros = $this->Terceros->Cantidad_Registros ;
       $this->View->Servicios          = $Registro ;
       $this->View->Mostrar_Vista('mantenimientos_listado');

   }

   public function Responder_reporte( $idregistro ){

      $Registro                  = $this->Terceros->Proveedores_Mantenimientos_Consulta_Observaciones( $idregistro );
      $this->View->Observaciones = $Registro[0]['descripcion_trabajo'];
      $this->View->IdRegistro    = $idregistro  ;
      $this->View->Mostrar_Vista('mantenimientos_registro');
   }

   public function Mantenimiento_Actualizar(){
       $solucion      = General_Functions::Validar_Entrada('Solucion','TEXT');
       $pasos         = General_Functions::Validar_Entrada('Pasos','TEXT');
       $observaciones = General_Functions::Validar_Entrada('Observaciones','TEXT');
       $idregistro    = General_Functions::Validar_Entrada('idregistro','NUM');
       $idtercero     = Session::Get('idtercero');

        $solucion      = strtoupper(  $solucion );
        $pasos         = strtoupper(  $pasos );
        $observaciones = strtoupper(  $observaciones );


       if ( strlen( $solucion ) > 0 ){
          $Paso_1     = substr($pasos,0,249);
          $Paso_2     = substr($pasos,249,249);
          $Paso_3     = substr($pasos,500,249);
          $Paso_4     = substr($pasos,750,249);
          $Paso_5     = substr($pasos,1000,249);

          $Datos = Compact('idregistro','solucion','observaciones','Paso_1','Paso_2','Paso_3','Paso_4','Paso_5','idtercero');
          $this->Terceros->Proveedores_Mantenimientos_Actualizar_Respuesta( $Datos );
          echo "OK";
       }else{
        echo "NO-OK";
       }



   }

}?>

