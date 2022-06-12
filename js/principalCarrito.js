/////////////////////// REFERENCIA A LOS ELEMENTOS DE LA PÁGINA ////////////////////////////////////////////*/

const cuerpoPaginaCarrito = $('#cuerpoPaginaCarrito');
const filasProductos = $('#filasProductos');
const compruebaContenido = filasProductos.find('div.row.align-items-center.mt-1').length;

//Referencia a la zona de las cantidades finales a pagar de la zona del carrito, subtotal, envío y total.
const subtotalCompra = $('#subtotalCompra');
const envioCompra = $('#envioCompra');
const totalCompra = $('#totalCompra');
const finalizarCompra = $('#finalizarCompra');

/*Referencia a los contenedores que contienen los div de inicio de sesión, registro de sesión, pantalla de opacidad
para la página y contenedor de registro de cliente en el formulario de registro de usuario. Todos ellos guardan relación
con el carrito de la compra para poder mandar los pedidos a dicho usuario que lo utilice. Todos ellos empezarán ocultos por defecto*/
const contenedorOscuro = $('#contenedorOscuro');
contenedorOscuro.hide();

const inicioSesionUsuario = $('#inicioSesionUsuario');
const cierraInicioSesion = $('#cierraInicioSesion');
const registroDesdeInicio = $('#registroDesdeInicio');
const btnIniciarSesion = $('#btnIniciarSesion');
inicioSesionUsuario.hide();

const registroUsuario = $('#registroUsuario');
const cierraRegistroUsuario = $('#cierraRegistroUsuario');
const inicioDesdeRegistro = $('#inicioDesdeRegistro');
registroUsuario.hide();

//Check de crear cuenta y apartado de crear cuenta habilitado de inicio
const permitirReg = $('#permitirReg');
const apartadoRegCLiente = $('#apartadoRegCLiente');
permitirReg.prop('checked','checked');
apartadoRegCLiente.show();

//Referencia al icono de usuario de la tienda y al span donde irá su nombre o datos
const iconoUsuarioTienda = $('#iconoUsuarioTienda');

const nombreUsuarioSesionTienda = $('#nombreUsuarioSesionTienda');//Div con el botón desplegable con el nombre de usuario
nombreUsuarioSesionTienda.hide();//Oculto por defecto
const despUsuario = $('#nombreUsuarioSesionTienda button span').text();//Span del botón desplegable con el nombre de usuario

const nombreUsuarioSesionCarrito = $('#nombreUsuarioSesionCarrito')//Nombre del usuario del carrito

//Referencia a los campos del formulario de registro o envío de datos
const formularioRegistroUsuarios = document.getElementById('formularioRegistroUsuarios');
const btnRegistroUsuario = $('#btnRegistroUsuario');
const btnResetUsuario = $('#btnResetUsuario');
const nombreReg = $('#nombreReg');
const apeReg = $('#apeReg');
const dniReg = $('#dniReg');
const telReg = $('#telReg');
const numCasaReg = $('#numCasaReg');
const emailReg = $('#emailReg');
const passReg = $('#passReg');
const passReg2 = $('#passReg2');
const provReg = document.getElementById('provReg');
const munReg = document.getElementById('munReg');
const dirReg = document.getElementById('dirReg');
const cpReg = document.getElementById('cpReg');

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

//Evento sobre el botón de finalizar compra. Donde se revisará si hay un usuario logeado o se pedirá introducir los datos de envío
finalizarCompra.on('click',function () {

    if (nombreUsuarioSesionCarrito.text() === ''){

        inicioSesionUsuario.fadeIn(500);
        contenedorOscuro.fadeIn(200);

    }else if (nombreUsuarioSesionCarrito.text() !== '' && $('div.row.align-items-center.mt-1').length === 0){

        mensajesInfoCorrecto('el carrito está vacio','mensajeErroneo')

    }else if (nombreUsuarioSesionCarrito.text() !== '' && $('div.row.align-items-center.mt-1').length !== 0){

        console.log('YA PUEDES COMPRAR');

    }

})

