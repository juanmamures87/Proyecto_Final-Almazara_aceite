/*///////////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA ////////////////////////////////////////////*/

//Referencia al cuerpo de la tienda que contiene los productos
const cuerpoPaginaTienda = $('#cuerpoPaginaTienda');
let carritoCompra = [];

//Referencia a la muestra del carrito de la compra que se puede consultar en cualquier momento al inicio de la página
const productosCarritoSup = document.getElementById('productosCarritoSup');
const cantidadProductosCarrito = document.getElementById('cantidadProductosCarrito');
const precioTotalProductosCarrito = document.getElementById('precioTotalProductosCarrito');
const cuerpoZonaCarritoSuperior = $('.cart-inline-body')
const irCarrito = document.getElementById('irCarrito');

//Referencia al mensaje que haremos apareces cuando se produzca cualquier evento para que el usuario esté informado
const mensajeTienda = $('#mensajeTienda');

/*///////////////////////////////////////////// UTILIZACIÓN DE FUNCIONES /////////////////////////////////////////////*/


/*////////////////////////////////////////////////// EVENTOS ////////////////////////////////////////////////////////*/

//Evento sobre los botones de añadir un producto al carrito.
cuerpoPaginaTienda.on('click','.btn.btn-primary.addCarrito',function (e) {

    e.preventDefault();
    let tarjetaCarritoSuperior = $('div.cart-inline-item');
    let encontrado = false;

    let idProducto = $(this).data('id');
    let nombre = $(this).data('des');
    let dcto = $(this).data('dcto');
    let idCategoria = $(this).data('idcat');
    let nombreCategoria = $(this).data('cat');
    let recipiente = $(this).data('recipi');
    let ltrRecipiente = $(this).data('ltrecipi');
    let imagen = $(this).data('img');
    let precioProducto = $(this).data('preciofinal');

    /*Si la colección de tarjetas del carrito superior es mayor a cero recorremos las tarjetas para ver si el producto
    que vamos a seleccionar ya está y actualizamos el que hay si no metemos el nuevo producto.*/
    if (tarjetaCarritoSuperior.length > 0) {
        tarjetaCarritoSuperior.each(function () {

            if ($(this).data('idproducto') === idProducto) {

                //Actualizamos los datos del producto que ya esté en el carrito y actualizamos los datos generales del carrito
                actualizaCarritoSuperior(1, 1, precioProducto);
                $('input.form-input',this).val(parseInt($('input.form-input',this).val()) + 1);
                mensajesInfoCorrecto('producto añadido al carrito', 'mensajeCorrecto');
                encontrado = true;

            }

        })

        //Si el producto no se ha encontrado metemos un producto nuevo en el carrito
        if (encontrado === false){

            creaTarjetaCarritoSuperior(idProducto, idCategoria, imagen, nombre, precioProducto,dcto, nombreCategoria,recipiente,ltrRecipiente);
            actualizaCarritoSuperior(1, 1, precioProducto);
            mensajesInfoCorrecto('producto añadido al carrito', 'mensajeCorrecto');

        }

    }else{

        creaTarjetaCarritoSuperior(idProducto, idCategoria, imagen, nombre, precioProducto,dcto, nombreCategoria,recipiente,ltrRecipiente);
        actualizaCarritoSuperior(1, 1, precioProducto);
        mensajesInfoCorrecto('producto añadido al carrito', 'mensajeCorrecto');

    }

})

$(function () {

    let tarjetaCarritoSuperior = $('div.cart-inline-item');
    let carrito = JSON.parse(sessionStorage.getItem('carritoCompra'));
    if (tarjetaCarritoSuperior.length === 0 && carrito.length > 0){

        for (const i in carrito) {

            creaTarjetaCarritoSuperior(carrito[i].idProducto, carrito[i].idCat, carrito[i].imagen, carrito[i].nombre,
                carrito[i].precioUni,carrito[i].dcto,carrito[i].nombreCat, carrito[i].recipiente, carrito[i].ltrRecipi);

        }

    }else{

        console.log('el carrito no se puede cargar, porque no existe');

    }

})

/*Evento para capturar el cambio de cantidades en los productos del carrito de la zona superior de la página para actualizar
las cantidades de producto y con lo cual el precio a pagar*/
cuerpoZonaCarritoSuperior.on('input','input.form-input.cantidad',function () {

    let tarjetaCarritoSuperior = $('div.cart-inline-item');
    //let inputDatos = $(this).parent('div').siblings('input').data();
    let sumaTotal = 0;
    let productosTotales = 0;

    //Al cambiar las cantidades de producto mediante el input vamos variando la cantidad total y el precio total del carrito
    tarjetaCarritoSuperior.each(function () {

        let precioXproducto = parseInt($('input.form-input',this).val()) * parseFloat($('h6:nth-child(2)',this).text());
        let cantidadProducto = parseInt($('input.form-input',this).val());

        sumaTotal = sumaTotal + precioXproducto;
        productosTotales = productosTotales + cantidadProducto;

    })
    sumaTotal = sumaTotal.toFixed(2)
    productosCarritoSup.textContent = ' ' + String(productosTotales);
    cantidadProductosCarrito.textContent = ' ' + String(productosTotales);
    precioTotalProductosCarrito.textContent = ' ' + String(sumaTotal);

})

