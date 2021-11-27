<?php

     define('DS', DIRECTORY_SEPARATOR);
					define('ROOT', realpath(dirname(__FILE__)) . DS);
					define('LIBS',ROOT . 'libs' .DS);
					define('EXTERNAL_LIBS',ROOT . 'libs_external' .DS);
					define('APP_PATH', ROOT . 'application' . DS);

					define('VENTANAS_MODALES', 									ROOT . 'application_sections' . DS . 'modales' . DS );
					define('EMAILS',           										ROOT . 'application_sections' . DS . 'emails' . DS );
					define('APPLICATION_SECTIONS_TERC',  ROOT . 'application_sections' . DS . 'terceros' . DS );
					define('APPLICATION_SECTIONS_MENU',  ROOT . 'application_sections' . DS . 'menus' . DS );

require_once APP_PATH . 'Config.php';


						  // Archivo de configuración de la base de datos. coloco un comentario p
						  //------------------------------------------------
require_once APP_PATH . 'Database_config.php';

 						 //require_once APP_PATH . 'Autoload.php';
 						 foreach ( glob(APP_PATH  .    '*.php') as $file ) {  	require_once $file;     } //librerias/funciones de la aplicacion

 						 //Carga de las librerías externas, como por ejemplo la librería para PDF.
 						 //-----------------------------------------------------------------------
 						 foreach ( glob(LIBS .    '*.php') as $file ) {  	require_once $file;     } //librerias/funciones de la aplicacion
		Session::Init();
 						 try	 {
                 $Url_Solicitada = new Request();
								 
                 Bootstrap::Run( $Url_Solicitada );
         						 }
         						 catch(Exception $e){
         						 	echo $e->getMessage();
 						 }
												
/* 					try{
					    foreach (glob(APP_PATH .'*.php') as $file) { 	 require_once $file;     } //Arhivos de aplicacion
					    foreach (glob(LIBS .    '*.php') as $file) {  	require_once $file;     } //librerias/funciones de la aplicacion
					    //echo '<pre>';print_r(get_required_files());
					    Session::Init();
					    $url_requerida = new Request();
					    Bootstrap::Run($url_requerida);
					}
					catch(Exception $e){
					    echo $e->getMessage();
					}
 */

?>
