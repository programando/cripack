<?php
	Class String_Functions
	{
				public static function Camel($value)
				{
					// Convierte cadena en array
					$segmentos = explode('-',$value);
					// array_walk -> Recorre secuencialmente un array y por cada llamada.... invoca una funcion (Anónima)
					// array_walk($segmentos, function (&$item)
					array_walk($segmentos, function (&$item)
					{
						// En cada iterracción convierte a mayúsculas la primera letra dela palabra
						$item = ucfirst($item);
					});
					// convierte un array en una cadena, en este caso sin espacios.
					return implode('',$segmentos);
				}

				// Convierte una cadena en minusculas
				public static function LowerCamel ($value)
				{
					return lcfirst(static::Camel($value));
				}


		public static function Formato_Texto($Variable)
			{
					$Variable = trim(utf8_encode($Variable));
					return 	$Variable ;
			}

	 


}
