<?php
	class LoginModel extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function GetUsuario($Datos=array())
		{
			 extract($Datos);
	   return  $this->Db->Ejecutar_Sp("login_validacion_usuario($identificacion,'$password')");
		}

	}

?>
