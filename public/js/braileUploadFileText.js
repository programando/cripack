const btnEnviar       = document.querySelector("#btnEnviar");
const btnEnviarTexto  = document.querySelector("#btnEnviarTexto");
const inputFile       = document.querySelector("#inputFile");
const btnEnviarCorreo = document.querySelector('#btnEnviarCorreo');
$('#myProgress').hide();
 
btnEnviarCorreo.classList.add('hide');




btnEnviarCorreo.addEventListener("click", () => {
          fetch("/braille/sendEmail", {
            method: 'POST',
            body: '',
        })
        .then(respuesta => respuesta.text())
            .then(decodificado => { 
                  Mostrar_Mensajes('CONFIRMACIÓN CORREO ELECTRÓNICO', "Hemos enviado un mensaje a la cuenta de correo registrada con información sobre la transcripción.");
            }); 
})
 
btnEnviar.addEventListener("click", () => {
  newRecord();   
  if (inputFile.files.length > 0) {
        let formData = new FormData();
         formData.append("brailleFile", inputFile.files[0]); // En la posición 0; es decir, el primer elemento
         move();
        fetch("/braille/fileStarProccess", {
            method: 'POST',
            body: formData,
        })
        .then(respuesta => respuesta.text())
          .then(decodificado => {  
              btnEnviarCorreo.classList.remove('hide');
              showAnswer(decodificado);
         });
        
    } else {
        // El usuario no ha seleccionado archivos
        alert("Selecciona un archivo");
    }  
});

btnEnviarTexto.addEventListener("click", () => {
    var res = validarEntradaManual();
    if (res == false) {
        return;
  }
  newRecord();
     let Texto = document.querySelector("#Texto").value;
     let Largo = document.querySelector("#Largo").value;
     let Alto  = document.querySelector("#Alto").value;
   
    let formData = new FormData();
    formData.append('Texto', Texto);
    formData.append('Largo', Largo);
    formData.append('Alto', Alto);
    formData.append('TextArray', Texto.split(""));


    fetch("/braille/textTraslate", {
        method: 'POST',
        body: formData,
    })  
      .then(respuesta => respuesta.text())
       .then(decodificado => {
           btnEnviarCorreo.classList.remove('hide');
            showAnswer(decodificado);
        });
});

function validarEntradaManual() {
    let Texto          = document.querySelector("#Texto").value;
    let Largo          = document.querySelector("#Largo").value;
    let Alto           = document.querySelector("#Alto").value;   
    if (Texto == "") {
        alert("Digite un texto para continuar.");
        return false;
    }
      if (Largo.length == 0) {
        alert("Registre el largo de la caja para continuar.");
        return false;
    }  
    if (Alto.length == 0) {
        alert("Registre el alto de la caja para continuar.");
        return false;
    } 
    return true;
}

var i = 0;
function move() {
  $('#myProgress').show();
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 1;
    var id = setInterval(frame, 20);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
      }
    }
  }
  elem.value = "procesando datos... por favor espere...";
}

function newRecord() {
  $('.contenido-respuesta').html('');
}

function showAnswer(resultado) {
    $('.contenido-respuesta').html('');
    $('.contenido-respuesta').html(resultado);
    $('#myProgress').hide(); 
}
