/*********************************************************************************************************************
 * ************************ APARTADO DE LAS PARCELAS. REGISTRO Y CONSULTAS ******************************************
 * ********************************************************************************************************************/

////////////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA /////////////////////////////////////////////

const seccionParcelas = $("#seccionParcelas");

//Referencia al formulario del registro de las parcelas
const formularioRegistroParcelas = document.getElementById("formularioRegistroParcelas");

//Referenciamos los campos de formulario de registro de las parcelas
const selProvParcela = document.getElementById("selProvParcela");
const selMunParcela = document.getElementById("selMunParcela");
const refCatParcela = document.getElementById("refCatParcela");
const selSocioParcela = document.getElementById("selSocioParcela");
const busSocioParcela = document.getElementById("busSocioParcela");
const polParcela = document.getElementById("polParcela");
const parParcela  =document.getElementById("parParcela");
const superParcela = document.getElementById("superParcela");
const selSisParcela = document.getElementById("selSisParcela");
const selVarParcela = document.getElementById("selVarParcela");
const plantasParcela = document.getElementById("plantasParcela");
const tablaParcelasBody = $("#tablaParcelas tbody")
const navPaginacionParcelas = $("#navPaginacionParcelas ul");
const muestraPaginaParcelas = $("#muestraPaginaParcelas");

//Zona de selección para muestra de parcelas
const busSocioParcelaMuestra = document.getElementById("busSocioParcelaMuestra");
const selSocioParcelaMuestra = document.getElementById("selSocioParcelaMuestra");
const busProv = document.getElementById("busProv");
const busSuper = document.getElementById("busSuper");
const busSisCul = document.getElementById("busSisCul");
const busVar = document.getElementById("busVar");
const busPlan = document.getElementById("busPlan");

let ventanaParcela; //Variable para la apertura y cierrre de la ventana del catastro con la parcela
let introducirRefCat; //Variable con el nombre del setTimeout y la función para la validación de la ref.Catastral introducida

//Referencia a los botones de registrar parcela y resetear campos
const registroParcelas = document.getElementById("registroParcelas");
const resetFormParcelas = document.getElementById("resetFormParcelas");

////////////////////////////////////////////// UTILIZACIÓN DE FUNCIONES //////////////////////////////////////////////

//Búsqueda parcial en la zona de registro de las parcelas
busquedaParcialSocios(busSocioParcela,selSocioParcela)

//Búsqueda parcial en la zona de muestra de parcelas
busquedaParcialSocios(busSocioParcelaMuestra,selSocioParcelaMuestra)

//Muestra de las parcelas seleccionadas por provincia
muestraDatosParcelas(busProv, 'mostrarParcelaXprov', 'PROVINCIA')

//Muestra de las parcelas seleccionadas por sistema de cultivo
muestraDatosParcelas(busSisCul, 'mostrarParcelaXsistema', 'SISTEMA CULTIVO')

//Muestra de las parcelas seleccionadas por variedad de cultivo
muestraDatosParcelas(busVar, 'mostrarParcelaXvariedad', 'VARIEDAD ACEITUNA')

//Muestra de las parcelas seleccionadas por superficie de cultivo
muestraDatosParcelas(busSuper, 'mostrarParcelaXsuperficie', 'SUPERFICIE')

//Muestra de las parcelas seleccionadas por número de plantas
muestraDatosParcelas(busPlan, 'mostrarPracelaXplantas', 'PLANTAS')

/////////////////////////////////////////////////// EVENTOS /////////////////////////////////////////////////////////

//Con este evento añadimos los municipios al select correspondiente según la provincia seleccionada
selProvParcela.addEventListener("change",function () {

    if (selProvParcela.value === "PROVINCIA"){

        selMunParcela.length = 0;
        let optionMunPar = document.createElement("option");
        optionMunPar.textContent = "MUNICIPIO";
        optionMunPar.value = "MUNICIPIO";
        optionMunPar.className = "text-center";
        selMunParcela.appendChild(optionMunPar);

    }else {

        const datos = new FormData();
        datos.append('controlador', 'registro');
        datos.append('accion', 'muestraMunicipio');
        datos.append('Provincia', selProvParcela.value);

        fetch("index.php", {

            method: "POST",
            body: datos

        })

            .then(response => {

                if (response.ok) {

                    return response.json();//tipo de respuesta que esperamos recibir

                } else {

                    throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

                }

            })

            .then(data => {

                let Obj = data;
                if (Obj !== null) {

                    selMunParcela.length = 0;

                    for (let i = 0; i < Obj.length; i++) {

                        let option = document.createElement("option");
                        option.textContent = Obj[i];
                        option.value = Obj[i];
                        selMunParcela.appendChild(option);

                    }

                } else {

                    alert("¡¡ERROR EN LA SELECCIÓN DE LAS PROVINCIAS!!")

                }

            })
            .catch(err => {

                alert(err);

            })

    }

})

