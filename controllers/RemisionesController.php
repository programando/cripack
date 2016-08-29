<?php
	/* AGOSTO 24 DE 2014
			Realiza la llamada a la vista correspondiente y traslada los parametros que necesita
			a Cada controlador el corresponde una vista. en el proyecto se encuentran dentro de carpetas
			La extensión de estas vistas es PHTML, dentro del rectorio views
	 */
class RemisionesController extends Controller {

    public function __construct()  {
        parent::__construct();
        $this->Emails                = $this->Load_Controller('Emails');
        $this->Remisiones            = $this->Load_Model('Remisiones');

    }

    public function Index(  ) { }


    public function Remisiones_Informar_Clientes (){

        $Remesas = $this->Remisiones->Consulta_Remisiones_Informar_Email();                             //    00
        foreach ( $Remesas as $Remesa ) {
            $Id_Remesa      = $Remesa['idregistro'] ;
            $NumeroGuia     = $Remesa['num_remesa'] ;
            $Datos_Emails   = $this->Remisiones->Datos_Enviar_x_Remesa               ( $Id_Remesa );     //     01
            $Datos_Empresas = $this->Remisiones->Datos_Enviar_x_Remesa_Datos_Empresa ( $Id_Remesa );     //     02
            $Datos_Ots      = $this->Remisiones->Datos_Enviar_x_Remesa_Datos_Ots     ( $Id_Remesa );     //     03

            foreach ( $Datos_Empresas as $Datos_Empresa ) {
               $Empresa      = $Datos_Empresa['nomtercero'];
               $Destinatario = $Datos_Empresa['contacto'];
               $this->Emails->Remisiones_Enviar_Informe_Correo (  $Empresa, $Destinatario, $NumeroGuia, $Datos_Ots  ) ;
            }



        }

    }


}

?>

