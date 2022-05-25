////////////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA /////////////////////////////////////////////

//Referencia al formulario de producción
const formularioRegistroProduccion = document.getElementById("formularioRegistroProduccion");

//Referencia a los campos del formulario
const busSocioProd = document.getElementById("busSocioProd");
const selSocioProd = document.getElementById("selSocioProd");
const selParcelaProd = document.getElementById("selParcelaProd");
const registroProd = document.getElementById("registroProd");
const apartadoTicket = document.getElementById("apartadoTicket");

//Referencia al los botones de impresión o cancelación de esta
const imprimir = document.getElementById("imprimir");
const cancelarImpresion = document.getElementById("cancelarImpresion");

////////////////////////////////////////////// UTILIZACIÓN DE FUNCIONES //////////////////////////////////////////////



/////////////////////////////////////////////////// EVENTOS /////////////////////////////////////////////////////////

//Evento sobre los campos de búsqueda parcial de socio para escribir por el apellido y recoger las coincidencias.
busSocioProd.addEventListener("keyup", function () {

    let datos = new FormData();
    datos.append("controlador", "admin");
    datos.append("accion", "mostrarSociosXApellidosRegistroParcela");
    datos.append("apellido", busSocioProd.value);

    fetch("index.php", {

        method: "POST",
        body: datos

    })

        .then(response => {

            if (response.ok) {

                return response.json();//tipo de respuesta que esperamos recibir

            } else {

                throw 'ERROR EN LA LLAMADA AJAX';

            }

        })

        .then(data => {

            if (data !== null) {

                selSocioProd.length = 0;
                if (data.length === 0) {

                    let opcion = document.createElement("option");
                    opcion.textContent = "No existen coincidencias";
                    selSocioProd.append(opcion);


                } else {

                    let opcionInicial = document.createElement("option");
                    opcionInicial.value = 'SELECCIONE SOCIO';
                    opcionInicial.textContent = 'SELECCIONE SOCIO';
                    opcionInicial.style.textAlign = "center";
                    selSocioProd.append(opcionInicial);

                    for (let i = 0; i < data.length; i++) {

                        let opcion = document.createElement("option");
                        opcion.value = data[i].id_socio;
                        opcion.textContent = data[i].apellidos + ", " + data[i].nombre;
                        selSocioProd.append(opcion);

                    }
                }
            } else {

                alert('ERROR EN EL OBJETO RECIBIDO')

            }

        })
        .catch(err => {

            alert(err);

        })

})

//Evento sobre el select de elección de usuario para que al seleccionar uno, aparezcan las parcelas que tine disponibles
//En el select de selección de parcela
selSocioProd.addEventListener("change", function () {

    let datos = new FormData();
    datos.append("controlador", "admin");
    datos.append("accion", "mostrarParcelaXsocioProd");
    datos.append("idSocio", selSocioProd.value);

    fetch("index.php", {

        method: "POST",
        body: datos

    })

        .then(response => {

            if (response.ok) {

                return response.json();//tipo de respuesta que esperamos recibir

            } else {

                throw 'ERROR EN LA LLAMADA AJAX';

            }

        })

        .then(data => {

            if (data.length !== 0) {

                selParcelaProd.length = 0;
                if (data.length === 0) {

                    let opcion = document.createElement("option");
                    opcion.textContent = "No existen coincidencias";
                    selParcelaProd.append(opcion);


                } else {

                    let opcionInicial = document.createElement("option");
                    opcionInicial.value = 'SELECCIONE PARCELA';
                    opcionInicial.textContent = 'SELECCIONE PARCELA';
                    opcionInicial.style.textAlign = "center";
                    selParcelaProd.append(opcionInicial);

                    for (let i = 0; i < data.length; i++) {

                        let opcion = document.createElement("option");
                        opcion.value = data[i].id_parcela;
                        opcion.textContent = 'RefCat: ' + data[i].ref_catastral + " - Pol: " + data[i].poligono + ' - Par: ' + data[i].parcela;
                        selParcelaProd.append(opcion);

                    }
                }
            } else {

                mostrarMsgError('ESTE SOCIO NO TIENE NINGUNA PARCELA A SU NOMBRE');
                ocultarMsgRetardo();

            }

        })
        .catch(err => {

            alert(err);

        })

})

//Evento sobre el botón de registrar una producción
registroProd.addEventListener("click",function (e) {

    e.preventDefault();
    let datos = new FormData(formularioRegistroProduccion);
    datos.append("controlador","registro");
    datos.append("accion","insertarProduccion");

    fetch("index.php", {

        method: "POST",
        body: datos

    })

        .then(response => {

            if (response.ok){

                return response.json();//tipo de respuesta que esperamos recibir

            }else{

                throw 'ERROR EN LA LLAMADA AJAX';

            }

        })

        .then(data => {

            if (data !== null) {

                if (data.codigo === 1){

                    mostrarMsgCorrecto(data.msg + " - " + data.msgAceite);
                    formularioRegistroProduccion.reset();
                    if (apartadoTicket.hidden === false){

                        apartadoTicket.hidden = true;

                    }

                }else if(data.codigo === -1 || data.codigo === -2){

                    mostrarMsgError(data.msg);
                    formularioRegistroProduccion.reset();

                }else{

                    mostrarMsgCorrecto(data.msg);
                    ocultarMsgRetardo();
                    setTimeout(function () {

                        mostrarMsgError(data.msgAceite);

                    },1000);
                    formularioRegistroProduccion.reset();
                    if (apartadoTicket.hidden === false){

                        apartadoTicket.hidden = true;

                    }

                }

            }else{

                alert('ERROR EN EL OBJETO RECIBIDO')

            }

        })
        .catch(err => {

            alert(err);

        })



})

//Evento sobre el botón de cancelar impresión para ocultar el ticket
cancelarImpresion.addEventListener("click",function (e) {

    e.preventDefault();
    if (apartadoTicket.hidden === true){

        apartadoTicket.hidden = false;

    }

})

//////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////