/*Evento sobre el botón de ir al carrito de la compra. Se crea un objeto por cada producto que hay en el carrito de la
zona superior de tienda con todos los datos referentes a él. Cada objeto se mete en un array y seguidamente
se mete en sessionStorage, en la memoria del navegador durante la sesión iniciada, cuando se cierren las pestañas este
elemento se eliminará*/
irCarrito.addEventListener('click',function (event) {

    carritoCompra.length = 0;
    let tarjetaCarritoSuperior = $('div.cart-inline-item');
    tarjetaCarritoSuperior.each(function () {

        let producto = {

            idProducto: $('input.datosProducto',this).data('idproducto'),
            nombre:     $('input.datosProducto',this).data('nombre'),
            idCat:      $('input.datosProducto',this).data('idcategoria'),
            nombreCat:  $('input.datosProducto',this).data('nombrecat'),
            dcto:       $('input.datosProducto',this).data('dcto'),
            recipiente: $('input.datosProducto',this).data('recipiente'),
            ltrRecipi:  $('input.datosProducto',this).data('ltrecipiente'),
            imagen:     $('input.datosProducto',this).data('imagen'),
            cantidad:   parseInt($('input.form-input.cantidad',this).val()),
            precioUni:  $('input.datosProducto',this).data('precio')

        }

        carritoCompra.push(producto);

    })

    sessionStorage.setItem('carritoCompra',JSON.stringify(carritoCompra));
    irCarrito.setAttribute('href','carrito');

})

/*/////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////*/

/*Función que asigna un número superior al carrito de la página principal, para que el usuario pueda verlo en cada momento,
el número de productos en el interior del carrito y el precio total a pagar del carrito*/
function actualizaCarritoSuperior(numeroSup, numeroInterior, precioTotal) {

    productosCarritoSup.textContent = ' ' + String(parseInt(productosCarritoSup.textContent) + numeroSup);
    cantidadProductosCarrito.textContent = ' ' + String(parseInt(cantidadProductosCarrito.textContent) + numeroInterior);
    let precio = parseFloat(precioTotalProductosCarrito.textContent) + precioTotal;
    precio = precio.toFixed(2);
    precioTotalProductosCarrito.textContent = ' ' + String(precio);

}

/*Función que muestra un mensaje por pantalla según la acción. Se pasa por parámetro el mensaje y la clase que se
quiere mostrar, como correcto o como erróneo. A su vez también se oculta con un periodo de tiempo para que el usuario
pueda leer su contenido sin problema*/
function mensajesInfoCorrecto(mensaje, claseMensaje) {

    mensajeTienda.text(mensaje.toUpperCase())
    mensajeTienda.removeClass().addClass(claseMensaje);
    mensajeTienda.fadeIn(200);
    setTimeout(ocultarMensajes,2000);

}

//Función que oculta los mensajes de información con una pequeña transición
function ocultarMensajes() {

    if (mensajeTienda.is(':visible')){

        mensajeTienda.fadeOut(2000);
    }

}

//Función que crea una tarjeta nueva de un producto en la parte del carrito de la parte superior de la página
function creaTarjetaCarritoSuperior(idProducto, idCategoria, imagen, nombre, precioProducto, dcto, nombreCat, recipiente,ltrRecipiente) {

    cuerpoZonaCarritoSuperior.append('<div class="cart-inline-item" data-idproducto="' + idProducto + '" >' +
        '                            <div class="unit align-items-center">' +
        '                              <div class="unit-left imagen"><img src="' + imagen + '" alt="" width="108" height="100"/></div>' +
        '                              <div class="unit-body">' +
        '                                <h6 class="cart-inline-name">' + nombre + '</h6>' +
        '                                <div>' +
        '                                  <div class="group-xs group-inline-middle">' +
        '                                    <div class="table-cart-stepper">' +
        '                                      <input class="form-input cantidad" type="number" data-zeros="true" value="1" min="1" max="1000">' +
        '                                    </div>' +
        '                                    <h6 class="cart-inline-title mt-2 precio">' + precioProducto + '€</h6>' +
        '                                    <input type="hidden" class="datosProducto" ' +
        '                                           data-idproducto="' + idProducto + '"' +
        '                                           data-precio="' + precioProducto + '" ' +
        '                                           data-nombre="' + nombre + '" ' +
        '                                           data-idcategoria="' + idCategoria + '" ' +
        '                                           data-dcto="' + dcto + '" ' +
        '                                           data-nombrecat="' + nombreCat + '" ' +
        '                                           data-recipiente="' + recipiente + '" ' +
        '                                           data-ltrecipiente="' + ltrRecipiente + '" ' +
        '                                           data-imagen="' + imagen + '">' +
        '                                  </div>' +
        '                                </div>' +
        '                              </div>' +
        '                            </div>' +
        '                          </div>');

}