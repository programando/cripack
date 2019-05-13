<?php
		class TercerosModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}

       public function OtBitacoraMovimientoDiario(){
           $this->Db->Ejecutar_Sp("btcra_mvto_ots_registro_11_pm()");
        }

       public function OtBloquedasDibujoEnAprobacion_01_Clientes(){
            $Registro                 = $this->Db->Ejecutar_Sp("ord_trab_bloqueadas_dib_x_aprobacion_01_clientes_bloqueados()");
            return $Registro;
        }

        public function OtBloquedasDibujoEnAprobacion_02_Emails( $IdTercero ){
            $Registro                 = $this->Db->Ejecutar_Sp("ord_trab_bloqueadas_dib_x_aprobacion_02_emails_contactos( $IdTercero )");
            return $Registro;
        }

        public function OtBloquedasDibujoEnAprobacion_03_OTs( $IdTercero ){
            $Registro                 = $this->Db->Ejecutar_Sp("ord_trab_bloqueadas_dib_x_aprobacion_03_ots( $IdTercero )");
            return $Registro;
        }


        public function Bloqueados(){
            $Registro                 = $this->Db->Ejecutar_Sp("terceros_bloqueados_listado()");
            return $Registro;
        }

        public function Bloqueados_Contactos_Cartera ( $idtercero  ) {
              $Registro         = $this->Db->Ejecutar_Sp("terceros_bloqueados_contactos_cartera( $idtercero )");
              return  $Registro;
        }




				public function BorrarPqr( $IdPqr ){
					$Registro                 = $this->Db->Ejecutar_Sp("pqr_emails_terceros_borrar( $IdPqr )");
				}
				public function InformarPqr(){
					$Registro                 = $this->Db->Ejecutar_Sp("pqr_emails_terceros_listar()");
						return $Registro;
				}

        public function RemisionesIntegracionTcc(){
          $Registro                 =  $this->Db->Ejecutar_Sp("remisiones_despachos_integrar_ws_tcc()");
           return $Registro;
        }

        public function RemisionesIntegracionTccUpdNroRemesa ( $idregistro ,$respuesta ,$nro_rmsa_tcc, $codbarra){
            $Registro    = $this->Db->Ejecutar_Sp("remisiones_despachos_integrar_ws_upd_nro_remesa( $idregistro,'$respuesta', $nro_rmsa_tcc,'$codbarra'  )");
        }


				public function RemisionesPorConfirmarFechaEntrega(){
					$Registro                 = $this->Db->Ejecutar_Sp("remisiones_x_confirmar_fecha_entrega()");
						return $Registro;
				}


				public function RemisionesPorConfirmarActualizaDatos ( $idremision ,$idregistro_ot ,$fecha_cumplido){
						$Registro                 = $this->Db->Ejecutar_Sp("remisiones_x_confirmar_upd_datos( $idremision,$idregistro_ot, '$fecha_cumplido'  )");
						return $Registro;
				}


				public function Ventas_x_Cliente_x_Fechas ($fecha_ini, $fecha_fin, $idtercero ){
						$Registro                 = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_facturadas_por_fechas_x_cliente( '$fecha_ini','$fecha_fin',$idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registro;
				}

				public function Visitantes_Grabar_Datos( $Parametros = array() ){
					extract( $Parametros );
					$alias = substr($alias, 0,29);
					$SQL = "$idmcipio ,$idtpdoc ,$idvendedor ,$idformapago ,$idpais ,$idzona_ventas ,$codigo_tercero ,'$identificacion' ,'$dv' ,'$nomtercero' ,'$nom_sucursal' ,$cliente ,$proveedor ,$vendedor ,'$direccion' ,'$telefono' ,'$fax' ,'$contacto' ,'$email' ,$certificado_calidad ,$comision ,$vr_fletes ,'$atencion' ,'$cargo' ,'$despacho' ,'$celular' ,'$instrucciones' ,$costo_financiero ,$transportador ,'$cobros_contacto' ,'$cobros_telefono' ,$empleado ,'$cod_empleado' ,$aplica_extras ,$idcargo ,$salario ,'$fecha_ingreso' ,$vr_hora ,$vr_incentivo ,'$password_operario' ,$descarga_materiales ,$factor_salario ,$factor_transporte ,'$grupo_sanguineo' ,$inactivo ,'$maquinas' ,$presupuestoventas ,'$id_rgb' ,$incremento_ventas ,$comision_objetivo ,$id_lista_precio ,$cupo_credito ,$extra_cupo ,$cupo_pre_aprobado ,$dia_limite_recibe_facturas ,'$contacto_pagos' ,'$contacto_pagos_email' ,'$contacto_pagos_celular' ,$requiere_orden_compra ,$discrimina_materiales_factura ,$gran_contribuyente ,$auto_retenedor ,$retenedor_iva ,$retenedor_renta ,$agrupa_facturacion_estilo_trabajo ,$idcargo_externo ,$idarea ,'$horario_rbo_mercancia' ,'$dia_pago' ,$idbanco ,$plazo ,'$empleado_abrev' ,'$codigo_postal' ,$bloqueado ,'$ultimo_bloqueo' ,$dias_gracia ,$dia_informa_pagos ,'$cod_cuenta_tcc' ,'$alias' ,'$fecha_nacimiento' ,$prioridad_costeo ,$aplica_ferias ,$reg_ferias  ";
					//Debug::Mostrar($SQL  );
						$Registro    =  $this->Db->Ejecutar_Sp("terceros_crear_registro_feria(".$SQL.")");
						return $Registro;
				}

		 	public function Visitantes_Grabar_Otros_Datos( $Parametros = array() ){
						extract( $Parametros );
						$SQL = "$idtercero ,$idestilotrabajo ,$ce ,$cp ,$inf ,$co ,$tj ,'$atendido_por' ,'$observacion' ,'$quien_visita' ,'$contactar_por' ,'$contacto' ,$idcargo_externo ,$idarea ,'$celular',$otro ";

						$Registro    =  $this->Db->Ejecutar_Sp("terceros_crear_registro_feria_otros_datos(".$SQL.")");
				}


				public function Listado_General_Contactos(){
						$Registro                 = $this->Db->Ejecutar_Sp("terceros_listado_general_web_contactos()");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registro;
				}
				public function Listado_General_Clientes(){
						$Registro                 = $this->Db->Ejecutar_Sp("terceros_listado_general_web_clientes()");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registro;
				}


				public function Visitantes_Listado () {
						$Registro                 = $this->Db->Ejecutar_Sp("terceros_registro_feria_listado()");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registro;
				}

				public function Visitantes_Eliminar_Registro ( $idregistro  ) {
						$Registro                 = $this->Db->Ejecutar_Sp("terceros_registro_feria_eliminar( $idregistro )");
				}

				public function Visitantes_Agradecer_Visita( $idregistro  ) {
							$Registro                 = $this->Db->Ejecutar_Sp("terceros_registro_feria_agradecimiento_visita( $idregistro )");
							return 	$Registro;
				}


				public function Buscar_Primer_Contacto( $idtercero  ) {
							$Registro         = $this->Db->Ejecutar_Sp("terceros_clientes_contacto( $idtercero )");
							return 	$Registro;
				}

				public function Visitantes_Agradecer_Visita_Email_Enviado( $idregistro  ) {
							$Registro   = $this->Db->Ejecutar_Sp("terceros_registro_feria_agradecimiento_email_enviado( $idregistro )");
				}

 		public function Visitantes_Areas_Interes_Grabar( $texto_sql )		{
 				$Registro = $this->Db->Ejecutar_SQL( $texto_sql );
 		}


				public function Visitantes_Areas_Interes_Consultar ( $idtercero  ) {
							$Registro   = $this->Db->Ejecutar_Sp("terceros_registro_feria_consulta_areas_interes_x_cliente( $idtercero )");
							return $Registro ;
				}


				public function Visitantes_Convertir_Cliente ( $idregistro  ) {
							$Registro   = $this->Db->Ejecutar_Sp("terceros_registro_feria_cliente_confirmado( $idregistro )");
				}


				public function Asistentes_Ferias(){
							$Registro   = $this->Db->Ejecutar_Sp("terceros_asistentes_ferias(  )");
							return $Registro ;
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

				public function Clientes_Bloqueados(){
						 $Ots                = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_pendientes_descarga");
							$Ots                = $this->Db->Ejecutar_Sp("web_msj_bloq_cli_listado_bloqueados");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}

				public function Clientes_Bloqueados_Contactos( $IdTercero ) {
						$Ots                = $this->Db->Ejecutar_Sp("web_msj_bloq_cli_contactos_x_idtercero ( $IdTercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}

				public function Clientes_Bloqueados_Borrar_Notificacion( $Email ) {
						$Ots    = $this->Db->Ejecutar_Sp("web_msj_bloq_cli_borrar_x_email ( '$Email' )");
						return $Ots;
				}

				public function Contactos_Por_IdTercero ( $IdTercero ){
						$Contactos                = $this->Db->Ejecutar_Sp("terceros_contactos_consultar_por_tercero ($IdTercero ) ");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Contactos;


				}
          public function Consulta_Tablero_Produccion_Cartonera ( )  {

            $Ots                = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_estado_procesos_labores_web_cartonera( )");
            $this->Cantidad_Registros = $this->Db->Cantidad_Registros;
            return $Ots;
         }


					public function Consulta_Tablero_Produccion ( $idtercero )	{
						if ( empty ( $idtercero  )) {
									$idtercero                     = Session::Get('idtercero') ;
							}
						$Ots                = $this->Db->Ejecutar_Sp("ordenes_trabajo_consulta_estado_procesos_labores_web_cliente( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				 }

					public function Consulta_Tablero_Produccion_Ferias_Eventos (  )	{

						$Ots                = $this->Db->Ejecutar_Sp("ferias_eventos_ot_consulta_estado_procesos_labores_web()");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}



					public function Consulta_Tablero_Produccion_Ots_Unicas ( $idtercero )	{
						$Ots                = $this->Db->Ejecutar_Sp("web_temp_tablero_paso_01_ots_unicas( $idtercero )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Ots;
				}

					public function Consulta_Tablero_Produccion_Ots_Unicas_Ferias_Eventos (  )	{
						$Ots                = $this->Db->Ejecutar_Sp("ferias_eventos_web_temp_tablero_paso_01_ots_unicas()");
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

				public function Consulta_Trabajos_Ferias_Eventos (  )	{
						$Terceros                 = $this->Db->Ejecutar_Sp("ferias_eventos_consulta_trabajos()");
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

				public function  Terceros_Tipos_Documentos ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("tipos_documentos_listado_activos_no_kardex()");
						return $Registro;
				}

				public function  Terceros_Cargos_Externos ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("terceros_cargos_externos_listado_activos()");
						return $Registro;
				}

				public function  Terceros_Areas_Empresa ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("terceros_areas_empresa_listado_activas()");
						return $Registro;
				}
				public function  Municipios ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("municipios_listado_general()");
						return $Registro;
				}

				public function  Zona_Ventas ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("zonas_ventas_listado_activos()");
						return $Registro;
				}

				public function  Estilos_Trabajos ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("estilos_trabajos_consultar_activos_ferias()");
						return $Registro;
				}

			public function  Paises ( ){
						$Registro    =  $this->Db->Ejecutar_Sp("paises_listado_activos()");
						return $Registro;
				}




} ?>
