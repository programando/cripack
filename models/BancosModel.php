<?php
	class BancosModel extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function Bancos_Listado_General()
		{
				$Bancos = $this->Db->Ejecutar_Sp('bancos_listado_general()');
 		 return $Bancos ;
 		 //Debug::Mostrar($Bancos);

		}

		public function Bancos_Insertar_Registro($Datos=array())
		{
			extract($Datos);
			$this->Db->Ejecutar_Sp("bancos_crear_modificar(0,$codbanco,'$nombanco',0)");
		}

	}

?>


