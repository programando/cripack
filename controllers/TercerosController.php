<?php
	/* AGOSTO 24 DE 2014
			Realiza la llamada a la vista correspondiente y traslada los parametros que necesita
			a Cada controlador el corresponde una vista. en el proyecto se encuentran dentro de carpetas
			La extensión de estas vistas es PHTML, dentro del rectorio views
	 */
class TercerosController extends Controller
{
    public function __construct()  {
        parent::__construct();
    }

    public function Index() {

        $this->View->Mostrar_Vista('login');

    }
	
	public function Historial() {

        $this->View->Mostrar_Vista('historial');

    }
	
	

}

?>