//Evento sobre el campo de la ref. catastral para validarla y que muestre mapa del catastro con datos
refCatParcela.addEventListener('keydown', () => {

    clearTimeout(introducirRefCat)

    introducirRefCat = setTimeout(() => {

        if (validacionRefCat()) {

            ventanaParcela = window.open('https://www1.sedecatastro.gob.es/Cartografia/mapa.aspx?refcat=' + refCatParcela.value + '',
                "_blank", "width=400, height=500, toolbar=no, menubar=no, location=no, status=no, " +
                "resizable=yes, popup=yes, top=400px, left=1200px")

            //Este código comentado para ver si soluciono lo del catastro que no recoge la RC de la parcela
            //A ver si hay posible solución.
            /*let datos = new FormData();
            datos.append('refcat', refCatParcela.value);
            datos.append("provincia",selProvParcela.value);
            datos.append("municipio",selMunParcela.value);
            datos.append('controlador', 'admin');
            datos.append('accion', 'mostrarPoliParceSuperf');
            console.log(datos.get("refcat"));
            console.log(datos.get("provincia"));
            console.log(datos.get("municipio"));

            fetch("index.php", {

                method: "POST",
                body: datos

            })

                .then(response => {

                    if (response.ok) {

                        return response.text();//tipo de respuesta que esperamos recibir

                    } else {

                        throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

                    }

                })

                .then(data => {

                    if (data !== null) {

                        console.log(data);

                    } else {

                        alert("¡¡OBJETO RECIBIDO INCORRECTO!!")

                    }

                })
                .catch(err => {

                    alert(err);

                })*/
        }
        clearTimeout(introducirRefCat)
    }, 1000)

})

//Evento sobre el botón de resetear los campos de registro de las parcelas. Que además de hacer su función resetea el
//select de municipio y el de la búsqueda parcial de socio
resetFormParcelas.addEventListener("click",function () {

    resetearSocioMunicipio()

})

//Evento sobre el botón de registrar las parcelas
registroParcelas.addEventListener("click",function (e){

    e.preventDefault();
    if (validarCamposParcelas()){

        let datos = new FormData(formularioRegistroParcelas);
        datos.append("","");
        datos.append("controlador","registro");
        datos.append("accion","insertarParcela");
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

                if (data !== null) {

                    if (data.codigo === 1){

                        mostrarMsgCorrecto(data.msg);
                        ocultarMsgRetardo();

                        //reseteo del formulario de parcelas y campo select de búsqueda parcial
                        formularioRegistroParcelas.reset();
                        resetearSocioMunicipio()
                        //Cerramos la ventana emergente con la parcela
                        ventanaParcela.close();

                    }else{

                        mostrarMsgError(data.msg);
                        ocultarMsgRetardo();

                    }

                }else{

                    alert("¡¡OBJETO RECIBIDO INCORRECTO!!")

                }

            })
            .catch(err => {

                alert(err);

            })

    }



})

//Evento sobre el select de elegir socio para mostrar parcelas por socio en el menú lateral de muestra de parcelas
selSocioParcelaMuestra.addEventListener("change",function () {

    let datos = new FormData();
    datos.append("controlador","admin");
    datos.append("accion","mostrarParcelaXsocio");
    datos.append("eleccion",selSocioParcelaMuestra.value);

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

                let paginas = data.paginas;
                creacionCuerpoTablaDinamico(data)

                navPaginacionParcelas.empty();

                for (let i = 1; i <= paginas; i++) {

                    navPaginacionParcelas.append('<li data-eleccion="' + selSocioParcelaMuestra.value + '" ' +
                        'data-accion="mostrarParcelaXsocio" data-pagina="' + i + '" class="page-item parcelas"><a class="page-link" ' +
                        'href="">' + i + '</a></li>');

                }

                muestraPaginaParcelas.text(this.dataset.pagina);

                //Reinicia los campos de busqueda
                busSocioParcelaMuestra.value = "";
                selSocioParcelaMuestra.length = 0;
                let opcion = document.createElement("option");
                opcion.value = 'SELECCIONE SOCIO';
                opcion.textContent = 'SELECCIONE SOCIO';
                opcion.style.textAlign = "center";
                selSocioParcelaMuestra.append(opcion);

            }else{

                alert('ERROR EN EL OBJETO RECIBIDO')

            }

        })
        .catch(err => {

            alert(err);

        })



})

