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
            $idtercero = 146 ;
            $this->View->Ots = $this->Terceros->Consulta_Trabajos_x_Tercero( $idtercero ) ;
		        $this->View->Mostrar_Vista('historial');

		    }



}

?>

