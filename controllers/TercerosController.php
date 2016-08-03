<?php

class TercerosController extends Controller
{
    private $Terceros;
    public function __construct()
    {
        parent::__construct();

        $this->Terceros = $this->Load_Model('Terceros');
    }

    public function index()
    {
        $this->View->Terceros = $this->Terceros->GetTerceros();
        $this->View->Mostrar_Vista('Terceros_Listado');
    }

    public function Visitas_Nuevo()
    {
        Session::Logueo_Requerido();

        $this->View->Motivos_Visitas = $this->Terceros->Terceros_Visitas_Motivos();  //Llamada al modelo
        $this->View->Terceros        = $this->Clientes_consulta_por_vendedor_Datos_Clientes();
        $this->View->SetJs(array('terceros.visitas.nuevo','General.Fechas','jquery.datetimepicker'));
        $this->View->SetCss(array('forms_efects','terceros.visitas_nuevo','forms_buttons','jquery.datetimepicker'));
        $this->View->Mostrar_Vista('visitas_nuevo');


    }

    public function Terceros_Visitas_Grabar_Registro()
    {

      $idregistro         = 0;
      $idtercero          = General_Functions::Validar_Entrada('idtercero','NUM');
      $fecha_visita       = General_Functions::Validar_Entrada('fecha_visita','FECHA');
      $idmtvovisita       = General_Functions::Validar_Entrada('idmtvovisita','NUM');
      $resultados         = General_Functions::Validar_Entrada('resultados','TEXT');
      $siguiente_paso     = General_Functions::Validar_Entrada('siguiente_paso','TEXT');
      $tipo_visita        = General_Functions::Validar_Entrada('tipo_visita','NUM');
      $fecha_proxvisita   = General_Functions::Validar_Entrada('fecha_proxvisita','FECHA-HORA');
      $contacto           = General_Functions::Validar_Entrada('contacto','TEXT');
      $venta              = 0;
      $pago               = 0;
      $codcripack         ='';
      $parametros         = compact('idregistro','idtercero','fecha_visita','idmtvovisita' ,'resultados','siguiente_paso','venta','pago','codcripack','fecha_proxvisita','contacto','tipo_visita');
      $Resultado_Consulta = $this->Terceros->Terceros_Visitas_Crear_Modificar($parametros);

        $registro_grabado = 0;
        $Datos            = compact('registro_grabado','fecha_visita');
        echo json_encode($Datos,256);
    }

    public function agenda_x_vendedor()
    {
      $this->View->SetJs(array('terceros.visitas.consulta.agenda','General.Fechas','jquery.datetimepicker'));
      $this->View->SetCss(array('forms_efects','terceros.visitas_consultar_agenda','forms_buttons','terceros_clientes_por_vendedor','jquery.datetimepicker'));
      $this->View->Mostrar_Vista('visitas_consulta');
    }

    public function visitas_consultar_agenda_x_vendedor()
    {
      $fecha_consulta       = General_Functions::Validar_Entrada('fecha_consulta','FECHA');
      $idvendedor           = Session::Get('idusuario');
      $parametros           = compact('fecha_consulta','idvendedor');
      $Resultado_Consulta  = $this->Terceros->Terceros_Visitas_Consultar_Agenda_x_Vendedor($parametros);
      echo json_encode($Resultado_Consulta,256);
    }

    public function Clientes_consulta_por_vendedor()
    {
         $this->View->Terceros = $this->Clientes_consulta_por_vendedor_Datos_Clientes();
         $this->View->SetCss(array('terceros_clientes_por_vendedor'));
         $this->View->Mostrar_Vista('terceros_clientes_por_vendedor');
    }

    public function Clientes_consulta_por_vendedor_Datos_Clientes()
    {
         Session::Logueo_Requerido();
         return  $this->Terceros->Terceros_Clientes_Por_Vendedor(Session::Get('idusuario'));
    }

    public function Terceros_Buscar_Datos_Por_Codigo_Id_Vendedor()
    {

     $codigo_tercero     =  General_Functions::Validar_Entrada('codigo_tercero','TEXT');
     $idtercero          =  General_Functions::Validar_Entrada('idtercero','NUM');
     $tipo_retorno       =  General_Functions::Validar_Entrada('tipo_retorno','TEXT');
     $idvendedor         =  Session::Get('idusuario');



     $Resultado_Consulta = $this->Terceros->Terceros_Buscar_Datos_Por_Codigo_Id_Vendedor($codigo_tercero,$idvendedor,$idtercero );


       if ($tipo_retorno=='json')
            {
              if (count($Resultado_Consulta)>0)
              {
                $nommcipio               = String_Functions::Formato_Texto($Resultado_Consulta[0]['nommcipio']);
                $nomvendedor             = String_Functions::Formato_Texto($Resultado_Consulta[0]['nomvendedor']);
                $contacto                = String_Functions::Formato_Texto($Resultado_Consulta[0]['contacto']);
                $nomtercero              = String_Functions::Formato_Texto($Resultado_Consulta[0]['nomtercero']);
                $codigo_tercero          = String_Functions::Formato_Texto($Resultado_Consulta[0]['codigo_tercero']);
                $resultado_anterior      = String_Functions::Formato_Texto($Resultado_Consulta[0]['resultado_anterior']);;
                $siguiente_paso_anterior = String_Functions::Formato_Texto($Resultado_Consulta[0]['siguiente_paso_anterior']);
                $idtercero               = $Resultado_Consulta[0]['idtercero'];
                $con_resultado           = 1;
                $Datos         = compact('nommcipio','nomvendedor','contacto','idtercero','nomtercero','con_resultado','codigo_tercero','resultado_anterior','siguiente_paso_anterior');
            }
            else
            {
                $Datos = array('con_resultado'=>0);
            }
              echo json_encode($Datos,256); //JSON_UNESCAPED_UNICODE => 256, FORMATO PARA ACENTOS

            }

            else
            {
                return   $Resultado_Consulta ;
            }
    }

}