//Evento sobre los botones de la paginación de la tabla de los parcelas según la búsqueda
seccionParcelas.on("click",".page-item.parcelas",function (e) {

    e.preventDefault();
    this.classList.add('active')

    let datos = new FormData();
    datos.append("pagina",this.dataset.pagina);
    datos.append("controlador","admin");
    datos.append("accion",this.dataset.accion);
    datos.append("eleccion",this.dataset.eleccion);

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
                creacionCuerpoTablaDinamico(data)

                navPaginacionParcelas.empty();

                for (let i = 1; i <= paginas; i++) {

                    navPaginacionParcelas.append('<li data-eleccion="' + this.dataset.eleccion + '" ' +
                        'data-accion="' + this.dataset.accion + '" data-pagina="' + i + '" class="page-item parcelas"><a class="page-link" ' +
                        'href="">' + i + '</a></li>');

                }

                muestraPaginaParcelas.text(this.dataset.pagina);

            }else{

                tablaParcelasBody.empty();
                navPaginacionParcelas.empty();
                mostrarMsgError('NO EXISTEN PARCELAS CON ESOS PARÁMETROS');
                ocultarMsgRetardo();

            }

        })
        .catch(err => {

            alert(err);

        })

})

//Evento sobre el icono de la papelera de la tabla para eliminar a las parcelas tanto de la tabla como de la BBDD
seccionParcelas.on("click", ".fa.fa-trash-o.fa-2x",function () {

    //Seleccionamos el primer hermano td que contiene el id de socio
    let idParcelaBorrar = $(this).parent().siblings(':first').html();

    if (confirm('¿Está seguro de eliminar la parcela con Ref. Catastral ' + $(this).parent().siblings(':nth-child(7)').html() + " de "
        + $(this).parent().siblings(':nth-child(3)').html() + ", " + $(this).parent().siblings(':nth-child(4)').html() + '?')) {

        let datos = new FormData();
        datos.append("controlador", "admin");
        datos.append("accion", "eliminarParcela");
        datos.append("idBorrar", idParcelaBorrar);
        fetch("index.php", {

            method: "POST",
            body: datos

        })

            .then(response => {

                if (response.ok) {

                    return response.json();//tipo de respuesta que esperamos recibir

                } else {

                    throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

                }

            })

            .then(data => {

                if (data !== null) {

                    if (data.codigo === 1) {

                        mostrarMsgCorrecto(data.msg);
                        ocultarMsgRetardo();

                    } else if (data.codigo === 0 || data.codigo === -1) {

                        mostrarMsgError(data.msg);
                        ocultarMsgRetardo();

                    }

                } else {

                    alert("¡¡OBJETO RECIBIDO INCORRECTO!!")

                }

            })
            .catch(err => {

                alert(err);

            })

        //Eliminamos la parcela de la lista
        $(this).closest('tr').remove();

    }

})

//Evento sobre el icono de modificar Parcela, donde se podrían cambiar el sistema de cultivo, la variedad de aceituna y las plantas
seccionParcelas.on("click",".fa.fa-pencil-square-o.fa-2x",function () {

    let datosTabla = [];
    //Se recogen los datos de los elementos hermanos td el icono de modificar
    $(this).parents("tr").find("td").each(function(indice,valor){

        //Guardo los datos en un array
        datosTabla.push(valor.textContent);

    });

    //recojo el id de la parcela a modificar
    let idParcela = $(this).parents("tr").find("th:first-child").text();

    //Me quedo con los datos necesarios haciendo splice en el array.
    datosTabla.splice(0,8);
    datosTabla.splice(3,datosTabla.length);

    //Creo un objeto con los datos que me hacen falta para acceder mejor a los datos.
    let cambioDatos = {

        sistema:   datosTabla[0],
        variedad:  datosTabla[1],
        plantas:  datosTabla[2]

    }

    if (confirm('Va a proceder a modificar la parcela con Ref. Catastral ' + $(this).parent().siblings(':nth-child(7)').html() + " de "
        + $(this).parent().siblings(':nth-child(3)').html() + ", " + $(this).parent().siblings(':nth-child(4)').html() + '\n¿Está seguro?')) {
        let datos = new FormData();
        datos.append("controlador", "admin");
        datos.append("accion", "actualizarParcela");
        datos.append("datosParcela", JSON.stringify(cambioDatos));
        datos.append("idParcela", idParcela);
        fetch("index.php", {

            method: "POST",
            body: datos

        })

            .then(response => {

                if (response.ok) {

                    return response.json();//tipo de respuesta que esperamos recibir

                } else {

                    throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

                }

            })

            .then(data => {

                if (data !== null) {

                    if (data.codigo === 1) {

                        mostrarMsgCorrecto(data.msg);
                        ocultarMsgRetardo();

                    } else if (data.codigo === 0 || data.codigo === -1) {

                        mostrarMsgError(data.msg);
                        ocultarMsgRetardo();

                    }

                } else {

                    alert("¡¡OBJETO RECIBIDO INCORRECTO!!")

                }

            })
            .catch(err => {

                alert(err);

            })
    }
})

