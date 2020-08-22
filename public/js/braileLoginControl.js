btnLogin    = document.getElementById('login-braile');
nitBraile   = document.getElementById('nit-braille');
btnIngresar = document.getElementById('btn-ingresar-braille');

if (btnLogin != null) {
  btnLogin.addEventListener("click", () => {
    window.location.href = "/braille/login";
  });
}
if (btnIngresar != null) {
    btnIngresar.addEventListener('click', () => {
      let valuenitBraile = nitBraile.value;
            $.ajax({
              data:  {"nit" :valuenitBraile},
              dataType: 'json',
              url:      '/braille/terceroRegistrado/',
              type:     'post',
              success: function (response) {
                if (response.existe ) {
                  window.location.href = "/braille/ingreso";
                }
                if (response.esCliente == false && response.existe == false) {
                    window.location.href = "/braille/registro";
                }
                if (response.esCliente) {
                  if (response.esCliente[0]['email'].trim.length == 0) {
                    Mostrar_Mensajes('DATOS INCOMPLETOS', 'No existe un email en nuestra base de datos, por favor registre la siguiente información.');
                    window.location.href = "/braille/registro"; 
                  }
                }
                
            },

        });
    });
}