/*Evento sobre el icono de usuario de la página de la tienda que te da la posibilidad de iniciar sesión. También te
* ofrece la posibilidad de registrarte abriendo el formulario de datos de envío */
iconoUsuarioTienda.on('click',function () {


    if (despUsuario === "" && nombreUsuarioSesionCarrito.text() === "") {

        inicioSesionUsuario.fadeIn(500);
        contenedorOscuro.fadeIn(200);

    }

})

//Evento de cierre del formulario de inicio de sesión
cierraInicioSesion.on('click',function () {

    inicioSesionUsuario.fadeOut(200);
    contenedorOscuro.fadeOut(500);

})

//Evento sobre el enlace del formulario de inicio de sesión para pasar al formulario de datos de envío
registroDesdeInicio.on('click',function () {

    inicioSesionUsuario.slideUp(500);
    registroUsuario.fadeIn(200);

})

//Evento sobre el cierre del formulario de envío de datos de registro
cierraRegistroUsuario.on('click',function () {

    registroUsuario.fadeOut(200);
    contenedorOscuro.fadeOut(500);

})

//Evento sobre el enlace del formulario de envío de datos o registro para pasar al formulario de inicio de sesión
inicioDesdeRegistro.on('click',function () {

    inicioSesionUsuario.fadeIn(500);
    registroUsuario.slideUp(200);

})

//Evento sobre el check de crear cuenta como cliente dentro del formulario de envío de datos
permitirReg.on('click',function () {

    if ($(this).prop('checked') === true){

        apartadoRegCLiente.show();

    }else{

        apartadoRegCLiente.hide();

    }

})