//////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////

//Función para validar la referencia catastral cuando se escribe solo en ese campo.
function validacionRefCat() {

    if(refCatParcela.value.length < 14 || refCatParcela.value.length > 20){

        mostrarMsgError("DEBE INTRODUCIR UNA REF. CATASTRAL VÁLIDA ENTRE 14 O 20 CARACTERES");
        ocultarMsgRetardo();
        refCatParcela.value = "";
        refCatParcela.focus();
        return false;

    }

    ocultarMsgError();
    return true;

}

//Función para validar los campos de registro de la sección de las parcelas
function validarCamposParcelas() {

    if(selSocioParcela.value === "SOCIOS"){

        mostrarMsgError("DEBE SELECCIONAR UN SOCIO CORRECTO");
        ocultarMsgRetardo();
        selSocioParcela.focus();
        return false;

    }

    if (selProvParcela.value === "PROVINCIA"){

        mostrarMsgError("DEBE SELECCIONAR UNA PROVINCIA CORRECTA");
        ocultarMsgRetardo();
        selProvParcela.focus();
        return false;

    }

    if (selMunParcela.value === "MUNICIPIO"){

        mostrarMsgError("DEBE SELECCIONAR UN MUNICIPIO CORRECTO");
        ocultarMsgRetardo();
        selMunParcela.focus();
        return false;

    }

    if (refCatParcela.value.length < 14 && refCatParcela.value.length > 20){

        mostrarMsgError("DEBE INTRODUCIR UNA REF. CATASTRAL VÁLIDA ENTRE 14 O 20 CARACTERES");
        ocultarMsgRetardo();
        refCatParcela.value = "";
        refCatParcela.focus();
        return false;

    }

    if (polParcela.value <= 0){

        mostrarMsgError("DEBE INTRODUCIR UN POLÍGONO CORRECTO. APARECERÁ EN EL MAPA EMERGENTE");
        ocultarMsgRetardo();
        polParcela.focus();
        return false;

    }

    if (parParcela.value <= 0){

        mostrarMsgError("DEBE INTRODUCIR UNA PARCELA CORRECTA. APARECERÁ EN EL MAPA EMERGENTE");
        ocultarMsgRetardo();
        parParcela.focus();
        return false;

    }

    if (superParcela.value <= 100){

        mostrarMsgError("LA SUPERFICIE DE LA PARCELA DEBE SER SUPERIOR O IGUAL A 100 METROS CUADRADOS");
        ocultarMsgRetardo();
        superParcela.focus();
        return false;

    }

    if (selSisParcela.value === "SISTEMA CULTIVO"){

        mostrarMsgError("DEBE SELECCIONAR UN SISTEMA DE CULTIVO CORRECTO");
        ocultarMsgRetardo();
        selSisParcela.focus();
        return false;

    }

    if (selVarParcela.value === "VARIEDAD ACEITUNA"){

        mostrarMsgError("DEBE SELECCIONAR UNA VARIEDAD CORRECTA");
        ocultarMsgRetardo();
        selVarParcela.focus();
        return false;

    }

    if (plantasParcela.value <= 50){

        mostrarMsgError("EL NÚMERO DE PLANTAS DE LA PARCELA DE DEBE SER SUPERIOR SUPERIOR O IGUAL A 50");
        ocultarMsgRetardo();
        plantasParcela.focus();
        return false;

    }

    ocultarMsgError();
    return true;

}

