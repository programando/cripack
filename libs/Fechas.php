<?php

Class Fechas
{

		public static function Formato( $fecha ){
					$Variable =  date("d-m-Y", strtotime( $fecha ));
							return $Variable;
		}


}
