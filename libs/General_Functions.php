<?php

	class General_Functions
	{

	public static function Validar_Entrada($Clave,$Tipo_Validacion)
			{
				/* SEPTIEMBRE 13 DE 2014
						Valida y depura la entrada recibida por POST
				*/
						if (isset($_POST[$Clave]))
						{
							$Clave_Recibida = $_POST[$Clave];
							$Tipo_Variable  = gettype($Clave_Recibida);


							if (!empty($Clave_Recibida))
							{
								switch ($Tipo_Validacion)
								{
									case 'TEXT':

										$Clave_Recibida = trim(htmlspecialchars($Clave_Recibida, ENT_QUOTES));
										break;

									case 'NUM':
											$Clave_Recibida  = filter_var($Clave_Recibida ,FILTER_VALIDATE_INT);
										 break;

									case 'FECHA':
											$valores								=  explode("/", $Clave_Recibida);
											$Clave_Recibida =  $valores[2].'-'.$valores[1].'-'.$valores[0];
										 $Clave_Recibida =  strtotime($Clave_Recibida );
										 $Clave_Recibida =  date('Y-m-d',$Clave_Recibida);
										 break;
									case 'FECHA-HORA':
											//$Clave_Recibida = str_replace('/', '-', $Clave_Recibida);
											$valores          =  explode("/", $Clave_Recibida);
											$anio             = substr($valores[2], 0,4);
											$horas            = substr($valores[2], 5,2).':';
											$minutos          = substr($valores[2], 8,2).':';
											$segundos         ='00';
											$Clave_Recibida   =  $anio.'-'.$valores[1].'-'.$valores[0] .' '. $horas . $minutos . 	$segundos;
											$Clave_Recibida   =  strtotime($Clave_Recibida );
											$Clave_Recibida   =  date('Y-m-d H:i:s',$Clave_Recibida);
										 break;

									default:
										if ($Tipo_Variable=='N' )
										     { $Clave_Recibida =  0 ; }
										else { $Clave_Recibida = '' ;  }
										break;
								}
									 $_POST[$Clave] = $Clave_Recibida;
							}
							 return  $Clave_Recibida;
					}
		 }
  }
?>