//Función sobre los campos de búsqueda parcial de socio para escribir por el apellido y recoger las coincidencias
//Se la pasa el campo de escritura, la acción que va a realizar del controlador y el campo de muestra de las coincidencias
function busquedaParcialSocios(campoEscritura,campoMuestra) {

    campoEscritura.addEventListener("keyup", function () {

        let datos = new FormData();
        datos.append("controlador", "admin");
        datos.append("accion", "mostrarSociosXApellidosRegistroParcela");
        datos.append("apellido", campoEscritura.value);

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

                    campoMuestra.length = 0;
                    if (data.length === 0) {

                        let opcion = document.createElement("option");
                        opcion.textContent = "No existen coincidencias";
                        campoMuestra.append(opcion);


                    } else {

                        let opcionInicial = document.createElement("option");
                        opcionInicial.value = 'SELECCIONE SOCIO';
                        opcionInicial.textContent = 'SELECCIONE SOCIO';
                        opcionInicial.style.textAlign = "center";
                        campoMuestra.append(opcionInicial);

                        for (let i = 0; i < data.length; i++) {

                            let opcion = document.createElement("option");
                            opcion.value = data[i].id_socio;
                            opcion.textContent = data[i].apellidos + ", " + data[i].nombre;
                            campoMuestra.append(opcion);

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
}

//función que resetea los campos de selección de socio y selección de municipio, que por defecto no lo hacen
function resetearSocioMunicipio() {

    selMunParcela.length = 0;
    let optionMunPar = document.createElement("option");
    optionMunPar.textContent = "MUNICIPIO";
    optionMunPar.value = "MUNICIPIO";
    optionMunPar.className = "text-center";
    selMunParcela.appendChild(optionMunPar);

    selSocioParcela.length = 0;
    let opcion = document.createElement("option");
    opcion.value = 'SOCIOS';
    opcion.textContent = 'SOCIOS';
    opcion.className = "text-center";
    selSocioParcela.append(opcion);

}

//Función para mostrar las parcelas por las diferentes búsquedas de selección: provincia, superficie, sistema de cultivo,
//variedad de aceituna y plantas. Se pasa por parámetro el select, la acción del controlador y el mensaje de reinicio del select.
function muestraDatosParcelas(campoSelect, accion, mensajeSelect) {

    campoSelect.addEventListener("change",function () {

        let datos = new FormData();
        datos.append("controlador","admin");
        datos.append("accion",accion);
        datos.append("eleccion",campoSelect.value);

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

                if (data.length !== 0) {

                    let paginas = data.paginas;
                    creacionCuerpoTablaDinamico(data)

                    navPaginacionParcelas.empty();

                    for (let i = 1; i <= paginas; i++) {

                        navPaginacionParcelas.append('<li data-eleccion="' + campoSelect.value + '" ' +
                            'data-accion="' + accion + '" data-pagina="' + i + '" class="page-item parcelas"><a class="page-link" ' +
                            'href="">' + i + '</a></li>');

                    }

                    muestraPaginaParcelas.text(this.dataset.pagina);

                    //Reinicia los campos de busqueda
                    campoSelect.value = mensajeSelect;

                }else{

                    tablaParcelasBody.empty();
                    campoSelect.value = mensajeSelect;
                    navPaginacionParcelas.empty();
                    mostrarMsgError('NO EXISTEN PARCELAS CON ESOS PARÁMETROS');
                    ocultarMsgRetardo();

                }

            })
            .catch(err => {

                alert(err);

            })

    })

}

//Función que crea el cuerpo dinámico de la tabla de mostrar las parcelas. Se le pasaría por parámetro los datos devueltos
//de la consulta AJAX
function creacionCuerpoTablaDinamico(data) {

    tablaParcelasBody.empty();

    for (let i = 0; i < data.usuarios.length; i++) {

        tablaParcelasBody.append('<tr>' +
            '<th>' + data.usuarios[i].id_parcela + '</th>' +
            '<th>' + data.usuarios[i].id_socio + '</th>' +
            '<td>' + data.usuarios[i].apellidos + '</td>' +
            '<td>' + data.usuarios[i].nombre_socio + '</td>' +
            '<td>' + data.usuarios[i].provincia + '</td>' +
            '<td>' + data.usuarios[i].municipio + '</td>'+
            '<td>' + data.usuarios[i].ref_catastral + '</td>'+
            '<td>' + data.usuarios[i].poligono + '</td>' +
            '<td>' + data.usuarios[i].parcela + '</td>' +
            '<td>' + data.usuarios[i].superficie + ' m<sup>2</sup></td>' +
            '<td contenteditable="true">' + data.usuarios[i].nombre_sistema + '</td>' +
            '<td contenteditable="true">' + data.usuarios[i].nombre_variedad + '</td>' +
            '<td contenteditable="true">' + data.usuarios[i].num_plantas + '</td>' +
            '<td><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>' +
            '<td><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>' +
            '</tr>');

    }

}