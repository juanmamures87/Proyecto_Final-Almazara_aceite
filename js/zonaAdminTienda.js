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
const imgProducto = $('#imgProducto');
const precioAove = document.getElementById('precioAove');
const precioAov = document.getElementById('precioAov');

//Botones del formulario
const registroProducto = document.getElementById('registroProducto');
const resetFormProducto = document.getElementById('resetFormProducto');
const cambioPrecio = document.getElementById('cambioPrecio');

//Referencia al cuerpo de la tabla de los productos y a su paginación
const tablaProductosCuerpo = $('#tablaProductos tbody');
const navPaginacionProductos = $('#navPaginacionProductos ul');
const muestraPaginaProductos = $('#muestraPaginaProductos');

//Referencia al botón de renovar cantidades de aceite y a los campos que lo muestran.
const renovarCantidadesAceite = document.getElementById('renovarCantidadesAceite');
const litrosDisponiblesAove = document.getElementById('litrosDisponiblesAove');
const litrosDisponiblesAov = document.getElementById('litrosDisponiblesAov');


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

//Evento sobre los botones de la paginación de la tabla de los productos en la zona sección de la tienda
seccionTienda.on("click",".page-item",function (e) {

    e.preventDefault();
    this.classList.add('active')

    let datos = new FormData();
    datos.append("pagina",this.dataset.pagina);
    datos.append("controlador","admin");
    datos.append("accion","paginarProductos");

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
                cuerpoTablaProductos(data);

                navPaginacionProductos.empty();

                for (let i = 1; i <= paginas; i++) {

                    navPaginacionProductos.append('<li data-pagina="' + i + '" class="page-item"><a class="page-link" ' +
                        'href="">' + i + '</a></li>');

                }

                muestraPaginaProductos.text(this.dataset.pagina);

            }else{

                mostrarMsgError('NO SE HAN PODIDO RECUPERAR LOS PRODUCTOS GUARDADOS');
                ocultarMsgRetardo();

            }

        })
        .catch(err => {

            alert(err);

        })

})

//Evento sobre el botón de renovar las cantidades de aceite de oliva de los tipos que hay en la almazara
renovarCantidadesAceite.addEventListener('click',function (e) {

    e.preventDefault();

    let datos  = new FormData();
    datos.append('controlador','admin');
    datos.append('accion','renovarAceite');

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

                litrosDisponiblesAove.value = data[0].cantidad_litros;
                litrosDisponiblesAov.value = data[1].cantidad_litros;

            }else{

                alert('ERROR EN EL OBJETO RECIBIDO')

            }

        })
        .catch(err => {

            alert(err);

        })



})

