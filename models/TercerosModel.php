<?php
		class TercerosModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}



				public function Clave_Temporal_Grabar_Cambio_Clave($idtercero, $password_temporal){
				/** ENERO 24 DE 2017
        **  INSERTA EN LA TABLA UN REGISTRO TEMPORAL QUE SE USARÁ PARA LA VERIFICACIÓN EN EL CAMBIO DE CLAVE
        **		NOTA:  EN ESTE CASO NO ES NECESARIO idtercero ni plan de compras.
        */
					 $this->Db->Ejecutar_Sp("terceros_web_passwords_temporales_registro($idtercero ,'$password_temporal')");
				}

				public function Password_Actualizar($idtercero, $password)	{
					 $Terceros = $this->Db->Ejecutar_Sp("terceros_web_passwords_actualizar ($idtercero ,'$password') ");
				}


			public function Verificar_Token_Cambio_Contrasenia( $Numero_Confirmacion )	{
						/** ENERO 31DE 2014
								 CONSULTA DATOS DEL USUARIO CON  EMAIL. DESDE EL LOGIN				*/

						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_web_passwords_temporales_verificar('$Numero_Confirmacion')");
						return $Terceros;
				}


				public function Consulta_Datos_Por_Email($email)	{
						/** ENERO 31DE 2014
								 CONSULTA DATOS DEL USUARIO CON  EMAIL. DESDE EL LOGIN				*/
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_consulta_datos_x_email('$email')");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;

						return $Terceros;
				}

				public function Ots_Pendientes_Por_IdTercero( $IdTercero ) {
						$Ots                = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_pendientes_descarga_x_idtercero ( $IdTercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}

				public function Consulta_Ots_Pendientes_Produccion(){
							$Ots                = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_pendientes_descarga");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}


				public function Contactos_Por_IdTercero ( $IdTercero ){
						$Contactos                = $this->Db->Ejecutar_Sp("terceros_contactos_consultar_por_tercero ($IdTercero ) ");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Contactos;


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


				public function Proveedores_Consulta_Mantenimientos_Pendientes ( $Idtercero_Proveedor  ){
					 $Terceros                 = $this->Db->Ejecutar_Sp("mantenimiento_registro_consultar_x_proveedor ( $Idtercero_Proveedor )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}


				public function Proveedores_Mantenimientos_Consulta_Observaciones ( $idregistro  ){
					 $Registro                 = $this->Db->Ejecutar_Sp("mantenimiento_registro_consulta_observaciones ( $idregistro )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registro;
				}


				public function  Proveedores_Mantenimientos_Actualizar_Respuesta ($Datos=Array() ){
						extract( $Datos );
						$SQL = "$idregistro, '$solucion','$observaciones', '$Paso_1', '$Paso_2','$Paso_3','$Paso_4','$Paso_5',$idtercero";
						$Registro    =  $this->Db->Ejecutar_Sp("mantenimiento_registro_actualizar_respuesta(".$SQL.")");
				}


} ?>
