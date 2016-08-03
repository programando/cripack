$(document).ready(function(){

   $(".submit").click(function(event){
   			event.preventDefault();
   			var fecha_consulta = $("#fecha").val();
   			Terceros_Vendedores_Agenda_Consultar(fecha_consulta);
   			});


   function Terceros_Vendedores_Agenda_Consultar(fecha_consulta)
   {
   		try
   		{
   				if (fecha_consulta.length>0 )
   				{
									var parametros ={'fecha_consulta':fecha_consulta};
										$.ajax(
										{
												type :  "post",
												dataType: 'json',
												url  :  '/cripack/terceros/visitas_consultar_agenda_x_vendedor/',
												data :  parametros,
												success: Terceros_Vendedores_Agenda_Mostrar,
												error : callback_error
											});
								}
						}
						catch(ex)
							{
									alert(ex.description);
								}
							return false;
			  }

function Terceros_Vendedores_Agenda_Procesar_Respuesta(ajaxResponse)
{
		  // observa que aquí asumimos que el resultado es un objeto
    // serializado en JSON, razón por la cual tomamos este dato
    // y lo procesamos para recuperar un objeto que podamos
    // manejar fácilmente

   if (typeof ajaxResponse == "string")
      ajaxResponse = $.parseJSON(ajaxResponse);
						return ajaxResponse;
}

function Terceros_Vendedores_Agenda_Mostrar(ajaxResponse, textStatus)
{
		var Agenda = Terceros_Vendedores_Agenda_Procesar_Respuesta(ajaxResponse);
    if (!Agenda)
    {
       return;
    }
				var $tabla = $("#tblAgenda");
				var RegistroAgenda;

				var horaReal;
				$tabla.find("tr:gt(0)").remove();
				for (var idx in Agenda)
		    {
								RegistroAgenda = Agenda[idx];
								horaReal = Formato_Hora(RegistroAgenda.hora,RegistroAgenda.minutos);
		    		$tabla.append(
		            "<tr><td class='hora'>" + horaReal +
		            "</td><td class='cliente'>" + RegistroAgenda.nomtercero +
		            "</td><td class='motivo'>" + RegistroAgenda.nommtvovisita +
		            "</td><td class='resultado'>" + RegistroAgenda.resultados +
		            "</td></tr>");
		    		//texto = texto +   '{\"id\"' + '},'; //'"{\"id\":"' + RegistroAgenda.idregistro +',' },";
    	}

    	//eventJS.AppendFormat("{{\"id\": {0}, \"start\": \"{1}\", \"end\": \"{2}\", \"title\": \"{3}\"}},{4}", reservation.Id, reservation.Start.Value.ToString("s"), reservation.End.Value.ToString("s"), reservation.Title, Environment.NewLine);
    //{"id":10, "start": "2014-10-28T08:00:00.000+10:00", "end": "2014-10-28T08:30:00.000+10:00","title":"Lunch with Mike"},
    	//alert(texto );
  }



function callback_error(XMLHttpRequest, textStatus, errorThrown)
{
    // en ambientes serios esto debe manejarse con mucho cuidado,
    // aquí optamos por una solución simple
    alert(errorThrown);
}


function Formato_Hora(hora,minutos)
			{
					var horaReal;
					hora           = parseInt(hora);

			 		if (minutos=="0")
								{  minutos =':00'; }
							 else {  minutos = ":"+minutos; 	}

							    				switch(hora) {
								    					case 7:
													       horaReal = "07" + minutos +" AM";
													       break;
								    					case 8:
													       horaReal = "08" + minutos +" AM";
													       break;
								    					case 9:
													       horaReal = "09" + minutos +" AM";
													       break;
								    					case 10:
													       horaReal = "10" + minutos +" AM";
													       break;
								    					case 11:
													       horaReal = "11" + minutos +" AM";
													       break;
								    					case 12:
													       horaReal = "12" + minutos +" PM";
													       break;
													    case 13:
													        horaReal = "01" + minutos +" PM";
													        break;
													    case 14:
													         horaReal = "02" + minutos +" PM";
													        break;
													    case 15:
													        horaReal = "03" + minutos +" PM";
															  case 16:
													        horaReal = "04" + minutos +" PM";;
													        break;
													    case 17:
													         horaReal = "05" + minutos +" PM";
													        break;
													    case 18:
													        horaReal = "06" + minutos +" PM";
								    					case 19:
													       horaReal  = "07" + minutos +" PM";
													       break;
													    default:
													        horaReal = RegistroAgenda.hora + minutos + "AM";
													        break;
														}
											return horaReal;
			  }

});
