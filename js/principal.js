
/*********************** CÓDIGOS Y FUNCIONES PARA TODOS LOS ARCHIVOS EN GENERAL ***************************************
*********************************************************************************************************************/

/***************************** MENSAJES DE ERROR - MENSAJE CORRECTO *********************************************/

//referencia a la ventana de error y el botón de cerrar esta ventana
const ventanaError = $("#error");
const cerrarError = $(".fa.fa-times-circle-o.fa-2x");
const ventanaCorrecto = $("#correcto");

//Por defecto el mensaje de error está oculto
cerrarError.hide();
ventanaError.hide();
ventanaCorrecto.hide();

//Función para ocultar el mensaje de error en cualquier momento.
function ocultarMsgError() {

    if (ventanaError.is(':visible') || ventanaCorrecto.is(':visible')){

        cerrarError.slideUp(200);
        ventanaError.slideUp(200);
        ventanaCorrecto.slideUp(200);

    }

}

//Función para ocultar los mensajes de error con un retardo de 2000 milisegundos
function ocultarMsgRetardo() {

    setTimeout(ocultarMsgError,2000);

}

//Función para mostrar el mensaje de error en cualquier momento, pasándole como parámetro el mensaje deseado.
function mostrarMsgError(mensaje) {

    cerrarError.slideDown(200);
    ventanaError.slideDown(200);
    ventanaError.text(mensaje);

}

//Función para mostrar un mensaje cuando se realizan acciones correctas.
function mostrarMsgCorrecto(mensaje){

    cerrarError.slideDown(200);
    ventanaCorrecto.slideDown(200);
    ventanaCorrecto.text(mensaje);

}

//Evento sobre el botón que cierra el mensaje de error o el mensaje correcto.
cerrarError.on('click',function () {

    ventanaError.slideUp(200);
    ventanaCorrecto.slideUp(200);
    cerrarError.slideUp(200);

});


/*******************************************************************************************************************/

/**************************** FUNCIÓN PARA VALIDAR ÚNICAMENTE UN DNI *******************************************/
function validacionDNI(dni){

    let letra = 'TRWAGMYFPDXBNJZSQVHLCKET';

    let expresionRegularDni = /^\d{8}[a-zA-Z]$/; //Comienza con 8 letras y un carácter
    if (!expresionRegularDni.test(dni)){

        mostrarMsgError('¡INTRODUZCA UN DNI CORRECTO!');
        ocultarMsgRetardo();
        return false;

    }

    let miNumero = dni.substring(0, dni.length-1);  //sacamos el número introducido
    let miLetra = dni.substring(dni.length, 8);   //sacamos la letra introducida
    miNumero = miNumero % 23; //sacamos el índice correspondiente a mi letra a partir del número aplicándole el módulo
    let letraSeleccionada = letra.substring(miNumero, miNumero +1);  //Sacamos la letra que me corresponde

    if (letraSeleccionada !== miLetra.toUpperCase()){

        mostrarMsgError('¡LA LETRA DEL DNI NO SE CORRESPONDE!');
        ocultarMsgRetardo();
        return false;
    }

    ocultarMsgError();
    return true;

}

/*******************************************************************************************************************/

