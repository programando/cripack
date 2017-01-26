<?php

Class Fechas
{

		public static function Formato( $fecha ){
     if ( empty(  $fecha )){
     	$Variable = '';
     }else {
					$Variable =  date("d-m-Y", strtotime( $fecha ));
				}
							return $Variable;
		}


}
