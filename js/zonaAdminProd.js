////////////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA /////////////////////////////////////////////

//Referencia al apartado de las producciones
const seccionProduccion  = $('#seccionProduccion');

//Referencia al formulario de producción
const formularioRegistroProduccion = document.getElementById("formularioRegistroProduccion");

//Referencia a los campos del formulario
const busSocioProd = document.getElementById("busSocioProd");
const selSocioProd = document.getElementById("selSocioProd");
const selParcelaProd = document.getElementById("selParcelaProd");
const selTipoProd = document.getElementById('selTipoProd');
const kgProd = document.getElementById('kgProd');
const renProd = document.getElementById('renProd');
const acidezProd = document.getElementById('acidezProd');
const registroProd = document.getElementById("registroProd");
const resetFormProd = document.getElementById('resetFormProd');

//Contenedor de ticket remesa con los botones de imprimir
const apartadoTicket = document.getElementById("apartadoTicket");
//Ticket de la remesa de producción que se imprimirá
const ticketRemesaProd = document.getElementById("ticketRemesaProd");

//Referencia al los botones de impresión o cancelación de esta
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

//Referencia a los campos del menú lateral de mostrar los datos de las producciones
const busSocioProdMuestra = document.getElementById('busSocioProdMuestra');
const selSocioProdMuestra = document.getElementById('selSocioProdMuestra');
const busProdTemporada = document.getElementById("busProdTemporada");

//Referencia a la tabla que muestra los datos de la producción
const tablaProduccion = document.getElementById('tablaProduccion');
const tablaProdCuerpo = $("#tablaProduccion tbody")
const navPaginacionProduccion = $("#navPaginacionProduccion ul");
const muestraPaginaProduccion = $("#muestraPaginaProduccion")

////////////////////////////////////////////// UTILIZACIÓN DE FUNCIONES //////////////////////////////////////////////

busquedaParcialSocios(busSocioProdMuestra,selSocioProdMuestra);

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
    if (validarCamposProduccion()) {

        let datos = new FormData(formularioRegistroProduccion);
        datos.append("controlador", "registro");
        datos.append("accion", "insertarProduccion");

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

                    if (data.codigo === 1) {

                        mostrarMsgCorrecto(data.msg + " - " + data.msgAceite);
                        formularioRegistroProduccion.reset();
                        resetearSocioParcela();

                        //Rellenamos el ticket con los datos del socio que ha insertado la última producción para dar la
                        //posibilidad de imprimir un ticket con los datos
                        ticketNombreOleicultor.textContent = data.remesa[0].apellidos + ", " + data.remesa[0].nombre;
                        ticketDomicilioOleicultor.textContent = data.remesa[0].direccion + " " + data.remesa[0].num_casa + " "
                            + data.remesa[0].piso + " " + data.remesa[0].puerta + ", " + data.remesa[0].cp;
                        ticketMunOleicultor.textContent = data.remesa[0].municipio;
                        ticketProvOleicultor.textContent = data.remesa[0].provincia;
                        ticketNifOleicultor.textContent = data.remesa[0].dni

                        tablaTicketCuerpo.empty();
                        tablaTicketCuerpo.append("<tr>" +
                            "<td>" + 'RC: ' + data.remesa[0].ref_catastral + ' - POL: ' + data.remesa[0].poligono + ' - PAR: ' + data.remesa[0].parcela + "</td>" +
                            "<td>" + data.remesa[0].kg_aceituna + "</td>" +
                            "<td>" + data.remesa[0].tipo_producto + "</td>" +
                            "<td>" + data.remesa[0].litros_aceite + "</td>" +
                            "<td>" + data.remesa[0].rendimiento + "</td>" +
                            "</tr>")

                        ticketDiaFirma.textContent = dia.toString();
                        ticketMesFirma.textContent = nombreMesActual(fecha);
                        ticketYearFirma.textContent = year.toString();

                        if (apartadoTicket.hidden === true) {

                            apartadoTicket.hidden = false;
                            tablaProduccion.hidden = true;
                            if (navPaginacionProduccion.is(':visible')){

                                navPaginacionProduccion.hide();

                            }

                        }

                    } else if (data.codigo === -1 || data.codigo === -2) {

                        mostrarMsgError(data.msg);
                        formularioRegistroProduccion.reset();
                        resetearSocioParcela();

                    } else {

                        mostrarMsgCorrecto(data.msg);
                        ocultarMsgRetardo();
                        setTimeout(function () {

                            mostrarMsgError(data.msgAceite);

                        }, 1000);
                        formularioRegistroProduccion.reset();
                        if (apartadoTicket.hidden === true) {

                            apartadoTicket.hidden = false;

                        }

                    }

                } else {

                    alert('ERROR EN EL OBJETO RECIBIDO')

                }

            })
            .catch(err => {

                alert(err);

            })

    }

})

