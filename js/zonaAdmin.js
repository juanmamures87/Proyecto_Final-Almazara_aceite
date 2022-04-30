
//////////////////////Obtención de la fecha y hora para la página////////////////////////////////////////////

const fecha = new Date();
const dia = fecha.getDate();
const mes = fecha.getMonth() + 1;
const year = fecha.getFullYear();
const fechaHoraAdmin = document.getElementById("fechaHoraAdmin");
fechaHoraAdmin.append(dia + "/" + mes + "/" + year);

///////////////////////////// Muestra de los diferentes paneles según el enlace que se pulse //////////////////////////

const enlaces = document.querySelectorAll(".sidenav h3");
const secciones = document.querySelectorAll("section");

for (let i = 0, j = 0; i < enlaces.length, j < secciones.length; i++, j++){

    enlaces[i].addEventListener('click',function () {

        if (enlaces[i].textContent.search(secciones[j].id)){

            secciones[j].hidden = false;

        }

    })

}

/*secciones.forEach(secciones =>{

    console.log(secciones.id)

})

enlaces.forEach(apartados =>{

    let nombreSecciones = apartados.textContent;

})*/

