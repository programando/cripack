<?php
		class TercerosModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}



					public function Consulta_Tablero_Produccion ( $idtercero )	{


						if ( empty ( $idtercero  )) {
									$idtercero                     = Session::Get('idtercero') ;
							}
						$Ots                = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_estado_procesos_labores_web_cliente( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}


					public function Consulta_Tablero_Produccion_Ots_Unicas ( $idtercero )	{
						$Ots                = $this->Db->Ejecutar_Sp("web_temp_tablero_paso_01_ots_unicas( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}

					public function Consulta_Tablero_Produccion_Labores_OT ( $Idregistro_Ot )	{
						$Ots                = $this->Db->Ejecutar_Sp("web_temp_tablero_paso_02_labores_por_ot( $Idregistro_Ot )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}



				public function Consulta_Datos_Por_Password_Email($password,$email)	{
						/** CONSULTA DATOS DEL USUARIO CON PASSWORD + EMAIL. DESDE EL LOGIN				*/
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_web_consulta_x_password_email('$password','$email')");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}


					public function Consulta_Trabajos_x_Tercero ( $idtercero )	{
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_web_consulta_trabajos_x_tercero( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}

					public function Buscar_Por_Identificacion ( $identificacion )	{
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_clientes_buscar_x_identificacion( '$identificacion' )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}

					public function Consulta_Emails ( $idtercero, $email )	{
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_web_consulta_email ( $idtercero, '$email' )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}

				public function Grabar_Registro ( $idtercero, $email, $password ){

						$SQL 							 = "$idtercero, '$email','$password'";
						$Registro    =  $this->Db->Ejecutar_Sp("terceros_web_grabar_registro ( ".$SQL.")");
				}


				public function Consulta_Remisiones ( $idtercero  ){
					 $Terceros                 = $this->Db->Ejecutar_Sp("remisiones_consulta_x_id_tercero ( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}

				public function Cumplimiento_Entregas ( $idtercero  ){
					 $Terceros                 = $this->Db->Ejecutar_Sp("ordenes_trabajo_reportes_cumplimiento_entregas_x_cliente_web ( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}






} ?>
