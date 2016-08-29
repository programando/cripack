<?php
/**
 * SEP 10 DE 2014
 * CONTROLADOR PRINCIPAL. DESDE ESTA CLASE SE HEREDAN LOS DEMÁS CONTROLADORES
 */
abstract class Controller
{
    protected $View;

    public function __construct()
     {
        $this->View = new View(new Request);
     }

    abstract public function Index();

    /**
     * SEP 10 DE 2014
     * CLASE ENCARGADA DE CARGAR LOS MODELOS.
     * @param   $Modelo [Nombre del modelo que deseo cargar]
     */
    protected function Load_Model($Modelo)
    {
        $Modelo      = $Modelo . 'Model';
        $Ruta_Modelo = ROOT . 'models' . DS . $Modelo . '.php';

    	if (is_readable($Ruta_Modelo))
    	{
    		require_once ($Ruta_Modelo);
    		$Modelo = new $Modelo;
    		return $Modelo;
    	}
    	else
    	{ throw new Exception("Error de modelo"); }
    }

    /** SEP 10 DE 2014
     * MÉTODO ENCARGADO DE CARCAR OTRO CONTROLADORES
     * @param   $Controlador [nombre del modelo que se cargará]
     */
    protected function Load_Controller($Controlador)
    {
        $Controlador      = $Controlador . 'Controller';
        $Ruta_Controlador = ROOT . 'controllers' . DS . $Controlador. '.php';

        if (is_readable($Ruta_Controlador))
        {
            require_once ($Ruta_Controlador);
            $Controlador = new $Controlador;
            return $Controlador;
        }
        else
        {
            throw new Exception("Error de controlador");
        }
    }



/**
 * SET 10 DE 2014
 * REDIRECCIONA EL FLUJO DE PROCESOS  A CUALQUIER PARTE DEL APLICATIVO
 * @param boolean $ruta [description]
 */
    protected function Redireccionar($ruta = false)
    {
        if($ruta)
        {
            header('location:' . BASE_URL . $ruta);
            exit;
        }
        else
        {
            header('location:' . BASE_URL);
            exit;
        }
    }



    protected function Load_External_Library($libreria)
    {
        /** ENERO 29 DE 2014
        *   SE ENCRGA DE LLAMAR LIBRERÍAS EXTERNAS AL PROYECTO COMO POR EJEMPLO PHPMAILER O PDF
        */
        $rutaLibreria = ROOT . 'libs_external' . DS . $libreria . '.php';
        if(is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }
        else{
            throw new Exception('Error de libreria');
        }
    }




} ?>
