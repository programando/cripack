<?php

	class ErrorController extends Controller
	{

		public function __construct()
		  {
        parent::__construct();
    	}

   public function Index()
    {
        $this->View->Mensaje_Error = $this->GetError();
        $this->View->Mostrar_Vista('index');
    }

   public function Access($codigo)
    {

    	$this->View->Mensaje_Error = $this->GetError($codigo);
     	$this->View->Mostrar_Vista('access');
    }

    private function GetError($codigo = false)
    {

      if($codigo!=false)
       {
        $codigo = General_Functions::Validar_Entrada($codigo,'NUM');
        if(is_int($codigo))   { $codigo = $codigo; }
       }
       else {	$codigo = 'default';  }


      $error['default'] = 'Ha ocurrido un error y la página no puede mostrarse !';
      $error['5050']    = 'Acceso restringido. Debe iniciar sesión mediante la opción ingresar al sistema.';
      $error['8080']    = 'Su tiempo de sesión ha finalizado, debe volver a loguearse en el sistema!';

      if(array_key_exists($codigo, $error))
      	{	return $error[$codigo];   }
      else
      	{ return $error['default']; }
    }


	}

?>
