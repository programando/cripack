<?php

class LoginController extends Controller
{
   private $Login;
    public function __construct()
    {
        parent::__construct();
        $this->Login  = $this->Load_Model('Login');
    }


    public function Index()
    {
      $Aceptar = General_Functions::Validar_Entrada('Aceptar','NUM');

      if ($Aceptar==1)
      {

        $identificacion = General_Functions::Validar_Entrada('identificacion','TEXT');
        $password       = General_Functions::Validar_Entrada('password','TEXT');

        if (empty($identificacion) or empty($password))
        {
           $this->View->Mensaje_Error = 'Debe registrar la identificación y la contraseña de ingreso.';
           $this->View->Mostrar_Vista('index');
           exit;
        }
        $Datos_Logueo = compact('identificacion','password');
        $row = $this->Login->GetUsuario($Datos_Logueo);

        if (!$row)
          {
           $this->View->Mensaje_Error = 'Usuario y/o contraseña incorrectos. ';
           $this->View->Mostrar_Vista('index');
           exit;
         }
            Session::Set('Autenticado',      true);
            Session::Set('idusuario',        $row[0]['idtercero']);
            Session::Set('vendedor',         $row[0]['vendedor']);
            Session::Set('nombre_usuario',   String_Functions::Formato_Texto($row[0]['completo']));
            Session::Set('Tiempo',           time());
            $this->Redireccionar();             // Luego del logueo se dirige a la pagina principal

      }
       Session::Set('Css_Logueo',BASE_CSS .'login_form.css');
       $this->View->SetJs(Array('jquery.validate','Validaciones.Login'));
       $this->View->Mostrar_Vista('index',compact('Mensaje_Error'));

    }


    public function Cerrar()
    {
        Session::Destroy();
        $this->Redireccionar();
    }
}

?>
