
//////////////////////Obtención de la fecha y hora para la página////////////////////////////////////////////

const fecha = new Date();
let dia = fecha.getDate();
if (dia < 10){

    dia = "0" + dia;

}
let mes = fecha.getMonth() + 1;
if (mes < 10){

    mes = "0" + mes;

}
const year = fecha.getFullYear();
const fechaHoraAdmin = document.getElementById("fechaHoraAdmin");
fechaHoraAdmin.append(dia + "/" + mes + "/" + year);

///////////////////////////// Muestra de los diferentes paneles según el enlace que se pulse //////////////////////////

const enlaces = document.querySelectorAll(".sidenav h3");
const secciones = document.querySelectorAll("article");

for (let i = 0; i < enlaces.length; i++){

    enlaces[i].addEventListener('click',function () {

        for (let j = 0;j < secciones.length;j++) {

            //Se ocultan o muestran los distintos apartados del administrador
            enlaces[i].textContent.includes(secciones[j].id.substring(7,secciones[0].id.length))
                ? secciones[j].hidden = false : secciones[j].hidden = true;

        }

        //Se subrayan y colorean los enlaces pulsados para saber donde nos encontramos
        for (let k = 0; k <= enlaces.length; k++) {

            if (screen.width < 850){

                this.style.fontSize = "12px";
                this.style.textDecoration = "underline";
                this.style.color = "#ecec81";

                enlaces[k].style.textDecoration = "none";
                enlaces[k].style.color = "white";

            }else {

                this.style.textDecoration = "underline";
                this.style.color = "#ecec81";

                enlaces[k].style.textDecoration = "none";
                enlaces[k].style.color = "white";
            }
        }

    })

}
/**********************************************************************************************************************
*********************** APARTADO DE LOS SOCIOS, REGISTRO, MODIFICACIÓN Y BORRADO *************************************
 **********************************************************************************************************************/

/******* Selección del municipio, dirección y código postal según los elementos seleccionados en los select **********/

//Referencia a los campos de provincia, municipio, dirección y código postal y sus respectivos campos alternativos.
const provSocio = document.getElementById("provSocio");
const provSocioAlterna = document.getElementById("provSocioAlterna");
const munSocio = document.getElementById("munSocio");
const munSocioAlterna = document.getElementById("munSocioAlterna");
const dirSocio = document.getElementById("dirSocio");
const dirSocioAlterna = document.getElementById("dirSocioAlterna");
const cpSocio = document.getElementById("cpSocio");
const cpSocioAlterna = document.getElementById("cpSocioAlterna");

