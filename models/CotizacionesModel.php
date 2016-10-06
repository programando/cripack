<?php
		class CotizacionesModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}

				public function Index(  ) { }

				public function Consulta_Notificaciones( )	{
						$Registros                = $this->Db->Ejecutar_Sp("cotizaciones_notificaciones_consultar_envio_correos( )");
						$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
						return $Registros ;
				}


	  public function Consulta_Cotizacion ( $idControl ){
	  				$Registros                = $this->Db->Ejecutar_Sp("cotizaciones_consultar_h_x_idcontrol( $idControl )");
	  				return $Registros ;
	  }

	  public function Consulta_Detalle ( $idControl ){
	  				$Registros                = $this->Db->Ejecutar_Sp("cotizaciones_consultar_dt_x_idcontrol ( $idControl )");
	  				return $Registros ;
	  }

	  public function Actualizar_Estado_Rechazada( $idControl ){
	  				$Registros                = $this->Db->Ejecutar_Sp("cotizaciones_asignacion_estado_x_idcontrol ( $idControl, 11 )");

	  }



  }?>
