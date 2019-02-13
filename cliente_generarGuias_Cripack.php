<?php
	$url="http://sandbox.coordinadora.com/agw/ws/guias/1.6/server.php";

	$p=new stdClass();
	$p->codigo_remision="";
	$p->fecha="";
	$p->id_cliente=29444;
	$p->id_remitente=0;
	$p->nombre_remitente="Cripack S.A.S.";
	$p->direccion_remitente="Carrera 6 #21-44";
	$p->telefono_remitente="3873164";
	$p->ciudad_remitente="76001000";
	$p->nit_destinatario="11111";
	$p->div_destinatario="01";
	$p->nombre_destinatario="Prueba Destinatario";
	$p->direccion_destinatario="Kr24 #45-03";
	$p->ciudad_destinatario="05001000";
	$p->telefono_destinatario="58700000";
	$p->valor_declarado=500000;
	$p->codigo_cuenta=1;
	$p->codigo_producto=0;
	$p->nivel_servicio="1";
	$p->linea="";
	$p->contenido="Zapatos";
	$p->referencia="";
	$p->observaciones="cajas delicadas";	
	$p->estado="IMPRESO";
	$p->detalle=array();

	$item1=new stdClass();
	$item1->ubl="0";
	$item1->alto="50";
	$item1->ancho="50";
	$item1->largo="10";
	$item1->peso="10";
	$item1->unidades="1";
	$item1->referencia="";
	$item1->nombre_empaque="";	
	
	array_push($p->detalle,$item1);

	$p->recaudos=array();

	array_push($p->recaudos,$recaudo);

	$p->cuenta_contable="";
	$p->centro_costos="";
	$p->recaudos="";
	$p->margen_izquierdo="3";
	$p->margen_superior="1";
	$p->formato_impresion=0;
	$p->usuario_vmi="";
	$p->atributo1_nombre="";
	$p->atributo1_valor="";
	$p->usuario="cripack.ws";
	$p->clave="c3a68e4d97aa9b683262bc80fe36191610681f64499f23e30b10bb22da279a1c";
	$client = new SoapClient(null, array("location"    =>$url,
									     "uri"         =>$url,
									     "use"         =>SOAP_LITERAL,
										 "trace"       =>true, 
										 "exceptions"  =>true,
										 "soap_version"=>SOAP_1_2,
										 "connection_timeout"=>30,
										 "encoding"=>"utf-8"));

	try{
		echo "Result: ";
		$res=$client->Guias_generarGuia($p);
		echo "<hr><pre>";
		echo print_r($res,1);
		echo "</pre>";
	}catch (SoapFault $e) {
		echo "<pre>".$e->getMessage()."</pre>";
	}
?>
