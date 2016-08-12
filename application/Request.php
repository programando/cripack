<?php
/**
 * SEP 11 DE 2014
 * CLASE QUE PROCESA TODOS LOS REQUERIMIENTOS RECIBIDOS POR LA URL
 * DESCOMPONE EL REQUERIMIENTO: http://dominio/controlador/metodo/parametros
 * EN:
 * CONTROLADOR
 * METODO
 * PARAMETROS
 */
class Request
{
    protected $Controlador;
    protected $Metodo;
    protected $Argumentos = Array();
    protected $url;

    public function __construct()
    {
        $this->url='';

        if(!isset($_GET['url']))    { $this->url="";                }
        else                        { $this->url = $_GET['url'];    }

        $segmentos_url = explode('/',$this->url);

        $this->ResolveController($segmentos_url);
        $this->ResolveMethod    ($segmentos_url);
        $this->ResolveParams    ($segmentos_url);

    Debug::Mostrar( $_GET['url'] );
    }

    /**
     * AGOSTO 26 DE 2014
     * Recibe la URL (por referencia) y devuelve el nombre de controlador
     * Obtiene el primer elemento de un array (array_shift($segmentos_url);)
     * Si no tengo controlador o está vacío.... cargo el controlador por defecto
     * cargo el controlador por defecto
     */
    public function ResolveController(&$segmentos_url)
        {
            $this->Controlador = array_shift($segmentos_url);
            if (empty($this->Controlador ))
            {
                $this->Controlador  = DEFAULT_CONTROLLER;
            }
            //$this->Controlador      =   String_Functions::Camel($this->Controlador);

        }

    /**
     * SEP 10 DE 2014
     * De una URL como esta: www.empresa.com/registro-terceros/nuevo-usuario/parametros
     * Obtiene nuevo-usuario .... que corresponde al método que quiero ejecutar
     */
    public function ResolveMethod(&$segmentos_url)
        {
            $this->Metodo = array_shift($segmentos_url);
            if (empty($this->Metodo ))
            {
                $this->Metodo   = DEFAULT_METHOD;
            }
           $this->Metodo         =  String_Functions::LowerCamel($this->Metodo);
           $this->Metodo         = str_replace('-', '_', $this->Metodo );
           Session::Set('Zona', $this->Metodo);

        }
    public function ResolveParams(&$segmentos_url)
        {
            $this->Argumentos = $segmentos_url;
        }
    public function getControlador() {  return $this->Controlador;    }
    public function getMetodo()      {  return $this->Metodo;         }
    public function getArgs()        {  return $this->Argumentos;     }
}
?>