//Evento sobre el cambio del select de las provincias a la hora del registro de envío de datos
provReg.addEventListener("change",function () {

    if (provReg.value === "PROVINCIA"){

        munReg.length = 0;
        let optionMun = document.createElement("option");
        optionMun.textContent = "MUNICIPIO";
        optionMun.value = "MUNICIPIO";
        munReg.appendChild(optionMun);

        dirReg.length = 0;
        let optionDir = document.createElement("option");
        optionDir.textContent = "DIRECCIÓN";
        optionDir.value = "DIR";
        optionDir.style.textAlign = "center";
        dirReg.appendChild(optionDir);

        cpReg.length = 0;
        let optionCp = document.createElement("option");
        optionCp.textContent = "COD. POSTAL";
        optionCp.value = "C.POSTAL";
        optionCp.style.textAlign = "center";
        cpReg.appendChild(optionCp);


    }else {

        const datos = new FormData();
        datos.append('controlador', 'registro');
        datos.append('accion', 'muestraMunicipio');
        datos.append('Provincia', provReg.value);

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

                    munReg.length = 0;

                    if (dirReg.length > 1) {

                        dirReg.length = 0;
                        let option = document.createElement("option");
                        option.textContent = "DIRECCIÓN";
                        option.value = "DIR";
                        option.style.textAlign = "center";
                        dirReg.appendChild(option);

                    }

                    if (cpReg.length >= 1) {

                        cpReg.length = 0;
                        let option = document.createElement("option");
                        option.textContent = "COD. POSTAL";
                        option.value = "C.POSTAL";
                        option.style.textAlign = "center";
                        cpReg.appendChild(option);

                    }

                    for (let i = 0; i < Obj.length; i++) {

                        let option = document.createElement("option");
                        option.textContent = Obj[i];
                        option.value = Obj[i];
                        munReg.appendChild(option);

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
munReg.addEventListener("change",function () {

    mostrarCodPost();
    let datos = new FormData();
    datos.append('controlador', 'registro');
    datos.append('accion', 'muestraDireccion');
    datos.append('Provincia', provReg.value);
    datos.append("Municipio", munReg.value);

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

                dirReg.length = 0;

                for (let i=0;i<Obj.length;i++){

                    let option = document.createElement("option");
                    option.textContent = Obj[i];
                    option.value = Obj[i];
                    dirReg.appendChild(option);

                }

            }else{

                alert("¡¡ERROR EN LA SELECCIÓN DE LAS DIRECCIONES!!")

            }
        })
        .catch(function(err) {
            console.log(err);
        });

})

//Evento sobre el botón de reset del formulario de registro para poder reiniciar los campos que no lo hacen automáticamente
btnResetUsuario.on('click',function () {

    reinicioSelectDir(munReg,dirReg,cpReg);
    formularioRegistroUsuarios.reset();

})

//Evento sobre el botón del envío de los datos del formulario de registro
btnRegistroUsuario.on('click',function (e) {

    e.preventDefault();
    if (validaDatosEnvioRegistro()) {

        let datos = new FormData(formularioRegistroUsuarios);
        datos.append('controlador','registro');
        datos.append('accion','registroUsuarios');

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

                    if (data.codigo === 1){

                        mensajesInfoCorrecto(data.msg,'mensajeCorrecto');
                        setTimeout(function () {

                            mensajesInfoCorrecto(data.msgCorreo,'mensajeCorrecto');

                        },3000);


                    }else if (data.codigo === 0 || data.codigo === -1){

                        mensajesInfoCorrecto(data.msg,'mensajeCorrecto');

                    }

                    reinicioSelectDir(munReg,dirReg,cpReg);
                    formularioRegistroUsuarios.reset();
                    registroUsuario.slideUp(200);
                    contenedorOscuro.fadeOut(500);

                }else{

                    alert('ERROR EN EL OBJETO RECIBIDO')

                }

            })
            .catch(err => {

                alert(err);

            })



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

//Función que muestra los códigos postales en un select según el municipio seleccionado anteriormente
function mostrarCodPost() {

    const datos = new FormData();
    datos.append('controlador', 'registro');
    datos.append('accion', 'muestraCp');
    datos.append("Municipio", munReg.value);
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

                cpReg.length = 0;

                for (let i=0;i<Obj.length;i++){

                    let option = document.createElement("option");
                    option.textContent = Obj[i];
                    option.value = Obj[i];
                    cpReg.appendChild(option);

                }

            }else{

                alert("¡¡ERROR EN LA SELECCIÓN DE LOS CÓDIGOS POSTALES!!")

            }
        })
        .catch(function(err) {
            console.log(err);
        });

}

//Función para la validación de los campos de datos de envío o registro
function validaDatosEnvioRegistro() {

    let exprNombre = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+/;
    if (nombreReg.val() === '' || !exprNombre.test(String(nombreReg.val()))){

        mensajesInfoCorrecto('introduzca un nombre correcto','mensajeErroneo');
        nombreReg.val('');
        nombreReg.focus();
        return false;

    }

    let exprApe = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/;
    if (apeReg.val() === '' || !exprApe.test(String(apeReg.val()))){

        mensajesInfoCorrecto('introduzca unos apellidos correctos','mensajeErroneo');
        apeReg.val('');
        apeReg.focus();
        return false;

    }

    if (dniReg.val() !== '' && !validacionDNI(dniReg.val())){

        dniReg.val('');
        dniReg.focus();
        return false;

    }

    let exprTel = /(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){8}/;
    if (telReg.val() === '' || !exprTel.test(telReg.val())){

        mensajesInfoCorrecto('introduzca un teléfono correcto','mensajeErroneo');
        telReg.val('');
        telReg.focus();
        return false;

    }

    if (provReg.value === 'PROVINCIA'){

        mensajesInfoCorrecto('seleccione una provincia','mensajeErroneo');
        provReg.focus();
        return false;

    }

    if (munReg.value === 'MUNICIPIO'){

        mensajesInfoCorrecto('seleccione un municipio','mensajeErroneo');
        munReg.focus();
        return false;

    }

    if (dirReg.value === 'DIR'){

        mensajesInfoCorrecto('indique una dirección','mensajeErroneo');
        dirReg.focus();
        return false;

    }

    if (cpReg.value === 'COD.POSTAL'){

        mensajesInfoCorrecto('indique un código postal','mensajeErroneo');
        cpReg.focus();
        return false;

    }

    if (numCasaReg.val() < 1 || numCasaReg.val() > 999){

        mensajesInfoCorrecto('indique el número de casa','mensajeErroneo');
        numCasaReg.val(1);
        numCasaReg.focus();
        return false;

    }

    let exprEmail = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    if (emailReg.val() === '' || !exprEmail.test(emailReg.val())){

        mensajesInfoCorrecto('introduzca un email correcto','mensajeErroneo');
        emailReg.val('');
        emailReg.focus();
        return false;

    }

    if(apartadoRegCLiente.is(':visible')){

        if (passReg.val() === '' || passReg.val().length < 4 || passReg.val().length > 10){

            mensajesInfoCorrecto('introduzca una contraseña correcta','mensajeErroneo');
            passReg.val('');
            passReg.focus();
            return false;

        }else if (!validarPasswd(passReg.val(),passReg2.val())){

            return false;

        }

    }

    return true;

}

