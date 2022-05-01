
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

            this.style.textDecoration = "underline";
            this.style.color = "#ecec81";

            enlaces[k].style.textDecoration = "none";
            enlaces[k].style.color = "white";

        }

    })

}

/**************** SELECCIÓN DEL MUNICIPIO, DIRECCIÓN Y CÓDIGO POSTAL SEGÚN LOS ELEMENTOS*****************************
 ************************* SELECCIONADOS EN LOS SELECT DE LA DIRECCIÓN *********************************************/

//elección del municipio según la provincia seleccionada
const provSocio = document.getElementById("provSocio");
const munSocio = document.getElementById("munSocio");
const dirSocio = document.getElementById("dirSocio");
const cpSocio = document.getElementById("cpSocio");

provSocio.addEventListener("change",function () {

    var datos = new FormData();
    datos.append('controlador', 'registro');
    datos.append('accion', 'muestraMunicipio');
    datos.append('Provincia',provSocio.value);

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

            let Obj = data;
            if (Obj !== null){

                munSocio.length = 0;
                /*$("#muni").empty();
                $("#dir").empty();
                $("#cp").empty();*/

                for (let i=0;i<Obj.length;i++){

                    let option = document.createElement("option");
                    option.textContent = Obj[i];
                    option.value = Obj[i];
                    munSocio.appendChild(option);

                }

            }else{

                alert("¡¡ERROR EN LA SELECCIÓN DE LAS PROVINCIAS!!")

            }

        })
        .catch(err => {

            alert(err);

        })



})

//Elección del la dirección según la provincia y el municipio seleccionado
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

function mostrarCodPost() {

    var datos = new FormData();
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



