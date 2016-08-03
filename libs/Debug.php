<?php

Class Debug
{
	public static function Mostrar($var=array())
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}


}
