<?php
		class RemisionesModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}


				public function Consulta_Remisiones_Informar_Email( )	{
						$Registros                = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_00_despachos( )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registros ;
				}

				public function Datos_Enviar_x_Remesa ( $id_remesa )	{
						$Datos_Email              = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_01_datos_a_enviar( $id_remesa )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Email  ;
				}

				public function Datos_Enviar_x_Remesa_Datos_Empresa ( $id_remesa )	{
						$Datos_Empresa            = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_02_empresa( $id_remesa )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Empresa  ;
				}

				public function Datos_Enviar_x_Remesa_Datos_Ots ( $id_remesa )	{
						$Datos_Ots                = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_03_ots( $id_remesa )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Ots   ;
				}


				public function Despachos_Actualizar_Enviados ( $id_remesa  )	{
						/** ACTUALIZA LOS DESPACHOS QUE YA FUERON ENVIADOS **/
						$Datos_Ots              = $this->Db->Ejecutar_Sp("remisiones_despachos_actualizar_emails_enviados( $id_remesa )");
				}

				public function Notificacion_Clientes_Datos_Remision (   )	{
						/** ACTUALIZA LOS DESPACHOS QUE YA FUERON ENVIADOS **/
						$Datos_Remisiones              = $this->Db->Ejecutar_Sp("remisiones_notificacion_clientes_datos_remisiones()");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Remisiones   ;
				}

				public function Notificacion_Clientes_Datos_Remision_Ots (  $idregistro_ot )	{
						/** ACTUALIZA LOS DESPACHOS QUE YA FUERON ENVIADOS **/
						$Datos_Ots             = $this->Db->Ejecutar_Sp("remisiones_notificacion_clientes_datos_remisiones_ots( $idregistro_ot )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Ots   ;
				}






  }?>
