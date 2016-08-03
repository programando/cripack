<?php
/**
 * SEP 10 DE 2014
 * CLASE DESDE LA CUAL SE EXTENDERÁN TODOS LOS OTROS MODELOS
 */
	class Model
	{
		protected $Db;
		public function __construct()
		{
			$this->Db = new Database();
		}
	}

?>


