<?php
		class RemisionesModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}


				public function Consulta_Remisiones_Informar_Email( )	{
						/** CONSULTA DATOS DEL USUARIO CON PASSWORD + EMAIL. DESDE EL LOGIN				*/
						$Registros               = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_00_despachos( )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registros ;
				}

				public function Datos_Enviar_x_Remesa ( $id_remesa )	{
						/** CONSULTA DATOS DEL USUARIO CON PASSWORD + EMAIL. DESDE EL LOGIN				*/
						$Datos_Email              = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_01_datos_a_enviar( $id_remesa )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Email  ;
				}

				public function Datos_Enviar_x_Remesa_Datos_Empresa ( $id_remesa )	{
						/** CONSULTA DATOS DEL USUARIO CON PASSWORD + EMAIL. DESDE EL LOGIN				*/
						$Datos_Empresa              = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_02_empresa( $id_remesa )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Empresa  ;
				}

				public function Datos_Enviar_x_Remesa_Datos_Ots ( $id_remesa )	{
						/** CONSULTA DATOS DEL USUARIO CON PASSWORD + EMAIL. DESDE EL LOGIN				*/
						$Datos_Ots              = $this->Db->Ejecutar_Sp("remisiones_despachos_consulta_datos_email_03_ots( $id_remesa )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Datos_Ots   ;
				}




  }
?>
