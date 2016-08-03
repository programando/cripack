

<?php



class Database extends PDO
{
    public function __construct() {
        parent::__construct(
                'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME,
                DB_USER, DB_PW, array(  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHAR ));

    }

    public function Ejecutar_Sp($nombre_sp_y_parametros)
    {

      $resultado_consulta = $this->query('CALL ' . $nombre_sp_y_parametros);
      return  $resultado_consulta->fetchall();

    }
}



/*
/**
 * SEP 10 DE 2014
 * CLASE QUE CONTROLA LAS PETICIONES A LA BASE DE DATOS

  class DataBase
  {
    private $IdConexion;
    public $Num_Filas;

    public function __construct()
    {
      $this->Num_Filas = 0;
    }


 * SEP 10 DE 2014
 * OBTIENE UN IDENTIFICADOR DE CONEXIÓN POR MEDIO DEL CUAL ES POSIBLE
 * HACER PETICIONE A LA BASE DE DATOS

    private  function GetId()
    {
      $this->IdConexion = new mysqli(DB_SERVER,DB_USER,DB_PW,DB_NAME);

      if (mysqli_connect_errno())
        {
          printf("No fue posible conectarse a la base de datos.", mysqli_connect_error());
          exit();
        }
        $this->IdConexion->query('SET CHARSET_SET_CONECTION ='."'UTF-8'");
        $this->IdConexion->query('SET collation_connection  ='."'utf8_spanish_ci'");
        $this->IdConexion->query('SET NAMES  ='."'utf-8'");
    }


    /**
     * SEP 10 DE 2014
     * @param [String] $nombre_sp_y_parametros [PROCEDIMIENTO ENCARGADO DE EJECUTAR LAS PETICIONES SQL]

    public function Ejecutar_Sp($nombre_sp_y_parametros)
    {

      $this->GetId();

      $resultado_consulta = $this->IdConexion->query('CALL ' . $nombre_sp_y_parametros);

      if (! $resultado_consulta)
      {
        throw new Exception("Database Error : [{$this->IdConexion->errno}] {$this->IdConexion->error}");
      }
      if (is_object($resultado_consulta)){
        $rows               = $resultado_consulta->fetch_all(MYSQLI_ASSOC);
        $this->Num_Filas    = $this->IdConexion->affected_rows;
         $this->IdConexion->close();
         $resultado_consulta->free();
          return $rows ;
      }else{
         $this->IdConexion->close();
      }


      //Debug::Mostrar($rows );
    }


  }
*/
?>
