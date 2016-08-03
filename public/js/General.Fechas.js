
$(document).ready(function(){
	    $( "#tabs" ).tabs();
					$('#fecha_proxvisita').datetimepicker({
					 lang:'es',
					 timepicker:true,
					 format:'d/m/Y H:i A',
					 step:15,
					 validateOnBlur:true,
					 hours12:false,
					 allowTimes:[
					  '07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30', '12:00',
					  '12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00'
					]
					});

					$('#fecha_visita').datetimepicker({
					 lang:'es',
					 timepicker:false,
					 datepicker:true,
					  format:'d/m/Y'
					});


					$('#fecha').datetimepicker({
					 lang:'es',
					 timepicker:false,
					 datepicker:true,
					  format:'d/m/Y'
					});

});

