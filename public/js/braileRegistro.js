identificacion = document.getElementById('braile-nit');
nombre         = document.getElementById('braile-nom');
telefonos      = document.getElementById('braile-telefonos');
email_1        = document.getElementById('braile-email-1');
email_2        = document.getElementById('braile-email-2');
btnRegistro    = document.getElementById('braile-btn-registro');


 
btnRegistro.addEventListener('click', () => {
   let resValidaciones = runValidations();
   if (resValidaciones == false) {
      return;
    }
    let formData = new FormData();
    formData.append('identificacion', identificacion.value);
    formData.append('nombre', nombre.value);
    formData.append('telefonos', telefonos.value);
    formData.append('email_1', email_1.value);
    formData.append('email_2', email_2.value);
       $.ajax({
          data:  {"identificacion" :identificacion.value, "nombre":nombre.value, "telefonos":telefonos.value, "email_1":email_1.value, "email_2":email_2.value },
          dataType: 'json',
          url:      '/braille/newRegistro/',
          type:     'post',
          success: function (response) {
             Mostrar_Mensajes('CONFIRMACIÓN CORREO ELECTRÓNICO', "Hemos enviado un mensaje a la cuenta de correo registrada. Debes confirmar dicha cuenta para hacer uso del sistema de transcripción.");
        },
    });    
});

function runValidations() {
  let mensaje = '';
 
  if (isNaN(identificacion.value) == true) {
    mensaje = '( * ) En la identificación sólo puede registrar números sin espacios ni caracteres especiales.<br>';
  }
  if ( jQuery.trim(nombre.value).length == 0) {
    mensaje +=   '( * ) Debe registrar el nombre para identificar el registro.<br>';
  }

  if ( jQuery.trim(telefonos.value).length == 0) {
    mensaje +=   '( * ) Registre un número de teléfono para posteriores contactos.<br>';
  }
  
  if ( jQuery.trim(email_1.value).length == 0   ) {
    mensaje +=   '( * ) Debe registrar una cuenta de correo válida a la cual enviaremos mensaje para confirmar el registro.<br>';
  }
 
  if (mensaje.length > 0) {
    Mostrar_Mensajes('DATOS INCORRECTOS', mensaje);
  } else {
    return true;
  }
  
}