//Evento sobre el botón de resetear, que inicializa todos los campos además de los campos de selección de socio y
// selección de parcela adem
resetFormProd.addEventListener("click",function (){

    resetearSocioParcela();

})

//Evento sobre el botón de cancelar impresión para ocultar el ticket
cancelarImpresion.addEventListener("click",function (e) {

    e.preventDefault();
    if (apartadoTicket.hidden === false){

        apartadoTicket.hidden = true;
        tablaProduccion.hidden = false;
        if (navPaginacionProduccion.is(':hidden')){

            navPaginacionProduccion.show();

        }

    }

})

//Evento sobre el botón de imprimir la remesa de producción introducida, pasándole la función definida con la
//librería html2pdf. Con la que obtenemos un pdf a partir de un fragmento html.
btnImprimirRemesa.addEventListener("click",ticketRemesaprod);

//Evento de cambio sobre el select de selección de temporadas del menú lateral de muestra de datos,
//para ver las producciones de la BBDD
busProdTemporada.addEventListener("change",function () {

    if(isNaN(selSocioProdMuestra.value) === false) {
        let datos = new FormData();
        datos.append("controlador", "admin");
        datos.append("accion", "mostrarProdXsocioTemporada");
        datos.append("idSocio", selSocioProdMuestra.value);
        datos.append("temporada", busProdTemporada.value);

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

                    ocultarMsgError();
                    let paginas = data.paginas;
                    cuerpoTablaProduccion(data)

                    navPaginacionProduccion.empty();

                    for (let i = 1; i <= paginas; i++) {

                        navPaginacionProduccion.append('<li data-socio="' + selSocioProdMuestra.value + '" ' +
                            'data-accion="mostrarProdXsocioTemporada" data-temporada="' + busProdTemporada.value + '" ' +
                            'data-pagina="' + i + '" class="page-item prodTemp"><a class="page-link" ' +
                            'href="">' + i + '</a></li>');

                    }

                    muestraPaginaProduccion.text(this.dataset.pagina);

                    //Reinicia los campos de busqueda
                    busSocioProdMuestra.value = "";
                    selSocioProdMuestra.length = 0;
                    let opcion = document.createElement("option");
                    opcion.value = 'SELECCIONE SOCIO';
                    opcion.textContent = 'SELECCIONE SOCIO';
                    opcion.style.textAlign = "center";
                    selSocioProdMuestra.append(opcion);
                    busProdTemporada.value = 'TEMPORADA';

                } else {

                    mostrarMsgError('ESTE SOCIO NO TIENE REMESAS DE PRODUCCIONES EN ESTA TEMPORADA');
                    ocultarMsgRetardo();

                }

            })
            .catch(err => {

                alert(err);

            })
    }else{

        mostrarMsgError('DEBE SELECCIONAR UN SOCIO VÁLIDO PARA PODER VER LAS REMESAS DE PRODUCCIÓN');
        busProdTemporada.value = 'TEMPORADA';

    }
})

//Evento sobre los botones de paginación de la tabla cuando la búsqueda es por temporada
seccionProduccion.on("click",".page-item.prodTemp",function (e) {

    e.preventDefault();
    this.classList.add('active')

    let datos = new FormData();
    datos.append("pagina",this.dataset.pagina);
    datos.append("controlador","admin");
    datos.append("accion",this.dataset.accion);
    datos.append("idSocio",this.dataset.socio);
    datos.append("temporada",this.dataset.temporada);

    fetch("index.php", {

        method: "POST",
        body: datos

    })

        .then(response => {

            if (response.ok){

                return response.json();//tipo de respuesta que esperamos recibir

            }else{

                throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

            }

        })

        .then(data => {

            if (data.length !== 0) {

                let paginas = data.paginas;
                cuerpoTablaProduccion(data)

                navPaginacionProduccion.empty();

                for (let i = 1; i <= paginas; i++) {

                    navPaginacionProduccion.append('<li data-socio="' + this.dataset.socio + '" ' +
                        'data-accion="' + this.dataset.accion + '" data-temporada="' + this.dataset.temporada + '"' +
                        'data-pagina="' + i + '" class="page-item prodTemp"><a class="page-link" ' +
                        'href="">' + i + '</a></li>');

                }

                muestraPaginaProduccion.text(this.dataset.pagina);

            }else{

                tablaProdCuerpo.empty();
                navPaginacionProduccion.empty();
                mostrarMsgError('NO EXISTEN REMESAS CON ESOS DATOS');
                ocultarMsgRetardo();

            }

        })
        .catch(err => {

            alert(err);

        })

})

