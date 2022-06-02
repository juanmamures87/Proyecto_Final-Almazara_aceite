/*///////////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA ////////////////////////////////////////////*/

//Referencia al apartado de la tienda
const seccionTienda = $('#seccionTienda');

//Referencia al formulario de tienda
const formularioRegistroTienda = document.getElementById('formularioRegistroTienda');

//Referencia a los campos del formulario
const nomProducto = document.getElementById('nomProducto');
const selCatProducto = document.getElementById('selCatProducto');
const recipienteProducto = document.getElementById('recipienteProducto');
const l_recipiente = document.getElementById('l/recipiente');
const imgProducto = document.getElementById('imgProducto');
const precioAove = document.getElementById('precioAove');
const precioAov = document.getElementById('precioAov');

//Botones del formulario
const registroProducto = document.getElementById('registroProducto');
const resetFormProducto = document.getElementById('resetFormProducto');
const cambioPrecio = document.getElementById('cambioPrecio');

/*///////////////////////////////////////////// UTILIZACIÓN DE FUNCIONES /////////////////////////////////////////////*/



/*////////////////////////////////////////////////// EVENTOS ////////////////////////////////////////////////////////*/

//Evento sobre el botón del formulario que modifica el precio de los dos tipos de aceite disponible
cambioPrecio.addEventListener('click',function (){

    let datos = new FormData(formularioRegistroTienda);
    datos.append('controlador','admin');
    datos.append('accion','modificaPrecio');

    if (confirm('VA A PROCEDER A MODIFICAR EL PRECIO DEL ACEITE\n\n' +
        '                          ¿ESTÁ SEGURO?')) {
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

                console.log(data);
                if (data !== null) {

                    if (data.codigo === 1){

                        mostrarMsgCorrecto(data.msg);
                        ocultarMsgRetardo();
                        //Se actualiza el atributo data de los campos de los precios para almacenar el precio modificado
                        precioAove.dataset.precio = precioAove.value;
                        precioAov.dataset.precio = precioAov.value;

                    }else if (data.codigo === 0 || data.codigo === -1){

                        mostrarMsgError(data.msg);
                        ocultarMsgRetardo();

                    }

                }else{

                    alert('ERROR EN EL OBJETO RECIBIDO')

                }

            })
            .catch(err => {

                alert(err);

            })

    }else{

        //Si se cancela la opción se recuperan los precios anteriores que están almacenados en el atributo data
        precioAove.value = precioAove.dataset.precio;
        precioAov.value = precioAov.dataset.precio;

    }

});

//Evento sobre el botón de registrar un producto
registroProducto.addEventListener('click',function (e) {

    e.preventDefault();
    if (validaFormProducto()) {
        let datos = new FormData(formularioRegistroTienda);
        datos.append('controlador', 'registro');
        datos.append('accion', 'insertaProducto');

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

                        mostrarMsgCorrecto(data.msg);
                        ocultarMsgRetardo();
                        formularioRegistroTienda.reset();

                    } else {

                        mostrarMsgError(data.msg);
                        formularioRegistroTienda.reset();

                    }

                } else {

                    alert('ERROR EN EL OBJETO RECIBIDO')

                }

            })
            .catch(err => {

                alert(err);

            })
    }else{

        formularioRegistroTienda.reset();

    }
})

/*/////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////*/

//Función de validación sobre los campos del formulario
function validaFormProducto() {

    if (nomProducto.value.length < 5 || nomProducto.value.length > 100){

        mostrarMsgError('DEBE INTRODUCIR UN NOMBRE CORRECTO PARA EL ARTÍCULO');
        ocultarMsgRetardo();
        return false;

    }

    if (selCatProducto.value === 'CATEGORIA'){

        mostrarMsgError('DEBE SELECCIONAR UNA CATEGORÍA CORRECTA');
        ocultarMsgRetardo();
        return false;

    }

    ocultarMsgError();
    return true;

}