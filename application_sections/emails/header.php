<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


  </head>
<body>

					<div style="width: 85%; margin: 0px auto; text-align: justify; display: block;font-family: arial;font-size: 14px; ">
		 				<div style ="text-align : left;">
							<?php

							$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
       $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;


							?>
							</div>


