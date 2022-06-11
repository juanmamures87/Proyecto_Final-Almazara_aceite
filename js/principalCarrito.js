/////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA ////////////////////////////////////////////*/

const cuerpoPaginaCarrito = $('#cuerpoPaginaCarrito');
const filasProductos = $('#filasProductos');
const compruebaContenido = filasProductos.find('div.row.align-items-center.mt-1').length;

//Referencia a la zona de las cantidades finales a pagar de la zona del carrito, subtotal, envío y total.
const subtotalCompra = $('#subtotalCompra');
const envioCompra = $('#envioCompra');
const totalCompra = $('#totalCompra');

/*/////////////////////////////////////////// UTILIZACIÓN DE FUNCIONES /////////////////////////////////////////////*/

/*Función anónima que carga el carrito del usuario que está almacenado en la memoria del navegador. Después de cargar
todos los productos en el carrito de la compra recoge los precios totales y actualiza el apartado de finalización de la
compra*/
$(function () {

    if (sessionStorage.getItem('carrito') !== null) {
        let carrito = JSON.parse(sessionStorage.getItem('carrito'));
        if (compruebaContenido === 0 && carrito.length > 0) {

            for (const i in carrito) {

                creaFilaPaginaCarrito(carrito[i].idProducto, carrito[i].imagen, carrito[i].nombre, carrito[i].precioUni, carrito[i].cantidad,
                    carrito[i].idCat, carrito[i].dcto, carrito[i].nombreCat, carrito[i].recipiente, carrito[i].ltrRecipi,);

            }

            actualizaPrecioFinal();

        }

    }
    
})

/*////////////////////////////////////////////////// EVENTOS ////////////////////////////////////////////////////////*/

/*Evento sobre las flechas del input de la cantidad de los productos. Para actualizar la cantidad de producto a comprar
y los precios a pagar*/
cuerpoPaginaCarrito.on('input','.form-input.cantidadCarrito', function () {

    let filaProducto = $('div.row.align-items-center.mt-1');
    let sumaTotal = 0;

    //Al cambiar las cantidades de producto mediante el input vamos variando la cantidad total y el precio total del carrito
    filaProducto.each(function () {

        let precioXproducto = parseInt($('.form-input.cantidadCarrito', this).val()) * parseFloat($('.col-lg-2.precioUni',this).text());
        let cantidadProducto = parseInt($('.form-input.cantidadCarrito', this).val());
        precioXproducto = precioXproducto.toFixed(2);
        $('.col-lg-2.precioTotalProducto',this).text(precioXproducto + "€");

    })

    actualizaPrecioFinal();
    guardarCarritoPaginaCompras();

})

//Evento sobre el icono de la papelera que eliminará los productos del carrito
cuerpoPaginaCarrito.on('click','.fa.fa-trash-o.fa-1x.basuraProducto.mr-2.mt-5.text-danger',function () {

    let tarjetaCarritoSuperior = $('div.row.align-items-center.mt-1');
    if (tarjetaCarritoSuperior.length === 1) {

        $(this).closest('div.row.align-items-center.mt-1').remove();
        carritoCompra.length = 0;
        sessionStorage.removeItem('carrito');
        mensajesInfoCorrecto('se eliminaron los productos del carrito', 'mensajeErroneo');
        subtotalCompra.text(0 + "€");
        totalCompra.text(0 + "€");

    }else{

        $(this).closest('div.row.align-items-center.mt-1').remove();

        actualizaPrecioFinal();
        guardarCarritoPaginaCompras();

    }

})

/*/////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////////////////////////*/