//Evento sobre el cambio del select de las provincias
provSocio.addEventListener("change",function () {

    if (provSocio.value === "PROVINCIA"){

        munSocio.length = 0;
        let optionMun = document.createElement("option");
        optionMun.textContent = "MUNICIPIO";
        optionMun.value = "MUNICIPIO";
        munSocio.appendChild(optionMun);

        dirSocio.length = 0;
        let optionDir = document.createElement("option");
        optionDir.textContent = "DIRECCIÓN";
        optionDir.value = "DIRECCIÓN";
        optionDir.style.textAlign = "center";
        dirSocio.appendChild(optionDir);

        cpSocio.length = 0;
        let optionCp = document.createElement("option");
        optionCp.textContent = "CÓDIGO POSTAL";
        optionCp.value = "CÓDIGO POSTAL";
        optionCp.style.textAlign = "center";
        cpSocio.appendChild(optionCp);


    }else {

        const datos = new FormData();
        datos.append('controlador', 'registro');
        datos.append('accion', 'muestraMunicipio');
        datos.append('Provincia', provSocio.value);

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

                    munSocio.length = 0;

                    if (dirSocio.length > 1) {

                        dirSocio.length = 0;
                        let option = document.createElement("option");
                        option.textContent = "DIRECCIÓN";
                        option.value = "DIRECCIÓN";
                        option.style.textAlign = "center";
                        dirSocio.appendChild(option);

                    }

                    if (cpSocio.length >= 1) {

                        cpSocio.length = 0;
                        let option = document.createElement("option");
                        option.textContent = "CÓDIGO POSTAL";
                        option.value = "CÓDIGO POSTAL";
                        option.style.textAlign = "center";
                        cpSocio.appendChild(option);

                    }

                    for (let i = 0; i < Obj.length; i++) {

                        let option = document.createElement("option");
                        option.textContent = Obj[i];
                        option.value = Obj[i];
                        munSocio.appendChild(option);

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

//Elección de la dirección según la provincia y el municipio seleccionado
munSocio.addEventListener("change",function () {

    mostrarCodPost();
    let datos = new FormData();
    datos.append('controlador', 'registro');
    datos.append('accion', 'muestraDireccion');
    datos.append('Provincia', provSocio.value);
    datos.append("Municipio", munSocio.value);

    fetch("index.php", {

        method: 'POST',
        body: datos

    })

        .then(function (response) {

            if (response.ok){

                return response.json();

            }else{

                throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

            }

        })
        .then(data => {

            let Obj = data;
            if (Obj !== null){

                dirSocio.length = 0;

                for (let i=0;i<Obj.length;i++){

                    let option = document.createElement("option");
                    option.textContent = Obj[i];
                    option.value = Obj[i];
                    dirSocio.appendChild(option);

                }

            }else{

                alert("¡¡ERROR EN LA SELECCIÓN DE LAS DIRECCIONES!!")

            }
        })
        .catch(function(err) {
            console.log(err);
        });

})

//Función que muestra los códigos postales en un select según el municipio seleccionado anteriormente
function mostrarCodPost() {

    const datos = new FormData();
    datos.append('controlador', 'registro');
    datos.append('accion', 'muestraCp');
    datos.append("Municipio", munSocio.value);
    datos.append("codPost", "codigos");

    fetch("index.php", {

        method: 'POST',
        body: datos

    })

        .then(function (response) {

            if (response.ok){

                return response.json();

            }else{

                throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

            }

        })
        .then(data => {

            let Obj = data;
            if (Obj !== null){

                cpSocio.length = 0;

                for (let i=0;i<Obj.length;i++){

                    let option = document.createElement("option");
                    option.textContent = Obj[i];
                    option.value = Obj[i];
                    cpSocio.appendChild(option);

                }

            }else{

                alert("¡¡ERROR EN LA SELECCIÓN DE LOS CÓDIGOS POSTALES!!")

            }
        })
        .catch(function(err) {
            console.log(err);
        });

}

/****** Eventos para validar los campos del formulario de registro de los socios. Y hacer la petición al servidor ******/

//Referencia a los botones de mandar y resetear el formulario, al formulario, al campo del dni del socio y a la tabla de los socios.
const registroSocio = document.querySelector("#registroSocio");
const borradoRegistroSocio = document.getElementById("borradoRegistroSocio");
const formularioRegistroSocios = document.querySelector("#formularioRegistroSocios");
const dniSocio = document.getElementById("dniSocio");
const tablaSocios = document.querySelector("#tablaSocios tbody");

//Evento sobre el botón de resetear los datos del formulario para eliminar datos adicionales
borradoRegistroSocio.addEventListener("click",function (e){

    e.preventDefault();

    reinicioSelectDir(provSocio, munSocio, dirSocio, cpSocio);

    formularioRegistroSocios.reset();

})

//Evento sobre el campo del dni, al quitar el foco sobre él, comprueba que es correcto.
dniSocio.addEventListener("blur",function () {

    if (validacionDNI(this.value)){



    }else{

        this.value = "";
        this.focus();

    }
})

//Evento sobre el botón de envío del formulario donde se validan los datos y se mandan al controlador
registroSocio.addEventListener("click", function (e) {

    e.preventDefault();

    if (formularioRegistroSocios.checkValidity() && validacionDNI(dniSocio.value)) {

        if ((provSocio.value !== "PROVINCIA" && provSocioAlterna.value !== "") || (munSocio.value !== "MUNICIPIO" && munSocioAlterna.value !== "")
            || (dirSocio.value !== "DIRECCIÓN" && dirSocioAlterna.value !== "") || (cpSocio.value !== "CÓDIGO POSTAL" && cpSocioAlterna.value !== "")) {

            mostrarMsgError("Seleccione solo un campo para cada situación de dirección");

        }else if((provSocio.value === "PROVINCIA" && provSocioAlterna.value === "") || (munSocio.value === "MUNICIPIO" && munSocioAlterna.value === "")
            || (dirSocio.value === "DIRECCIÓN" && dirSocioAlterna.value === "") || (cpSocio.value === "CÓDIGO POSTAL" && cpSocioAlterna.value === "")){

            mostrarMsgError("Debe introducir los datos referentes a su dirección");

        }else{

            const datos = new FormData(formularioRegistroSocios);
            datos.append("controlador","registro");
            datos.append("accion","registroSocio");
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

                        let tablaMuestra = tablaSocios.insertRow(tablaSocios.rows.length);

                        let thId = document.createElement("th");
                        let col1 = tablaMuestra.appendChild(thId);
                        let col2 = tablaMuestra.insertCell(1);
                        let col3 = tablaMuestra.insertCell(2);
                        let col4 = tablaMuestra.insertCell(3);
                        let col5 = tablaMuestra.insertCell(4);
                        let col6 = tablaMuestra.insertCell(5);
                        let col7 = tablaMuestra.insertCell(6);
                        let col8 = tablaMuestra.insertCell(7);
                        let col9 = tablaMuestra.insertCell(8);
                        let col10 = tablaMuestra.insertCell(9);
                        let col11 = tablaMuestra.insertCell(10);
                        let col12 = tablaMuestra.insertCell(11);
                        let col13 = tablaMuestra.insertCell(12);

                        let checkModiftrue = document.createElement("input");
                        checkModiftrue.type = "checkbox";
                        checkModiftrue.checked = true;
                        checkModiftrue.className = "accesoTabla";
                        let checkModifalse = document.createElement("input");
                        checkModifalse.type = "checkbox";
                        checkModifalse.checked = false;
                        checkModiftrue.className = "accesoTabla";
                        let activo;
                        data['usuario'][0].activo == 1 ? activo = "Activo" : activo = "Desactivado";
                        let col14 = tablaMuestra.insertCell(13)
                        let col15 = tablaMuestra.insertCell(14);
                        let col16 = tablaMuestra.insertCell(15);
                        let col17 = tablaMuestra.insertCell(16);

                        let salto = document.createElement("br");
                        let modificar = document.createElement("i");
                        modificar.className = "fa fa-pencil-square-o fa-2x";
                        modificar.ariaHidden = "true";
                        let col18 = tablaMuestra.insertCell(17);

                        let borrar = document.createElement("i");
                        borrar.className = "fa fa-trash-o fa-2x";
                        borrar.ariaHidden = "true";
                        let col19 = tablaMuestra.insertCell(18);

                        col1.textContent = data['usuario'][0].id_socio;
                        col2.textContent = data['usuario'][0].nombre;
                        col3.textContent = data['usuario'][0].apellidos;
                        col4.textContent = data['usuario'][0].dni;
                        col5.textContent = data['usuario'][0].telefono;
                        col5.contentEditable = "true";
                        col6.textContent = data['usuario'][0].provincia;
                        col6.contentEditable = "true";
                        col7.textContent = data['usuario'][0].municipio;
                        col7.contentEditable = "true";
                        col8.textContent = data['usuario'][0].direccion;
                        col8.contentEditable = "true";
                        col9.textContent = data['usuario'][0].cp;
                        col9.contentEditable = "true";
                        col10.textContent = data['usuario'][0].num_casa;
                        col10.contentEditable = "true";
                        col11.textContent = data['usuario'][0].piso;
                        col11.contentEditable = "true";
                        col12.textContent = data['usuario'][0].puerta;
                        col12.contentEditable = "true";
                        col13.textContent = data['usuario'][0].email;
                        col13.contentEditable = "true";
                        col14.textContent = activo;
                        col14.appendChild(salto);
                        if (activo === "Activo"){

                            col14.appendChild(checkModiftrue);

                        }else{

                            col14.appendChild(checkModifalse);

                        }

                        col15.textContent = data['usuario'][0].tipo_socio;
                        col16.textContent = data['usuario'][0].fecha_alta;
                        col17.textContent = data['usuario'][0].fecha_baja;
                        col17.contentEditable = "true";
                        col18.appendChild(modificar);
                        col19.appendChild(borrar);

                        let msgEnvio = data.msgCorreo.style.fontSize = "12px";
                        mostrarMsgCorrecto(data.msg + msgEnvio);
                        ocultarMsgRetardo();

                    }else{

                        alert("¡¡OBJETO RECIBIDO INCORRECTO!!")

                    }

                })
                .catch(err => {

                    alert(err);

                })

        }
    }else{

        mostrarMsgError("Debe rellenar todos los campos obligatorios marcados con * de forma correcta");

    }

})

//Evento sobre el checkbox de la tabla de usuarios para modificar sobre la marcha el acceso de los socios
$(document).on("click",".accesoTabla",function () {

    if ($(this).is(":checked")){


        $(this).parent().empty().append("Activo<br><input type='checkbox' checked class='accesoTabla'>");

    }else{

        $(this).parent().empty().append("Desactivado<br><input type='checkbox' class='accesoTabla'>");

    }

})

/**** Recogemos situación del botón de activar o desactivar a un usuario durante su registro mostrando mensaje correspondiente ********/

//Elemento check para mostrar situación según marcado
const activoSocio = document.getElementById("activoSocio");
//Span para mostrar mensaje de situación
const muestraActiv = document.getElementById("muestraActiv");

//Evento sobre elemento check de la página
activoSocio.addEventListener("click",function (){

    this.checked === true ? muestraActiv.textContent = "Activado" : muestraActiv.textContent = "Desactivado";

})

/****************** Evento click en el documento sobre el icono de la papelera de la tabla para eliminar a los socios,
 * ******************** y por lo tanto a los usuarios de la BBDDD ****************************************************/

    $(document).on("click", ".fa.fa-trash-o.fa-2x",function () {

        //Seleccionamos el primer hermano td que contiene el id de socio
        let idUsuarioBorrar = $(this).parent().siblings(':first').html();
        sessionStorage.setItem("idBorrar",idUsuarioBorrar);

        if (confirm("¿Está seguro de eliminar a este socio de la BBDD?")) {

            $(this).closest('tr').remove();
            let datos = new FormData();
            datos.append("controlador", "admin");
            datos.append("accion", "eliminarSocio");
            datos.append("idBorrar", sessionStorage.getItem("idBorrar"));
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
/**********************************************************************************************************************/

//Evento sobre el icono de modificar socio
$(document).on("click",".fa.fa-pencil-square-o.fa-2x",function () {

    let datosTabla = [];
    //Se recogen los datos de los elementos hermanos td el icono de modificar
    $(this).parents("tr").find("td").each(function(indice,valor){

        //Guardo los datos en un array
        datosTabla.push(valor.textContent);

    });

    //recojo el id del usuario a modificar y lo guardo en sessionStorage del navegador para pasarlo en la petición ajax
    let id = $(this).parents("tr").find("th").text();
    sessionStorage.clear();
    sessionStorage.setItem("idActualizar", id);

    //Me quedo con los datos necesarios haciendo splice en el array.
    datosTabla.splice(0,3);
    datosTabla.splice(11,1);
    datosTabla.splice(12,2);

    //Creo un objeto con los datos que me hacen falta para acceder mejor a los datos.
    let cambioDatos = {

        telefono:   datosTabla[0],
        provincia:  datosTabla[1],
        municipio:  datosTabla[2],
        direccion:  datosTabla[3],
        cp:         datosTabla[4],
        num_casa:   datosTabla[5],
        piso:       datosTabla[6],
        puerta:     datosTabla[7],
        email:      datosTabla[8],
        acceso:     datosTabla[9],
        tipo:       datosTabla[10],
        fechaBaja:  datosTabla[11]

    }

    let datos = new FormData();
    datos.append("controlador","admin");
    datos.append("accion","actualizarSocio");
    datos.append("datosUsuario", JSON.stringify(cambioDatos));
    datos.append("idUsuarioAct", sessionStorage.getItem("idActualizar"));
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

                if (data.codigo === 1) {

                    mostrarMsgCorrecto(data.msg);
                    ocultarMsgRetardo();

                } else if (data.codigo === 0 || data.codigo === -1) {

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

})

/* FUNCIÓN QUE REINICIA LOS CAMPOS DE LOS SELECT DE LA DIRECCIÓN DEL SOCIO */
function reinicioSelectDir(campoProv, campoMun, campoDir, campoCp) {

    campoProv.selectedOptions = "PROVINCIA";

    campoMun.length = 0;
    let optionMun = document.createElement("option");
    optionMun.textContent = "MUNICIPIO";
    optionMun.value = "MUNICIPIO";
    optionMun.style.textAlign = "center";
    campoMun.appendChild(optionMun);

    campoDir.length = 0;
    let optionDir = document.createElement("option");
    optionDir.textContent = "DIRECCIÓN";
    optionDir.value = "DIRECCIÓN";
    optionDir.style.textAlign = "center";
    campoDir.appendChild(optionDir);

    campoCp.length = 0;
    let optionCp = document.createElement("option");
    optionCp.textContent = "CÓDIGO POSTAL";
    optionCp.value = "CÓDIGO POSTAL";
    optionCp.style.textAlign = "center";
    campoCp.appendChild(optionCp);

}

/*********************************************************************************************************************
 * ************************************ FINALIZA LA PARTE DE LOS SOCIOS ***********************************************
 * ********************************************************************************************************************/

/*********************************************************************************************************************
 * ************************ APARTADO DE LAS PARCELAS. REGISTRO Y CONSULTAS ******************************************
 * ********************************************************************************************************************/

//Referenciamos los select de provincia y municipio en la zona de las parcelas
const selProvParcela = document.getElementById("selProvParcela");
const selMunParcela = document.getElementById("selMunParcela");

selProvParcela.addEventListener("change",function () {

    if (selProvParcela.value === "PROVINCIA"){

        selMunParcela.length = 0;
        let optionMunPar = document.createElement("option");
        optionMunPar.textContent = "MUNICIPIO";
        optionMunPar.value = "MUNICIPIO";
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
