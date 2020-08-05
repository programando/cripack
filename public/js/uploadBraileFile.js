const btnEnviar      = document.querySelector("#btnEnviar");
const btnEnviarTexto = document.querySelector("#btnEnviarTexto");
const inputFile      = document.querySelector("#inputFile");

 
btnEnviar.addEventListener("click", () => {
 
     if (inputFile.files.length > 0) {
        let formData = new FormData();
        formData.append("brailleFile", inputFile.files[0]); // En la posición 0; es decir, el primer elemento
        fetch("/braille/fileStarProccess", {
            method: 'POST',
            body: formData,
        })
        .then(respuesta => respuesta.text())
        .then(decodificado => {
                console.log( decodificado);
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
     let Texto          = document.querySelector("#Texto").value;
    let Largo          = document.querySelector("#Largo").value;
    let Alto = document.querySelector("#Alto").value; 
    
    let formData = new FormData();

    formData.append('Texto', Texto);
    formData.append('Largo', Largo);
    formData.append('Alto', Alto);

    fetch("/braille/textTraslate", {
        method: 'POST',
        body: formData,
    })
        .then(respuesta => respuesta.text())
        .then(decodificado => {
            console.log(decodificado);
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