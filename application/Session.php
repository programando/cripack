<?php
/**
 * SEP 15 DE 2014
 * CLASE ENCARGADA DEL MANEJO DE LAS SESSIONES DEL APLICATIVO
 * ESTABLECE Y RECUPERA DATOS DE LAS VARIABLES DE SESSION
 * CONTROLA EL TIEMPO QUE DURA  LA SESIÓN DE UN USUARIO UNA VEZ QUE SE HA LOGUEADO
 */
	class Session
	{
		public static function Init()
		{
			session_start();
		}

        /**
         * SEP 27 DE 2014
         * DESTRE UNA VARIABLE(S) DE SESSION
         * @param boolean $clave [Nombre de la clave que se va a destruir]
         */
        public static function Destroy($clave = false)
        {
            if($clave)
              {
                if(is_array($clave))
                {
                    for($i = 0; $i < count($clave); $i++)
                    {
                        if(isset($_SESSION[$clave[$i]])) {  unset($_SESSION[$clave[$i]]); }
                    }
                }
                else{ if(isset($_SESSION[$clave]))  	{ unset($_SESSION[$clave]); }
                }
              }
            else {  session_destroy(); }
        }


        public static function Set($clave, $valor)
        {
            if(!empty($clave))
            $_SESSION[$clave] = $valor;

        }

        public static function Get($clave)
        {
            if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
        }

        /**
         * SEP 29 DE 2014
         * CONTROL DE ACCESO PARA LAS OPCIONES DEL SISTEMA. ES NECESARIO QUE ESTÉ AUTENTICADO
         */
        public static function Logueo_Requerido()
            {
                if(!Session::Get('Autenticado'))
                {
                    Session::Set('Css_Logueo',BASE_CSS .'login_form.css');
                    header('location:' . BASE_URL . 'login/index');
                    exit;
                }
                Session::Destroy('Css_Logueo');
                Session::Tiempo();
            }

         /**
          * SEP 29 DE 2014
          * CONTROL DE ACCESO PARA UNA VISTA O PARTE DE ELLA. ES NECESARIO QUE ESTÉ AUTENTICADO
          */
        public static function Logueo_Requerido_Vista()
            {
                if(!Session::Get('Autenticado'))
                { return false;  }
                Session::Tiempo();
                return true;
            }


        /**
         * SEP 29 DE 2014
         * CONTROL DE ACCESO POR NIVEL DE USUARIO. NIVELES ESTABLECIDOS EN LA FUNCION GET LEVEL EN ESTA CLASE
         * @param [type] $level [Nivel de acceso al aplicativo]
         */
        public static function Acceso_Requerido_Nivel($level)
        {
            if(!Session::Get('Autenticado')){
                header('location:' . BASE_URL . 'error/access/5050');
                exit;
            }
            Session::Tiempo();
            if(Session::GetLevel($level) > Session::GetLevel(Session::Get('level'))){
                header('location:' . BASE_URL . 'error/access/5050');
                exit;
            }
        }


        /**
         * SEP 29 DE 2014
         * CONTROL DE ACCESO A UN VISTA O PARTE DE ELLA POR MEDIO DEL NIVEL DE USUARIO
         * @param [type] $level [Nivel de acceso al aplicativo]
         */
       public static function Acceso_Requerido_Nivel_Vista($level)
        {
            //
            //
            if(!Session::Get('Autenticado'))
                { return false; }
                Session::Tiempo();
                if(Session::GetLevel($level) > Session::GetLevel(Session::Get('level')))
                    {    return false; }
                return true;
        }

        /**
         * SEP 28 DE 2014
         * CONFIGURACION DE LOS GRUPOS DE USUARIO
         * @param $level [Nivel de acceso al aplicativo]
         */
        public static function GetLevel($level)
        {

            $role['admin']    = 3;
            $role['especial'] = 2;
            $role['usuario']  = 1;

            if(!array_key_exists($level, $role)){
                throw new Exception('Error de acceso');
            }
            else { return $role[$level]; }
        }


        /**
         * SEP 28 DE 2014
         * CONTROL DE ACCESO A GRUPOS ESPECIFICOS
         * @param array   $level   [Nivel de acceso al aplicativo]
         * @param boolean $noAdmin [Restringe el acceso al adminsitrador]
         */
       public static function Acceso_Estricto_Grupo(array $level, $noAdmin = false)
        {
            if(!Session::Get('Autenticado'))
            {
                header('location:' . BASE_URL . 'error/access/5050');
                exit;
            }
            Session::Tiempo();
            if($noAdmin == false)
            {
                if(Session::Get('level') == 'admin')
                {  return;  }
            }
            if(count($level))
            {
                if(in_array(Session::Get('level'), $level))
                 {  return;  }
            }
            header('location:' . BASE_URL . 'error/access/5050');
        }

        /**
         * SEP 28 DE 2014
         * CONTROL DE ACCESO A GRUPOS ESPECIFICOS  A VISTAS ESPECIFICAS
         * @param array   $level   [description]
         * @param boolean $noAdmin [description]
         */
      public static function Acceso_Estricto_Grupo_Vista(array $level, $noAdmin = false)
        {
            if(!Session::Get('Autenticado'))        { return false; }

            if($noAdmin == false)
              {
                if(Session::Get('level') == 'admin')        { return true;  }
              }

            if(count($level))
            {
                if(in_array(Session::Get('level'), $level))     { return true; }
            }

            return false;
        }

        /**
         * SEP 29 DE 204
         * CONTROLA EL TIEMPO QUE EL USAURIO PODRÁ TRABAJAR EN EL SISTEMA
         */
    public static function Tiempo()
    {
        if(!Session::Get('Tiempo') || !defined('SESSION_TIME'))
            {  throw new Exception('No se ha definido el tiempo de sesión.');  }

        if(SESSION_TIME == 0) // Tiempo se sesión indefinido
            {  return; }

        // si ha pasado más del tiempo establecido, se cierra la sessión
        if(time() - Session::Get('Tiempo') > (SESSION_TIME * 60))
        {
            Session::Destroy();
            header('location:' . BASE_URL . 'error/access/8080');
        }
        else
            {   Session::Set('Tiempo', time()); }
    }
}
?>
