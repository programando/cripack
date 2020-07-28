<?php
		class BrailleModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()	{
					parent::__construct();
				}

				public function Index(  ) { }

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

    public function textSavePrinter ( $idtercero, $texto, $max_cara, $max_filas, $cara_1, $cara_1_long, $cara_2, $cara_2_long) {
			$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_crear($idtercero, '$texto', $max_cara, $max_filas, '$cara_1', $cara_1_long, '$cara_2', $cara_2_long )");
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

	  public function simbolosBraileGrabar ( $idtercero, $id_impresion, $caracter, $simbolo ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_simbolos_grabar( $idtercero, $id_impresion, '$caracter', '$simbolo'   )");
		}

	 	  public function impresionSimbolos ( $idtercero ) {
				$Registros = $this->Db->Ejecutar_Sp("braile_textos_impresion_simbolos_consulta( $idtercero  )");
				return $Registros ;
		}


  	}
	?>
