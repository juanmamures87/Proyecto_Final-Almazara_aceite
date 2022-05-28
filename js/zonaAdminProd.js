////////////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA /////////////////////////////////////////////

//Referencia al formulario de producción
const formularioRegistroProduccion = document.getElementById("formularioRegistroProduccion");

//Referencia a los campos del formulario
const busSocioProd = document.getElementById("busSocioProd");
const selSocioProd = document.getElementById("selSocioProd");
const selParcelaProd = document.getElementById("selParcelaProd");
const registroProd = document.getElementById("registroProd");
//Contenedor de ticket remesa con los botones de imprimir
const apartadoTicket = document.getElementById("apartadoTicket");
//Ticket de la remesa de producción que se imprimirá
const ticketRemesaProd = document.getElementById("ticketRemesaProd");

//Referencia al los botones de impresión o cancelación de esta
const imprimir = document.getElementById("imprimir");
const cancelarImpresion = document.getElementById("cancelarImpresion");
const btnImprimirRemesa = document.getElementById("btnImprimirRemesa");

//Referencia a los span del ticket para mostrar los datos del socio y la remesa de producción
const ticketNombreOleicultor = document.getElementById("ticketNombreOleicultor");
const ticketDomicilioOleicultor = document.getElementById("ticketDomicilioOleicultor");
const ticketMunOleicultor = document.getElementById("ticketMunOleicultor");
const ticketProvOleicultor = document.getElementById("ticketProvOleicultor");
const ticketNifOleicultor = document.getElementById("ticketNifOleicultor");
const tablaTicketCuerpo = $("#tablaTicket tbody");//Cuerpo de la tabla del ticket
const ticketDiaFirma = document.getElementById("ticketDiaFirma");
const ticketMesFirma = document.getElementById("ticketMesFirma");
const ticketYearFirma = document.getElementById("ticketYearFirma");

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

//Evento sobre el botón de registrar una producción. Al registrar la remesa aparecerá la opción de imprimir un ticket
//con los datos de esta.
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

                    ticketNombreOleicultor.textContent = data.remesa[0].apellidos + ", " + data.remesa[0].nombre;
                    ticketDomicilioOleicultor.textContent = data.remesa[0].direccion + " " + data.remesa[0].num_casa + " "
                        + data.remesa[0].piso + " " + data.remesa[0].puerta + ", " + data.remesa[0].cp;
                    ticketMunOleicultor.textContent = data.remesa[0].municipio;
                    ticketProvOleicultor.textContent = data.remesa[0].provincia;
                    ticketNifOleicultor.textContent = data.remesa[0].dni

                    tablaTicketCuerpo.empty();
                    tablaTicketCuerpo.append("<tr>" +
                        "<td>" + 'RC: ' +  data.remesa[0].ref_catastral + ' - POL: ' + data.remesa[0].poligono + ' - PAR: ' + data.remesa[0].parcela + "</td>" +
                        "<td>" + data.remesa[0].kg_aceituna + "</td>" +
                        "<td>" + data.remesa[0].tipo_producto + "</td>" +
                        "<td>" + data.remesa[0].litros_aceite + "</td>" +
                        "<td>" + data.remesa[0].rendimiento + "</td>" +
                        "</tr>")

                    ticketDiaFirma.textContent = dia.toString();
                    ticketMesFirma.textContent = nombreMesActual(fecha);
                    ticketYearFirma.textContent = year.toString();

                    if (apartadoTicket.hidden === true){

                        apartadoTicket.hidden = false;

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
                    if (apartadoTicket.hidden === true){

                        apartadoTicket.hidden = false;

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
    if (apartadoTicket.hidden === false){

        apartadoTicket.hidden = true;

    }

})

//Evento sobre el botón de imprimir la remesa de producción introducida, pasándole la función definida con la
//librería html2pdf. Con la que obtenemos un pdf a partir de un fragmento html.
btnImprimirRemesa.addEventListener("click",ticketRemesaprod);

/*/////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////*/

//Función que obtiene el nombre del mes actual con la primera letra en mayúscula
function nombreMesActual(fecha) {

    let nombreMes = fecha.toLocaleString("es-ES", { month: "long" });
    nombreMes = nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1);
    return nombreMes;

}

//Función que crea un pdf imprimible del ticket de la remesa de producción introducida con ayuda de la librería html2pdf.
function ticketRemesaprod() {

    html2pdf()
        .set({

            margin: [15,-200,10,-200],
            filename: 'Albarán_remesa.pdf',
            image:{
                type: 'png',
                quality: 0.98
            },
            html2canvas:{
                scale: 2, // A mayor escala mejores gráficos pero más peso
                letterRendering: true,
            },
            jsPDF:{
                unit: 'pt',
                format: 'a5',
                orientation: 'landscape' //orientación landscape o portrait
            }

        })
        .from(ticketRemesaProd)
        .save()
        .catch(err => console.log(err))
        .finally()

}