//Evento sobre el icono de la papelera de la tabla para eliminar el producto seleccionado
seccionTienda.on("click", ".fa.fa-trash-o.fa-2x",function () {

    //Seleccionamos el primer hermano td que contiene el id de socio
    let idProductoBorrar = $(this).parent().siblings(':first').html();

    if (confirm('¿Está seguro de eliminar el producto seleccionado?\n'
        + $(this).parent().siblings(':first-child').html() + " - " + $(this).parent().siblings(':nth-child(2)').html())) {

        let datos = new FormData();
        datos.append("controlador", "admin");
        datos.append("accion", "eliminarProducto");
        datos.append("idBorrar", idProductoBorrar);
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

//Evento sobre el icono de modificar Producto. Se podría modificar la descripción, dcto, recipiente, litros e imagen
seccionTienda.on("click",".fa.fa-pencil-square-o.fa-2x",function () {

    let datosTabla = [];
    //Se recogen los datos de los elementos hermanos td el icono de modificar
    $(this).parents("tr").find("td").each(function(indice,valor){

        //Guardo los datos en un array
        datosTabla.push(valor.textContent);

    });

    //recojo el id de la parcela a modificar
    let idProducto = $(this).parents("tr").find("th:first-child").text();

    //Me quedo con los datos necesarios haciendo splice en el array.
    datosTabla.splice(0,0);
    datosTabla.splice(1,1);
    datosTabla.splice(2,1);
    datosTabla.splice(4,datosTabla.length);

    //Creo un objeto con los datos que me hacen falta para acceder mejor a los datos.
    let cambioDatos = {

        descripcion:   datosTabla[0],
        dcto:  datosTabla[1],
        recipiente:  datosTabla[2],
        litros_recipiente:  datosTabla[3]

    }

    if (confirm('Va a proceder a modificar el producto\n'
        + $(this).parent().siblings(':first-child').html() + " - " + $(this).parent().siblings(':nth-child(2)').html() +
        '\n¿Está seguro?')) {
        let datos = new FormData();
        datos.append("controlador", "admin");
        datos.append("accion", "actualizarDatosProducto");
        datos.append("datosProducto", JSON.stringify(cambioDatos));
        datos.append("idProducto", idProducto);
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

//Evento sobre la imagen de un producto de la tabla. Que al pulsarlo permite seleccionar otra imagen diferente
//Lo hago mediante setTimeout, ya que al pinchar sobre la imagen se abre el input file del registro permitiendo
//seleccionar una imagen en el intervalo de 5000 milisegundos. Y mostraría un mensaje correcto o de error
seccionTienda.on('click','.imagenProductoTabla',function () {

    //recojo el id del producto a modificar
    let idProducto = $(this).parents("tr").find("th:first-child").text();
    imgProducto.trigger('click');
    setTimeout(() => {

        let datos = new FormData(formularioRegistroTienda);
        datos.append('controlador','admin');
        datos.append('accion','actualizarFoto');
        datos.append('idProducto', idProducto);

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

                    if (data.codigo === 1) {

                        mostrarMsgCorrecto(data.msg + ' - ACTUALICE PAGINANDO');
                        formularioRegistroTienda.reset();

                    } else if (data.codigo === 0 || data.codigo === -1 || data.codigo === -2 || data.codigo === -3 ||
                        data.codigo === -4 || data.codigo === -5) {

                        mostrarMsgError(data.msg);
                        formularioRegistroTienda.reset();

                    }

                }else{

                    mostrarMsgError('DEBE SELECCIONAR UNA FOTOGRAFÍA CORRECTA O NO SELECCIONO NINGUNA');

                }

            })
            .catch(err => {

                alert(err);

            })

    },5000)

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

//Función que crea el cuerpo dinámico de la tabla que muestra los productos. Se le pasaría por parámetro los datos devueltos
//de la consulta AJAX
function cuerpoTablaProductos(data) {

    tablaProductosCuerpo.empty();

    for (let i = 0; i < data.productos.length; i++) {

        let extraerFecha = data.productos[i].fecha_inser.split("-");
        let nuevaFechaAlta = extraerFecha[2] + "/" + extraerFecha[1] + "/" + extraerFecha[0];

        tablaProductosCuerpo.append('<tr>' +
            '<th>' + data.productos[i].id_producto + '</th>' +
            '<td contenteditable="true" title="Campo editable">' + data.productos[i].descripcion + '</td>' +
            '<td>' + nuevaFechaAlta + '</td>' +
            '<td contenteditable="true" title="Campo editable">' + data.productos[i].dcto + '</td>' +
            '<td>' + data.productos[i].categoria + '</td>'+
            '<td contenteditable="true" title="Campo editable">' + data.productos[i].recipiente + '</td>' +
            '<td contenteditable="true" title="Campo editable">' + data.productos[i].litros_recipiente + '</td>' +
            '<td><img class="imagenProductoTabla" title="Pulse para modificar" width="80" height="80" alt="' + data.productos[i].descripcion + '" src="' + data.productos[i].imagen + '"></td>' +
            '<td title="Pulse para modificar con los datos introducidos"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></td>' +
            '<td title="Pulse para eliminar el producto"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></td>' +
            '</tr>');

    }

}