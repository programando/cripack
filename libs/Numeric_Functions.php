<?php
Class Numeric_Functions
{
    public static function Formato_Numero($value)    {
     $numero = "$" . number_format($value, 0, "" ,".");
     return $numero;
    }


    public static function Formato_Numero_SinSigno($value)    {
     $numero = number_format($value, 0, "" ,".");
     return $numero;
    }

     Public static function Filtrar_Entero( $int )     {
        $int = (int) $int;
        if(is_int($int))
        {
            return $int;
        }
        else{
            return 0;
        }
    }


    public static function Valor_Absoluto($valor)        {
    /**  MARZO 15 DE 2015
            *                       DEVUELVE EL VALOR ABSOLUTO DE UN NÚMERO
            */
                $valor_absoluto = intval(abs ($valor));
                if ($valor_absoluto !=$valor)
                {
                    $valor_absoluto  = intval($valor_absoluto)  + 1;
                }
                return $valor_absoluto;
        }


   public static  function Redondear_Al_100_Mas_Proximo($numero)    {
    /**
    *   JUNIO 14 2013
    *   Función utilitaria que se encarga de redondear a la centena más proxima.
    *   Recibe un número, obtiene los dos últimos dígito, verifica si son menores a 50, y los resta
    *   en caso contraro, verifica lo que hace falta para llegar a 100.  el resultado lo suma
    *   al número que llegó como parámetro.
    */

        $numero_a_redondear         = (int)$numero;
        $_string_numero             ='';
        $_ultimos_dos_digitos       ='';
        $_num_ultimos_dos_digitos   =0;

        $_string_numero             = (string)$numero_a_redondear;
        $_ultimos_dos_digitos       = substr($_string_numero , -2);
        $_num_ultimos_dos_digitos   = (int)$_ultimos_dos_digitos;

        if ($_num_ultimos_dos_digitos <> 0 ) {
                $numero_a_redondear = $numero_a_redondear + ( 100-$_num_ultimos_dos_digitos );
            }
        if ($_num_ultimos_dos_digitos<0){
                $_num_ultimos_dos_digitos=0;
            }
            return $numero_a_redondear;
    }


   public static  function Redondear_Al_1000_Mas_Proximo($numero)    {
    /**
    *   JUNIO 14 2013
    *   Función utilitaria que se encarga de redondear a la centena más proxima.
    *   Recibe un número, obtiene los dos últimos dígito, verifica si son menores a 50, y los resta
    *   en caso contraro, verifica lo que hace falta para llegar a 100.  el resultado lo suma
    *   al número que llegó como parámetro.
    */

        $numero_a_redondear         = (int)$numero;
        $_string_numero             ='';
        $_ultimos_dos_digitos       ='';
        $_num_ultimos_dos_digitos   =0;

        $_string_numero             = (string)$numero_a_redondear;
        $_ultimos_dos_digitos       = substr($_string_numero , -3);
        $_num_ultimos_dos_digitos   = (int)$_ultimos_dos_digitos;

        if ( $_num_ultimos_dos_digitos  <> 0 ){
             $numero_a_redondear = $numero_a_redondear + ( 1000 - $_num_ultimos_dos_digitos );
        }

        if ($_num_ultimos_dos_digitos<0){
                $_num_ultimos_dos_digitos=0;
            }
            return $numero_a_redondear;
    }



}

?>
