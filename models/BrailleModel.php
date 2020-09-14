<?php
		class BrailleModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}

				public function Index(  ) { }


			public function updateConteoTranscripciones ( ) {
				$identificacion = Session::Get('identificacion');
				$this->Db->Ejecutar_Sp("terceros_braile_upd_conteo_transcripcion( '$identificacion' )");
			}

			public function tokenConfirm ( $Token ) {
					$Registros = $this->Db->Ejecutar_Sp("terceros_braille_token_confirm( '$Token ' )");
					$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
					return $Registros;			
			}

			public function tercerosNewRecord( $_identificacion, $_nombre, $_telefonos, $_email_1, $_email_2, $_token) {
					$Registros = $this->Db->Ejecutar_Sp("terceros_braille_crear('$_identificacion', '$_nombre', '$_telefonos','$_email_1','$_email_2','$_token'  )");
			}

			public function tercerosBuscarNit( $nit ){
					$Registros = $this->Db->Ejecutar_Sp("terceros_braile_buscar_x_nit( '$nit' )");
					$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
					return $Registros;
			}

			public function tercerosClienteBuscarNit( $nit ){
					$Registros = $this->Db->Ejecutar_Sp("terceros_braile_buscar_cliente_x_nit( '$nit' )");
					$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
					return $Registros;
			}


				public function textsDelete( $Idtercero )	{
						$Registros = $this->Db->Ejecutar_Sp("braille_textos_borrar($Idtercero  )");
				}

		public function textsQueryToAnalisys ( $Idtercero  ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_textos_analisis_consulta($Idtercero  )");
				return $Registros;
		}

	  public function textSave ( $idtercero, $texto, $caja_largo, $caja_ancho, $caja_alto, $caracteres, $espacios, $palabras, $op1nfe, $op1nfm,$op1nc, $op1mce ,$op1mcm , $op1fmax, $op1fdef, $op1ncare, 															$op1ncarm,  $op2nfe, $op2nfm,$op2nc, $op2mce ,$op2mcm , $op2fmax, $op2fdef, $op2ncare, $op2ncarm ,    $op3nfe, $op3nfm,$op3nc, $op3mce ,$op3mcm , $op3fmax, $op3fdef, 																$op3ncare, $op3ncarm,         $op4nfe, $op4nfm,$op4nc, $op4mce ,$op4mcm , $op4fmax, $op4fdef, $op4ncare, $op4ncarm, $max_cara, $max_filas ) {
 
		 
	  	$Registros = $this->Db->Ejecutar_Sp("braille_textos_grabar($idtercero, '$texto', $caja_largo, $caja_ancho, $caja_alto,$caracteres, $espacios, $palabras, $op1nfe,	$op1nfm,$op1nc, $op1mce ,$op1mcm ,$op1fmax, $op1fdef, $op1ncare, $op1ncarm, $op2nfe,	$op2nfm,$op2nc, $op2mce ,$op2mcm ,$op2fmax, $op2fdef, $op2ncare, $op2ncarm,    $op3nfe,	$op3nfm,$op3nc, $op3mce ,$op3mcm ,$op3fmax, $op3fdef, $op3ncare, $op3ncarm,   $op4nfe,	$op4nfm,$op4nc, $op4mce ,$op4mcm ,$op4fmax, $op4fdef, $op4ncare, $op4ncarm,$max_cara, $max_filas  )");
	 
	  }

    public function textSavePrinter ( $idtercero, $texto, $max_cara, $max_filas, $cara_1, $cara_1_long, $cara_2, $cara_2_long, $palabraError, $cara) {
			$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_crear($idtercero, '$texto', $max_cara, $max_filas, '$cara_1', $cara_1_long, '$cara_2', $cara_2_long,$palabraError,'$cara' )");
			return $Registros;
		}

	  public function textPrinteQuery ( $Idtercero ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_resultado( $Idtercero  )");
				return $Registros;
		}

	  public function simbolosBraile (  ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_simbolos_consulta(   )");
				return $Registros;
		}

	  public function simbolosBraileGrabar ( $idtercero, $id_impresion, $caracter, $imgBraile_1, $imgBraile_2 ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_simbolos_grabar( $idtercero, $id_impresion, '$caracter', '$imgBraile_1', '$imgBraile_2'   )");
		}

	 	  public function impresionSimbolos ( $idtercero ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_simbolos_consulta( $idtercero  )");
				return $Registros ;
		}

		public function textosUnicosImpresion ( $Idtercero ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_impresion_textos_unicos_x_tercero( $Idtercero  )");
				return $Registros;
		}

		public function textosPorCara ( $Idtercero, $cara, $texto ) {
				$Registros                = $this->Db->Ejecutar_Sp("braile_impresion_textos_x_cara( $Idtercero,'$cara','$texto'   )");
				$this->Cantidad_Registros = $this->Db->Cantidad_Registros;
				return $Registros;
		}
		public function simbolosPorCara ( $id_impresion ) {
				$Registros                = $this->Db->Ejecutar_Sp("braile_impresion_simbolos( $id_impresion  )");
				return $Registros;
		}

		public function DatosOts() {
			$Registros                = $this->Db->Ejecutar_Sp("temp_datos_ots()");
				return $Registros;	
		}

		public function DatosOtsUpdCant ($idregistro, $cant) {
				$Registros   = $this->Db->Ejecutar_Sp("temp_datos_ots_upd_cant($idregistro,$cant )");
		}

		public function distribuirPalabras ( $texto_sql){
				$this->Db->Ejecutar_SQL($texto_sql);
  	}

		public function htmlResultSave( $identificacion, $html) {
				$Registros   = $this->Db->Ejecutar_Sp("braile_html_result_grabar('$identificacion', '$html' )");
		}

		public function htmlResultConsulta() {
					$identificacion = Session::Get('identificacion');
				$Registros   = $this->Db->Ejecutar_Sp("braile_html_result_consultar('$identificacion')");
				return $Registros ;
		}
		}
	?>
