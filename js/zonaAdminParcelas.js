/*********************************************************************************************************************
 * ************************ APARTADO DE LAS PARCELAS. REGISTRO Y CONSULTAS ******************************************
 * ********************************************************************************************************************/

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

//Referencia a los botones de registrar parcela y resetear campos
const registroParcelas = document.getElementById("registroParcelas");
const resetFormParcelas = document.getElementById("resetFormParcelas");

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
    let introducirRefCat;
    clearTimeout(introducirRefCat)

    introducirRefCat = setTimeout(() => {

        if (validacionRefCat()) {

            window.open('https://www1.sedecatastro.gob.es/Cartografia/mapa.aspx?refcat=' + refCatParcela.value + '',
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

//Evento sobre el botón de resetear los campos de registro de las parcelas. Que además de hacer su función resetea el select de municipio
resetFormParcelas.addEventListener("click",function () {

    selMunParcela.length = 0;
    let optionMunPar = document.createElement("option");
    optionMunPar.textContent = "MUNICIPIO";
    optionMunPar.value = "MUNICIPIO";
    optionMunPar.className = "text-center";
    selMunParcela.appendChild(optionMunPar);

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

//Evento sobre el campo de socio para escribir por el apellido y recoger las coincidencias
busSocioParcela.addEventListener("keyup",function () {

    let datos = new FormData();
    datos.append("controlador","admin");
    datos.append("accion","mostrarSociosXApellidosRegistroParcela");
    datos.append("apellido",busSocioParcela.value);

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

                selSocioParcela.length = 0;
                if (data.length === 0){

                    let opcion = document.createElement("option");
                    opcion.textContent = "No existen coincidencias";
                    selSocioParcela.append(opcion);


                }else {

                    for (let i = 0; i < data.length; i++) {

                        let opcion = document.createElement("option");
                        opcion.value = data[i].id_socio;
                        opcion.textContent = data[i].apellidos + ", " + data[i].nombre;
                        selSocioParcela.append(opcion);

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

/*const tablaParcelas = document.getElementById("tablaParcelas");
const navPaginacionParcelas = document.getElementById("navPaginacionParcelas");
selSocioParcela.addEventListener("keyup",function () {

    let datos = new FormData();
    datos.append("controlador","admin");
    datos.append("accion","mostrarParcialParcelaXsocio");
    datos.append("pagina","");
    datos.append("apellido",selSocioParcela.value);
    console.log(datos.get("pagina"))

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
                let activado;
                let fechaBaja;
                let puerta;
                tablaJQsocios.empty();

                for (let j = 0; j < data.usuarios.length; j++) {

                    if (data.usuarios[j].activo == 1){

                        activado = "Activo <br><input type='checkbox' class='accesoTabla' checked>";

                    }else{

                        activado = "Desactivado <br><input type='checkbox' class='accesoTabla'>";

                    }
                    data.usuarios[j].fecha_baja === null ? fechaBaja = "" : fechaBaja = data.usuarios[j].fecha_baja;
                    data.usuarios[j].puerta === null ? puerta = "" : puerta = data.usuarios[j].puerta;
                    tablaJQsocios.append('<tr>' +
                        '<th>' + data.usuarios[j].id_socio + '</th>' +
                        '<td>' + data.usuarios[j].nombre + '</td>' +
                        '<td>' + data.usuarios[j].apellidos + '</td>' +
                        '<td>' + data.usuarios[j].dni + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].telefono + '</td>'+
                        '<td contenteditable="true">' + data.usuarios[j].provincia + '</td>'+
                        '<td contenteditable="true">' + data.usuarios[j].municipio + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].direccion + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].cp + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].num_casa + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].piso + '</td>' +
                        '<td contenteditable="true">' + puerta + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].email + '</td>' +
                        '<td>' + activado + '</td>' +
                        '<td contenteditable="true">' + data.usuarios[j].tipo_socio + '</td>' +
                        '<td>' + data.usuarios[j].fecha_alta + '</td>' +
                        '<td contenteditable="true">' + fechaBaja + '</td>' +
                        '<td><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>' +
                        '<td><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>' +
                        '</tr>');

                }

                numeracionPaginacion.empty();

                for (let i = 1; i <= paginas; i++) {

                    numeracionPaginacion.append('<li class="page-item"><a data-pagina="' + i + '" class="page-link" ' +
                        'href="#">' + i + '</a></li>');

                }

            }else{

                alert('ERROR EN EL OBJETO RECIBIDO')

            }

        })
        .catch(err => {

            alert(err);

        })

})*/