//Función que valida el dni
function validacionDNI(dni){

    let letra = 'TRWAGMYFPDXBNJZSQVHLCKET';

    let expresionRegularDni = /^\d{8}[a-zA-Z]$/; //Comienza con 8 letras y un carácter
    if (!expresionRegularDni.test(dni)){

        mensajesInfoCorrecto('introduzca un dni correcto','mensajeErroneo');
        return false;

    }

    let miNumero = dni.substring(0, dni.length-1);  //sacamos el número introducido
    let miLetra = dni.substring(dni.length, 8);   //sacamos la letra introducida
    miNumero = miNumero % 23; //sacamos el índice correspondiente a mi letra a partir del número aplicándole el módulo
    let letraSeleccionada = letra.substring(miNumero, miNumero +1);  //Sacamos la letra que me corresponde

    if (letraSeleccionada !== miLetra.toUpperCase()){

        mensajesInfoCorrecto('la letra del dni no se corresponde','mensajeErroneo')
        return false;
    }

    ocultarMsgError();
    return true;

}

//Función para validadr las dos contraseñas del usuario
function validarPasswd(){

    let espacios = false;
    let cont = 0;

    while (!espacios && (cont < passReg.val().length)){

        if (passReg.val().charAt(cont) === " ")
            espacios = true;
        cont++;

    }

    if (espacios){

        mensajesInfoCorrecto('la contraseña no puede tener espacios en blanco','mensajeErroneo');
        passReg.focus();
        passReg.val('');
        return false;

    }

    if (passReg.val() !== passReg2.val()){

        mensajesInfoCorrecto('las contraseñas deben coincidir','mensajeErroneo');
        passReg2.val('');
        passReg2.focus();
        return false;

    }else{

        return true;

    }

}

//Función que reinicia los campos de municipio, dirección y código postal del formulario de registro
/* FUNCIÓN QUE REINICIA LOS CAMPOS DE LOS SELECT DE LA DIRECCIÓN DEL SOCIO */
function reinicioSelectDir(campoMun, campoDir, campoCp) {

    campoMun.length = 0;
    let optionMun = document.createElement("option");
    optionMun.textContent = "MUNICIPIO";
    optionMun.value = "MUNICIPIO";
    optionMun.style.textAlign = "center";
    campoMun.appendChild(optionMun);

    campoDir.length = 0;
    let optionDir = document.createElement("option");
    optionDir.textContent = "DIRECCIÓN";
    optionDir.value = "DIR";
    optionDir.style.textAlign = "center";
    campoDir.appendChild(optionDir);

    campoCp.length = 0;
    let optionCp = document.createElement("option");
    optionCp.textContent = "CÓDIGO POSTAL";
    optionCp.value = "COD.POSTAL";
    optionCp.style.textAlign = "center";
    campoCp.appendChild(optionCp);

}
