
//Referenciamos los campos del dni y su padre para mostrar el error cuando dni sea erroneo
const dni = $(".input100.dni");
const alertaDni = $(".wrap-input100.dni");

//Referenciamos los campos de la contraseña y su padre para mostrar el error cuando la contraseña tenga espacios
const pssw = $(".input100.pass");
const alertaPass = $(".wrap-input100.pass");

//Referenciamos el formulario
const formulario = $(".validate-form");

//Evento sobre el formulario para enviarlo, si los datos son erróneos interrumpe el envío y muestra mensaje de error
formulario.on("submit",function (e) {

    if (dni.val() !== "" && !validacionDNI(dni,alertaDni)){

        e.preventDefault();
        showValidate(dni);

    }
    if (pssw.val() !== "" && !validarPasswd(pssw,alertaPass)){

        e.preventDefault();
        showValidate(pssw);

    }else if (dni.val() === "" && pssw.val() !== ""){

        e.preventDefault();
        alertaDni.attr('data-validate','¡Debe rellenar el campo!');
        showValidate(dni);

    }else if (pssw.val() === "" && dni.val() !== ""){

        e.preventDefault();
        alertaPass.attr('data-validate','¡Debe rellenar el campo!');
        showValidate(pssw);

    }else if(pssw.val() === "" && dni.val() === ""){

        e.preventDefault();
        alertaDni.attr('data-validate','¡Debe rellenar el campo!');
        alertaPass.attr('data-validate','¡Debe rellenar el campo!');
        showValidate(pssw);
        showValidate(dni);

    }

})

quitaAlerta(dni,alertaDni);
quitaAlerta(pssw,alertaPass);

//Función que muestra el mensaje de error en el campo correspondiente
function showValidate(input) {
    var thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-validate');
}

//Función para la comprobación del dni. Si está mal escrito o si la letra no se corresponde.
function validacionDNI(dni,alertaDni){

    let letra = 'TRWAGMYFPDXBNJZSQVHLCKET';

    let expresionRegularDni = /^\d{8}[a-zA-Z]$/; //Comienza con 8 letras y un carácter
    if (!expresionRegularDni.test(dni.val())){

        alertaDni.attr('data-validate','¡Introduzca un dni correcto!');
        return false;

    }

    let miNumero = dni.val().substring(0, dni.val().length-1);  //sacamos el número introducido
    let miLetra = dni.val().substring(dni.val().length, 8);   //sacamos la letra introducida
    miNumero = miNumero % 23; //sacamos el índice correspondiente a mi letra a partir del número aplicándole el módulo
    let letraSeleccionada = letra.substring(miNumero, miNumero +1);  //Sacamos la letra que me corresponde

    if (letraSeleccionada !== miLetra.toUpperCase()){

        alertaDni.attr("data-validate",'¡La letra del dni no se corresponde!');
        return false;
    }

    return true;

}

//Función que valida que la contraseña introducida no tenga espacios
function validarPasswd(pass, alertaPass){

    let espacios = false;
    let cont = 0;

    while (!espacios && (cont < pass.val().length)){

        if (pass.val().charAt(cont) === " ")

            espacios = true;
        cont++;

    }

    if (espacios){

        alertaPass.attr("data-validate",'¡La contraseña no puede contener espacios en blanco!');
        return false;

    }

    return true;

}

/*Al hacer foco en cualquier campo y existe la clase de alerta la elimina para poder escribir en él.
* Recibe por parámetros el campo sobre el que se efectuará la acción y la alerta que se eliminará*/
function quitaAlerta(campo,alerta) {

    campo.on('focus',function () {

        if (alerta.hasClass("alert-validate")) {
            alerta.removeClass("alert-validate");
            campo.val("");
        }
    })

}

/***************************** MENSAJES DE ERROR *********************************************/

//referencia a la ventana de error y el botón de cerrar esta ventana
const ventanaError = $("#errorSocios");
const cerrarError = $(".fa.fa-times-circle-o.fa-2x");
const msgErrorLogin = $("#msgErrorLogin");

//Por defecto el mensaje de error está oculto
cerrarError.hide();
ventanaError.hide();

if(msgErrorLogin.text() !== ""){

    mostrarMsgError(msgErrorLogin.text())
    ocultarMsgRetardo();
    msgErrorLogin.text("");

}
//Función para ocultar el mensaje de error en cualquier momento.
function ocultarMsgError() {

    if (ventanaError.is(':visible')){

        cerrarError.slideUp(200);
        ventanaError.slideUp(200);

    }

}

//Función para ocultar los mensajes de error con un retardo de 2000 milisegundos
function ocultarMsgRetardo() {

    setTimeout(ocultarMsgError,3000);

}

//Función para mostrar el mensaje de error en cualquier momento, pasándole como parámetro el mensaje deseado.
function mostrarMsgError(mensaje) {

    cerrarError.slideDown(200);
    ventanaError.slideDown(200);
    ventanaError.text(mensaje);

}

//Evento sobre el botón que cierra el mensaje de error o el mensaje correcto.
cerrarError.on('click',function () {

    ventanaError.slideUp(200);
    cerrarError.slideUp(200);

});


/*******************************************************************************************************************/