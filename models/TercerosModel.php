<?php
		class TercerosModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}



				/*
				public function Actualizar_Datos_Usuario($params=array()){
						extract($params);

						$SQL = "$idtercero, $idtpidentificacion,'$pnombre', '$papellido', '$razonsocial','$idmcipio','$direccion','$barrio','$celular1',";
						$SQL = $SQL."'$email','$pago_comisiones_transferencia', '$param_idbanco_transferencias' ,'$param_nro_cuenta_transferencias',";
						$SQL = $SQL."'$param_tipo_cuenta_transferencias','$param_idmcipio_transferencias', '$recibo_promociones_celular',";
						$SQL = $SQL."'$recibo_promociones_email', '$param_confirmar_nuevos_amigos_x_email', '$mis_datos_son_privados',";
						$SQL = $SQL."'$declaro_renta', '$param_acepto_retencion_comis_para_pago_pedidos', '$param_valor_comisiones_para_pago_pedidos',";
						$SQL = $SQL."'$pago_comisiones_efecty','$password', '$param_nombre_titular_cuenta','$param_identificacion_titular_cuenta', ";
						$SQL = $SQL."'$param_idtpidentificacion_titular_cuenta'";
						$Registro    =  $this->Db->Ejecutar_Sp("terceros_actualizar_registro(".$SQL.")");

				}

*/




				public function Consulta_Datos_Por_Password_Email($password,$email)	{
						/** CONSULTA DATOS DEL USUARIO CON PASSWORD + EMAIL. DESDE EL LOGIN				*/
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_web_consulta_x_password_email('$password','$email')");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}


					public function Consulta_Trabajos_x_Tercero ($idtercero)	{
						$Terceros                 = $this->Db->Ejecutar_Sp("terceros_web_consulta_trabajos_x_tercero($idtercero)");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Terceros;
				}




  }
?>
