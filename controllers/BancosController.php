<?php

class BancosController extends Controller
{
    private $Bancos;
    public function __construct()
    {
        parent::__construct();
        $this->Bancos = $this->Load_Model('Bancos');
    }

    public function index()
    {
        $this->View->Bancos = $this->Bancos->Bancos_Listado_General();
        $this->View->Mostrar_Vista('Listado_General');
    }

    public function Nuevo()
    {

       $guardar  =  General_Functions::Validar_Entrada('guardar','NUM');

       if ( $guardar ==1)
        {
            $codbanco =  General_Functions::Validar_Entrada('codbanco','TEXT');
            $nombanco =  General_Functions::Validar_Entrada('nombanco','TEXT');

         $this->Bancos->Bancos_Insertar_Registro(compact('codbanco','nombanco'));

        }
         $this->View->Mostrar_Vista('Nuevo');

    }


}
