<?php

Class Fechas
{

		public static function Formato( $fecha ){
     if ( empty(  $fecha )){
     	$Variable = '';
     }else {
					$Variable =  date("d-M-Y", strtotime( $fecha ));
				}
							return $Variable;
		}


}
