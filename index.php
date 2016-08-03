<?php
					define('DS', DIRECTORY_SEPARATOR);
					define('ROOT', realpath(dirname(__FILE__)) . DS);
					define('LIBS',ROOT . 'libs' .DS);
					define('APP_PATH', ROOT . 'application' . DS);


					try{
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


?>
