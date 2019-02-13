<?php
ini_set("soap.wsdl_cache_enabled", "0");
ini_set("display_errors",1);
ini_set("error_reporting",E_ALL);


$url="http://sandbox.coordinadora.com/ags/1.5/server.php?wsdl";

	
$p = new stdClass();
$p->apikey = "aabd0422-0301-11e9-8eb2-f2801f1b9fd1";
$p->clave="W1a4ky9?18!361B";
$p->codigo_remision="91130000000";
$p->imagen = 1;
$p->anexo = 1;
$p->nit = "800149062";
$p->div = "01";
$p->referencia = "";
$client = new SoapClient($url,array('trace' => true, 'exceptions' => true, 'soap_version' => SOAP_1_2));
try {
		$res = $client->Seguimiento_detallado(array("p" => $p));
	} catch (Exception $e) {
		echo "<pre>".$e->getMessage()."</pre>";
		exit;
	}

echo "<hr><pre>";
print_r($res);
echo "</pre>";


?>
