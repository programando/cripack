// JavaScript Document

var Ion = {
	
	init : function()
	{
		console.log("RUN ION");

		$(document).ready(function() {

			var alto = $(window).height();
			var ancho = $(window).width();

			$(".closeModalion").on('click', function() {
				$('.modal').modal('hide');
		  	});

			
			$(".bIngreso").on('click', function() {
				$('.botonoes').slideUp(300);
				$('.dIngreso').slideDown(300);
				$('.dRegistro').slideUp(300);
		  	});
			$(".bRegistro").on('click', function() {
				$('.botonoes').slideUp(300);
				$('.dRegistro').slideDown(300);
				$('.dIngreso').slideUp(300);
		  	});

			$(window).resize(function() {
				var alto = $(window).height();
				var ancho = $(window).width();
				setTimeout('Ion.calcularAlturas()', 10);
				setTimeout('Ion.calcularAlturas()', 1000);
			});

		});

		Ion.calcularAlturas();
		setTimeout('Ion.calcularAlturas()', 100);
		setTimeout('Ion.calcularAlturas()', 1000);

	},

	calcularAlturas : function(){
		var alto = $(window).height();
		var ancho = $(window).width();

		$(".allion").height(alto);
		$(".allionIn").height(alto-200);
		

		 
		

	},


};

Ion.init();



