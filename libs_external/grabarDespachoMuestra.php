<?php
//Se estable la url del servicio web de TCC
$url = 'http://clientes.tcc.com.co/preservicios/wsdespachos.asmx?wsdl';

//Se configuran las unidades de la remesa para este ejemplo se envian dos unidades
  $unidad = array(
    array('tipounidad' => 'TIPO_UND_PAQ',
	      'claseempaque' => '',
	      'dicecontener' => '',
	      'cantidadunidades' => '3',
	      'kilosreales' => '30',
	      'pesovolumen' => '50',
	      'valormercancia' => '525000'
	    ),
	array('tipounidad' => 'TIPO_UND_PAQ',
	      'claseempaque' => '',
	      'dicecontener' => '',
	      'cantidadunidades' => '3',
	      'kilosreales' => '30',
	      'pesovolumen' => '50',
	      'valormercancia' => '525000'
  		)
  	);

//Se configura la informacion de la remesa, IMPORTARTE ACLARAR QUE LA VARIABLE "Clave",
//es la asignada por TCC para cada cliente, por tal motivo en el ejemplo se envia como XXXXXXXXXXXX la cual NO funcionará hasta tanto NO sea reemplazada.

$objDespacho = array(
																					'objDespacho'                    => array(
																					'clave'                          => 'XXXXXXXXXXXX',
																					'fechahoralote'                  => '',
																					'numeroremesa'                   => '',
																					'numeroDepacho'                  => '',
																					'unidadnegocio'                  => '1',
																					'fechadespacho'                  => '2017-04-02',
																					'cuentaremitente'                => '1234567',
																					'sederemitente'                  => '',
																					'primernombreremitente'          => 'ojara',
																					'segundonombreremitente'         => '',
																					'primerapellidoremitente'        => '',
																					'segundoapellidoremitente'       => '',
																					'razonsocialremitente'           => 'ojara',
																					'naturalezaremitente'            => 'J',
																					'tipoidentificacionremitente'    => 'NIT',
																					'identificacionremitente'        => '123456789',
																					'telefonoremitente'              => '1234567',
																					'direccionremitente'             => 'Calle con carrera',
																					'ciudadorigen'                   => '05001000',
																					'tipoidentificaciondestinatario' => 'CC',
																					'identificaciondestinatario'     => '',
																					'sededestinatario'               => '',
																					'primernombredestinatario'       => 'DESTINATARIO',
																					'segundonombredestinatario'      => 'PRUEBAS',
																					'primerapellidodestinatario'     => 'SERVICIO',
																					'segundoapellidodestinatario'    => 'WEB',
																					'razonsocialdestinatario'        => '',
																					'naturalezadestinatario'         => 'N',
																					'direcciondestinatario'          => 'CALLE 35C N° 20-40 JORDAN - PARAISO',
																					'telefonodestinatario'           => '3012861375',
																					'ciudaddestinatario'             => '76001000',
																					'barriodestinatario'             => '',
																					'totalpeso'                      => '',
																					'totalpesovolumen'               => '',
																					'formapago'                      => '',
																					'observaciones'                  => 'ESTO ES UNA PRUEBA DE DESPACHO POR SERVICIO WEB',
																					'llevabodega'                    => '',
																					'recogebodega'                   => '',
																					'centrocostos'                   => '',
																					'totalvalorproducto'             => '',
																					'unidad'                         => $unidad,
																					'documentoreferencia'            => '',
																					'generarDocumentos'              => true
	  ),
													'respuesta'        => 0,
													'remesa'           => '',
													'URLRelacionEnvio' => '',
													'URLRotulos'       => '',
													'URLRemesa'        => '',
													'IMGRelacionEnvio' => null,
													'IMGRotulos'       => null,
													'IMGRemesa'        => null,
													'respuesta'        => 0,
													'mensaje'          => ''
);

$client                             = new SoapClient($url);

$remesa                             = new \StdClass;
$remesa->remesa                     = '';
$URLRelacionEnvio                   = new \StdClass;
$URLRelacionEnvio->URLRelacionEnvio ='';
$URLRotulos                         = new \StdClass;
$URLRotulos->URLRotulos             ='';
$URLRemesa                          = new \StdClass;
$URLRemesa->URLRemesa               ='';
$IMGRelacionEnvio                   = new \StdClass;
$IMGRelacionEnvio->IMGRelacionEnvio = null;
$IMGRotulos                         = new \StdClass;
$IMGRotulos->IMGRotulos             =null;
$IMGRemesa                          = new \StdClass;
$IMGRemesa->IMGRemesa               =null;
$respuesta                          = new \StdClass;
$respuesta->respuesta               = 0;
$mensaje                            = new \StdClass;
$mensaje->mensaje                   = '';



try {

//Despues de realizar la configuración del xml a enviar, se realiza el consumo del servicio web
$resp = $client->GrabarDespacho4($objDespacho, $remesa,$URLRelacionEnvio,$URLRotulos,$URLRemesa,$IMGRelacionEnvio,$IMGRotulos,$IMGRemesa,$respuesta,$mensaje);

//Aqui se hace el manejo de la excepción del consumo
echo $client->__getLastRequest() ."\n";
}catch(Exception $e){
	echo 'Excepción capturada: ',  $e->getMessage() , '<br>';
}

var_dump($resp);
var_dump($resp->IMGRelacionEnvio);

//Se realiza la decodificación del string enviado por el servicio a base64 para su posterior grabación o descarga en un archivo binario.
$decoded = base64_decode($resp->IMGRelacionEnvio);

//Se asigna el nombre del archivo
$file = 'filePDF.pdf';

//Se realiza la descarga del archivo.
file_put_contents($file, $resp->IMGRelacionEnvio);
echo($file);
