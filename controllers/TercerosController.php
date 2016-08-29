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
              Session::Set('logueado',   TRUE);
              Session::Set('idtercero',        $Registro[0]['idtercero'] ) ;
              Session::Set('nomtercero',       $Registro[0]['nomtercero'] ) ;
              Session::Set('uso_web_empresa',  $Registro[0]['uso_web_empresa'] ) ;
              Session::Set('identificacion',   $Registro[0]['identificacion'] ) ;
           }

           $Datos            = compact('Resultado_Logueo','Email');
           echo json_encode($Datos,256);
     }

		public function Historial() {
          $idtercero = Session::Get('idtercero') ;
         // $idtercero = 733;
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
      $IdTercero = 733 ;
      $Registro  = $this->Terceros->Cumplimiento_Entregas ( $IdTercero );

      $data = array(0 => 25, 1 => 35);

        /*$data = array(
                0 => round($enero['TOTAL'],1),
                1 => round($febrero['TOTAL'],1),
                2 => round($marzo['TOTAL'],1),
                3 => round($abril['TOTAL'],1),
                4 => round($mayo['TOTAL'],1),
                5 => round($junio['TOTAL'],1),
                6 => round($julio['TOTAL'],1),
                7 => round($agosto['TOTAL'],1),
                8 => round($septiembre['TOTAL'],1),
                9 => round($octubre['TOTAL'],1),
                10 => round($noviembre['TOTAL'],1),
                11 => round($diciembre['TOTAL'],1)
                );*/

      // echo json_encode($data);
        $this->View->data = $Registro ;
        $this->View->Mostrar_Vista('cumplimiento_entregas');
   }




}?>