//Función que crea una fila con los datos del producto en la tabla de la página del carrito
function creaFilaPaginaCarrito(idProducto, imagen, nombre, precioUnitario, cantidad, idCategoria, dcto, nombreCat, recipiente, ltrRecipiente) {

    let precioTotalProducto = precioUnitario * cantidad;

    filasProductos.append('<div class="row align-items-center mt-1">' +
        '                <div class="col-lg-2"><i class="fa fa-trash-o fa-1x basuraProducto mr-2 mt-5 text-danger" style="color: red;" aria-hidden="true"></i>' +
        '                  <img class="bg-light" src="' + imagen + '" width="108" height="100" alt="' + nombre + '"></div>' +
        '                <div class="col-lg-4">' + nombre + '</div>' +
        '                <div class="col-lg-2 precioUni">' + precioUnitario + '€</div>' +
        '                <div class="col-lg-2">' +
        '                  <div class="table-cart-stepper">' +
        '                    <input class="form-input cantidadCarrito" type="number" data-zeros="true" value="' + cantidad + '" min="1" max="1000">' +
        '                   </div>' +
        '                </div>' +
        '                <div class="col-lg-2 precioTotalProducto">' + precioTotalProducto + '€</div>' +
        '                <input type="hidden" class="datosProducto"' +
        '                       data-idproducto="' + idProducto +'"' +
        '                       data-precio="' + precioUnitario + '"' +
        '                       data-nombre="' + nombre + '"' +
        '                       data-idcategoria="' + idCategoria + '"' +
        '                       data-dcto="' + dcto + '"' +
        '                       data-nombrecat="' + nombreCat + '"' +
        '                       data-recipiente="' + recipiente + '"' +
        '                       data-ltrecipiente="' + ltrRecipiente + '"' +
        '                       data-imagen="' + imagen + '">' +
        '              </div>');

}

//Función que actualiza los datos del apartado de finalización de la compra con los productos que hay en la tabla del carrito
function actualizaPrecioFinal() {

    let filaProducto = $('div.row.align-items-center.mt-1')
    let sumaTotal = 0;

    filaProducto.each(function () {

        let preciosTotalesXproducto = parseFloat($('div:last-of-type',this).text());
        sumaTotal = sumaTotal + preciosTotalesXproducto;

    })

    sumaTotal = sumaTotal.toFixed(2)
    subtotalCompra.text(sumaTotal + "€");
    let sumaFinal;
    sumaTotal >= 100 ? sumaFinal = sumaTotal : sumaFinal = parseFloat(sumaTotal) + parseInt(envioCompra.text());
    totalCompra.text(sumaFinal + "€");
    totalCompra.css('font-weight','bold');
    
}

/*Función para guardar el carrito de la compra en la memoria del navegador con sessionStorage.
Se crea un objeto por cada producto que hay en la página principal del carrito con todos los datos
referentes a él. Cada objeto se mete en el array y seguidamente se mete en sessionStorage, en la memoria del navegador
durante la sesión iniciada. A su vez, también hace que el carrito se elimine de la memoria del navegador pasadas 4 horas.
Si el usuario cierra la pestaña en la que está realizando los trámites se eliminará directamente.*/
function guardarCarritoPaginaCompras() {

    carritoCompra.length = 0;
    let filaCarrito = $('.row.align-items-center.mt-1');
    filaCarrito.each(function () {

        let producto = {

            idProducto: $('input.datosProducto',this).data('idproducto'),
            nombre:     $('input.datosProducto',this).data('nombre'),
            idCat:      $('input.datosProducto',this).data('idcategoria'),
            nombreCat:  $('input.datosProducto',this).data('nombrecat'),
            dcto:       $('input.datosProducto',this).data('dcto'),
            recipiente: $('input.datosProducto',this).data('recipiente'),
            ltrRecipi:  $('input.datosProducto',this).data('ltrecipiente'),
            imagen:     $('input.datosProducto',this).data('imagen'),
            cantidad:   parseInt($('input.form-input.cantidadCarrito',this).val()),
            precioUni:  $('input.datosProducto',this).data('precio')

        }

        carritoCompra.push(producto);

    })

    sessionStorage.setItem('carrito',JSON.stringify(carritoCompra));
    setTimeout(eliminaCarritoMemoria,14400000)

}