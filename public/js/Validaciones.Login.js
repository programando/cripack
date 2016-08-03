$(document).ready(function(){

   /* $('#form-login').validate({
        rules:{
            identificacion:{
                required: true
            },
            password:{
                required: true
            }
        },
        messages:{
            identificacion: {
                required: "Debe registrar el número de identificación."
            },
            password:{
                required: "Debe registrar su clave de ingreso."
            }
        }
    });
*/





//FUNCION PARA QUE SOLO SE REGISTREN VALORES NUMÉRICOS
$("#identificacion").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }

   if (event.keyCode == 46 || event.keyCode == 8)
   {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57)
          {
                event.preventDefault();
          }
        }
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });

});