/*/////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////*/

//Función para validar los campos a la hora de insertar una producción
function validarCamposProduccion() {

    if (selSocioProd.value === 'SOCIOS' || selSocioProd.value === 'SELECCIONE SOCIO'){

        mostrarMsgError('DEBE SELECCIONAR UN SOCIO VALIDO');
        ocultarMsgRetardo();
        return false;

    }

    if (selParcelaProd.value === 'PARCELA' || selParcelaProd.value === 'SELECCIONE PARCELA'){

        mostrarMsgError('DEBE SELECCIONAR UNA PARCELA VÁLIDA');
        ocultarMsgRetardo();
        return false;

    }

    if (selTipoProd.value === 'TIPO PRODUCTO'){

        mostrarMsgError('DEBE SELECCIONAR UN TIPO DE RECOGIDA VÁLIDO');
        ocultarMsgRetardo();
        return false;

    }

    if (kgProd.value < 50){

        mostrarMsgError('DEBE INTRODUCIR UNA CANTIDAD MÍN. DE 50KG DE ACEITUNA');
        ocultarMsgRetardo();
        return false;

    }

    if(renProd.value < 18 || renProd.value > 25){

        mostrarMsgError('EL RENDIMIENTO GRASO DEBE ESTAR ENTRE EL 18% Y EL 25%');
        ocultarMsgRetardo();
        return false;

    }

    if(acidezProd.value < 0 || acidezProd.value > 2){

        mostrarMsgError('LA ACIDEZ DEL PRODUCTO DEBE ESTAR ENTRE 0 Y 2');
        ocultarMsgRetardo();
        return false;

    }

    ocultarMsgError();
    return true;

}

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

//Función que resetea el campo de selección de socio y el de selección de parcela
function resetearSocioParcela() {

    selParcelaProd.length = 0;
    let optionParProd = document.createElement("option");
    optionParProd.textContent = "PARCELA";
    optionParProd.value = "PARCELA";
    optionParProd.className = "text-center";
    selParcelaProd.appendChild(optionParProd);

    selSocioProd.length = 0;
    let opcion = document.createElement("option");
    opcion.value = 'SOCIOS';
    opcion.textContent = 'SOCIOS';
    opcion.className = "text-center";
    selSocioProd.append(opcion);

}

//Función que genera el cuerpo de la tabla de muestra de datos de la zona de producción
function cuerpoTablaProduccion(data) {

    tablaProdCuerpo.empty();

    for (let i = 0; i < data.remesas.length; i++) {

        //Damos formato a la fecha extraída de la BBDD
        let extraerFecha = data.remesas[i].fecha_entrada.split("-");
        let nuevaFechaEntrada = extraerFecha[2] + "/" + extraerFecha[1] + "/" + extraerFecha[0];

        tablaProdCuerpo.append('<tr>' +
            '<th>' + data.remesas[i].id_albaran + '</th>' +
            '<th>' + data.remesas[i].id_socio + '</th>' +
            '<td>' + data.remesas[i].apellidos + '</td>' +
            '<td>' + data.remesas[i].nombre + '</td>' +
            '<td>' + data.remesas[i].provincia + '</td>' +
            '<td>' + data.remesas[i].municipio + '</td>' +
            '<td>' + data.remesas[i].ref_catastral + '</td>'+
            '<td>' + data.remesas[i].poligono + '</td>'+
            '<td>' + data.remesas[i].parcela + '</td>' +
            '<td>' + data.remesas[i].kg_aceituna + '</td>' +
            '<td>' + data.remesas[i].rendimiento + '</td>' +
            '<td>' + data.remesas[i].litros_aceite + '</td>' +
            '<td>' + data.remesas[i].acidez + '</td>' +
            '<td>' + data.remesas[i].tipo_producto + '</td>' +
            '<td>' + nuevaFechaEntrada + '</td>' +
            '<td>' + data.remesas[i].hora_entrada + '</td>' +
            '</tr>');

    }

}

