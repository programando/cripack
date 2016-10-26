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
        $this->Terceros            = $this->Load_Model('Terceros');
    }

    public function Index() { }


    public function Contacto() {
      $this->View->Mostrar_Vista('contactos');
    }



    public function estado_ordenes_trabajo (){
      /*  OCTUBRE 03 DE 2016
              CONSULTA Y MUESTRA EL ESTADO DE LAS ORDENES DE TRABAJO DEL UN CLIENTE. ES EL TABLERO DE PRODUCCIÓN
      */
          $idtercero                     = Session::Get('idtercero') ;
          //$idtercero                     = 668;
          $this->View->Ots               = $this->Terceros->Consulta_Tablero_Produccion( $idtercero ) ; // Paso 01 Conformación Tabla temporal

          $this->View->Ots               = $this->estado_ordenes_trabajo_ots_unicas ( $idtercero );
          $this->View->CantidadRegistros = $this->Terceros->Cantidad_Registros ;

         $this->View->Mostrar_Vista('tablero_produccion');
    }

    public function estado_ordenes_trabajo_ots_unicas( $idtercero  ) {

      $DatosTablero = array( array('numero_ot'=>0,'referencia'=>'', 'nomestilotrabajo'=>'','nomtipotrabajo'=>'',
                            'labor1'=>'', 'labor2'=>'', 'labor3'=>'', 'labor4'=>'', 'labor5'=>'',
                            'labor6'=>'', 'labor7'=>'', 'labor8'=>'', 'labor9'=>'', 'labor10'=>'',
                            'color1'=>'', 'color2'=>'', 'color3'=>'', 'color4'=>'', 'color5'=>'',
                            'color6'=>'', 'color7'=>'', 'color8'=>'', 'color9'=>'', 'color10'=>''

                             ));
      $Ots_Unicas   = $this->Terceros->Consulta_Tablero_Produccion_Ots_Unicas ( $idtercero  );
      $I            = 0;
      foreach  ($Ots_Unicas as $Ot_Unica ) {
          $DatosTablero[$I]['numero_ot']        = $Ot_Unica['numero_ot'];
          $DatosTablero[$I]['referencia']       = trim( $Ot_Unica['referencia']       );
          $DatosTablero[$I]['nomestilotrabajo'] = trim( $Ot_Unica['nomestilotrabajo'] );
          $DatosTablero[$I]['nomtipotrabajo']   = trim( $Ot_Unica['nomtipotrabajo'] );
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
            for ($K=$IdLabor; $K <=10 ; $K++) {
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
         $Email                = General_Functions::Validar_Entrada('email','TEXT');
         $Password             = General_Functions::Validar_Entrada('Password','TEXT');
         $Password             = md5($Password );
         $Registro             = $this->Terceros->Consulta_Datos_Por_Password_Email( $Password, $Email );

      	if (!$Registro ) {
           $Resultado_Logueo = "NO-Logueo_OK";
         }else {
              $Resultado_Logueo = "Logueo_OK";
              $Nombre=  explode(' ',$Registro[0]['nombre_usuario']);
              Session::Set('logueado',   TRUE);
              Session::Set('idtercero',        $Registro[0]['idtercero'] ) ;
              Session::Set('nomtercero',       $Registro[0]['nomtercero'] ) ;
              Session::Set('nombre_usuario',    $Nombre[0] ) ;
              Session::Set('uso_web_empresa',  $Registro[0]['uso_web_empresa'] ) ;
              Session::Set('identificacion',   $Registro[0]['identificacion'] ) ;
           }

           $Datos            = compact('Resultado_Logueo','Email');
           echo json_encode($Datos,256);
     }

		public function Historial() {
          $idtercero = Session::Get('idtercero') ;
         // $idtercero = 668;
          $this->View->Ots = $this->Terceros->Consulta_Trabajos_x_Tercero( $idtercero ) ;
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
        //$idtercero = 733;
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


   public function Cumplimiento_Entregas(){
      $IdTercero = Session::Get('idtercero');
      //$IdTercero = 733 ;
      $this->View->SetCss(array('chartist'));
      $Registro  = $this->Terceros->Cumplimiento_Entregas ( $IdTercero );
      $this->View->data = $Registro ;
      $this->View->Mostrar_Vista('cumplimiento_entregas');
   }




}?>

