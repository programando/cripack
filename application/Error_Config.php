<?php
/**
 * SEP 10 DE 2014
 * CONFIGURACION DE LOS ERRORES DEL APLICATIVO.
 */
	//ini_set('display_errors',true);
	//error_reporting(E_ALL);


		if (DEVELOPMENT_ENVIRONMENT == TRUE) {
		    error_reporting(E_ALL);
		    ini_set('display_errors','On');

		} else {
		    error_reporting(E_ALL);
		    ini_set('display_errors','Off');
		    ini_set('log_errors', 'On');
		    ini_set('error_log', ROOT.'logs'.DS.'error.txt');
		}
?>
