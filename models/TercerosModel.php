<?php
		class TercerosModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}


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




  }
?>
