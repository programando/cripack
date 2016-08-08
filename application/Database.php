

<?php
class Database extends PDO
{
    public $Cantidad_Registros = 0;

    public function __construct()
    {
          $dsn    = 'mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER;
          $user   = DB_USER;
          $pw     = DB_PW;
          $params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
        try
        {
          parent::__construct($dsn, $user, $pw, $params);
          //$this->setAttribute($params);
        }
          catch(PDOException $e) {
          echo 'Connection failed: ' . $e->getMessage();
          exit;
    }


    }

    public function Ejecutar_Sp($nombre_sp_y_parametros) {
      //Debug::Mostrar($nombre_sp_y_parametros);
      try {
          $this->Cantidad_Registros = 0;
          $resultado_consulta       = $this->query('CALL ' . $nombre_sp_y_parametros);
          $Respuesta_Bd             = $resultado_consulta->fetchall();
          $this->Cantidad_Registros = count($Respuesta_Bd );
          $resultado_consulta       = null;
           return  $Respuesta_Bd;
     }
      catch (Exception $e) {
          echo 'Se ha presentado un error. Recargue la página por favor.';
      }
    }

    public function Ejecutar_SQL($texto_SQL)
    {

      $this->Cantidad_Registros = 0;
      $resultado_consulta       = $this->query($texto_SQL);
      $Respuesta_Bd             = $resultado_consulta->fetchall();
      $this->Cantidad_Registros = count($Respuesta_Bd );
      $resultado_consulta       = null;
      return  $Respuesta_Bd;
    }

}

?>
