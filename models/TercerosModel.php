
<?php
	class TercerosModel extends Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function GetTerceros()
		{
				$Terceros = $this->Db->Ejecutar_Sp('terceros_listado_general()');
				return $Terceros;
		}

		public function Insertar_Registro($Datos=array())
		{
			extract($Datos);
			$this->Db->Ejecutar_Sp('terceros_listado_general()');
		}

		public function Buscar_Registro_x_Identificacion_Clave($indentificacion, $clave)
		{
				$this->Db->Ejecutar_Sp("bancos_crear_modificar(0,$codbanco,'$nombanco',0)");
		}

		public function Terceros_Clientes_Por_Vendedor($idvendedor)
		{
			return $this->Db->Ejecutar_Sp("terceros_clientes_listado_general_x_vendedor($idvendedor)");
		}


		public function Terceros_Visitas_Motivos()
		{
			 return $this->Db->Ejecutar_Sp("motivos_visitas_listado_general");


		}

		public function Terceros_Visitas_Crear_Modificar($parametros=array())
		{	/*
				ORDEN DE PARAMETROS
			 idregistro,idtercero,fecha_visita,idmtvovisita ,resultados,siguiente_paso,venta,pago,codcripack,fecha_proxvisita,contacto,tipo_visita  */
				extract($parametros);
			 return 	$this->Db->Ejecutar_Sp("terceros_visitas_crear_modificar(0,$idtercero,'$fecha_visita',$idmtvovisita,'$resultados','$siguiente_paso',0,0,'','$fecha_proxvisita','$contacto',$tipo_visita)");
		}

		public function Terceros_Visitas_Consultar_Agenda_x_Vendedor($parametros = array())
		{
			extract($parametros);
			$visitas = $this->Db->query("CALL informes_terceros_visitas_x_semana_x_vendedor('$fecha_consulta',$idvendedor)");
			$visitas->setFetchMode(PDO::FETCH_ASSOC);
			return $visitas->fetchAll();
		}

		public function Terceros_Buscar_Datos_Por_Codigo($codigo_tercero)
		{
			return $this->Db->Ejecutar_Sp("terceros_buscar_por_codigo('$codigo_tercero')");
		}




		public function Terceros_Buscar_Datos_Por_Codigo_Id_Vendedor($codigo_tercero, $idvendedor,$idtercero )
		{
				//$codigo_tercero : CODIGO DE CLIENTE
				//$idvendedor 			 : IDVENDEDOR
				//$idtercero 					: IDCLIENTE
			return $this->Db->Ejecutar_Sp("terceros_buscar_por_codigo_cliente_id_vendedor('$codigo_tercero',$idvendedor,$idtercero)");
		}
	}
?>
