<?php

    require_once "modelo/SocioModelo.php";
    $socios = new SocioModelo();

    require_once "modelo/ParcelaModelo.php";
    $parcelas = new ParcelaModelo();

    require_once "modelo/ProduccionModelo.php";
    $producciones = new ProduccionModelo();

    require_once 'modelo/ProductoModelo.php';
    $productos = new ProductoModelo();

    function eliminarSocio(){

        if (isset($_POST['idBorrar']) && !empty($_POST['idBorrar'])){

            global $socios;

            $socioEliminado = $socios->eliminarSocio($_POST['idBorrar']);

            if ($socioEliminado){

                $resultado = [

                    "codigo"    => 1,
                    "msg"       => "USUARIO ELIMINADO CORRECTAMENTE"

                ];

            }else{

                $resultado = [

                    "codigo"    => 0,
                    "msg"       => "EL USUARIO NO PUDO ELIMINARSE"

                ];

            }

        }else{

            $resultado = [

                "codigo"    => -1,
                "msg"       => "ERROR!! NO SE HA RECIBIDO EL ID DE USUARIO A BORRAR"

            ];

        }

        echo json_encode($resultado);
        //var_dump($resultado);

    }

    function actualizarSocio(){

        if (isset($_POST['datosUsuario'],$_POST['idUsuarioAct']) && !empty($_POST['datosUsuario']) && !empty($_POST['idUsuarioAct'])){

            $idUsuario = $_POST['idUsuarioAct'];
            $datos = json_decode($_POST['datosUsuario']);
            global $socios;

            $datos->acceso === "Activo" ? $acceso = 1 : $acceso = 0;
            $datos->fechaBaja === "" ? $fecha = null : $fecha = $datos->fechaBaja;
            $datos->piso === "" ? $piso = null : $piso = $datos->piso;
            $datos->puerta === "" ? $puerta = null : $puerta = $datos->puerta;

            $socioActualizado = $socios->actualizarSocio($idUsuario, $datos->telefono, $datos->provincia, $datos->municipio,
            $datos->direccion, $datos->cp, $datos->num_casa, $piso, $puerta, $datos->email, $acceso,
                $datos->tipo, $fecha);

            if ($socioActualizado){

                $respuesta = [

                    "codigo"    => 1,
                    "msg"       => "SOCIO ACTUALIZADO CORRECTAMENTE"

                ];

            }else{

                $respuesta = [

                    "codigo"    => 0,
                    "msg"       => "SE PRODUJO UN ERROR. SOCIO NO ACTUALIZADO"

                ];

            }


            echo json_encode($respuesta);
            //var_dump($respuesta);

        }else{

            $respuesta = [

                "codigo"    => -1,
                "msg"       => "NO SE RECIBIÓ EL ID NECESARIO PARA ACTUALIZAR"

            ];

        }

    }

    function paginarSocios(){

        if (isset($_POST['pagina'])) {

            global $socios;
            $paginar = $socios->mostrarSocios($_POST['pagina']);
            echo json_encode($paginar);

        }

    }

    //////////////////////////////////////////// ZONA DE LAS PARCELAS /////////////////////////////////////////////////

    //No hay manera de que funcione, no recoge la RC de ninguna manera. Dejarla y probar si responde catastro
    function mostrarPoliParceSuperf(){

        require_once "../librerias/nusoap/lib/nusoap.php";

        if (isset($_POST['provincia'], $_POST['municipio'], $_POST['refcat']) && !empty($_POST['provincia']) &&
            !empty($_POST['municipio']) && !empty($_POST['refcat'])) {

            $provincia = $_POST['provincia'];
            $municipio = $_POST['municipio'];
            $refcat = $_POST['refcat'];

            /*A continuación obtenemos el servicio web del catastro que nos proporciona todo lo referente a una parcela, pasándole
            una provincia, un municipio y su referencia catastral.
            Obtenemos una variable que almacena todos los datos y la pasamos a la vista.*/

            //Crear un cliente apuntando al script del servidor (Creado con WSDL)
            $cliente = new nusoap_client('https://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?wsdl', true);
            //SOAPAction: "http://tempuri.org/OVCServWeb/OVCCallejero/Consulta_DNPRC"
            // Se comprueba si se puede conectar con el servicio
            $error = $cliente->getError();
            if ($error) {

                echo '<pre style="color: red">' . $error . '</pre>';
                echo '<p style="color:red;' > htmlspecialchars($cliente->getDebug(), ENT_QUOTES) . '</p>';
                die();

            }
            // 2. Llamar a la función getCliente del servidor

            $resultado = $cliente->call('Consulta_DNPRC',
                array(
                    'Provincia' => $provincia,
                    'Municipio' => $municipio,
                    'RC'        => $refcat));

            // Verificación que los parámetros están ok, y si lo están. mostrar rta.
            if ($cliente->fault) {

                echo '<b>Error: ';
                print_r($resultado);
                echo '</b>';

            } else {

                $error = $cliente->getError();
                if ($error) {

                    echo '<b style="color: red">Error: ' . $error . '</b>';

                } else {

                    echo json_encode($resultado);
                    /*var_dump($resultado);
                    var_dump($refcat);
                    var_dump($provincia);
                    var_dump($municipio);*/

                }
            }

        }else{

            $resultado = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA, MUNICIPIO Y REF. CATASTRAL PARA CONSULTAR LOS DATOS"

            ];


            echo json_encode($resultado);
            //var_dump($respuesta);

        }

    }

    //Función que muestra el nombre y apellidos de los socios que se realiza en la búsqueda parcial.
    function mostrarSociosXApellidosRegistroParcela(){

        if (isset($_POST['apellido'])) {

            $apellido = $_POST['apellido'];

            global $socios;
            $socioXapellido = $socios->mostrarSocioXApellido($apellido);
            echo json_encode($socioXapellido);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UN APELLIDO VÁLIDO PARA MOSTAR A LOS SOCIOS"

            ];

            echo json_encode($respuesta);

        }
    }

    //Función que lanza como resultado todas las parcelas de un socio determinado por su id
    function mostrarParcelaXsocio(){

        if (isset($_POST['eleccion']) && !empty($_POST['eleccion'])) {

            $idSocio = $_POST['eleccion'];
            $pagina = $_POST['pagina'] ?? 1;
            $busqueda = 'p.id_socio = ' . $idSocio;

            global $parcelas;
            $parcelaXsocio = $parcelas->busquedas($busqueda, $pagina);
            echo json_encode($parcelaXsocio);
        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UN APELLIDO Y NOMBRE DE USUARIO VÁLIDO"

            ];

            echo json_encode($respuesta);

        }
    }

    function mostrarParcelaXprov(){

        if (isset($_POST['eleccion']) && !empty($_POST['eleccion'])) {

            $provincia = $_POST['eleccion'];
            $pagina = $_POST['pagina'] ?? 1;

            global $parcelas;
            $parcelaXprov = $parcelas->busquedaParcelaXprov($provincia,$pagina);
            echo json_encode($parcelaXprov);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function mostrarParcelaXsistema(){

        if (isset($_POST['eleccion']) && !empty($_POST['eleccion'])) {

            $idSistema = $_POST['eleccion'];
            $pagina = $_POST['pagina'] ?? 1;
            $busqueda = 'sis.id_sistema = ' . $idSistema;

            global $parcelas;
            $parcelaXsistema = $parcelas->busquedas($busqueda,$pagina);
            echo json_encode($parcelaXsistema);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function mostrarParcelaXvariedad(){

        if (isset($_POST['eleccion']) && !empty($_POST['eleccion'])) {

            $idVariedad = $_POST['eleccion'];
            $pagina = $_POST['pagina'] ?? 1;
            $busqueda = 'v.id_aceituna = ' . $idVariedad;

            global $parcelas;
            $parcelaXvariedad = $parcelas->busquedas($busqueda,$pagina);
            echo json_encode($parcelaXvariedad);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function mostrarParcelaXsuperficie(){

        if (isset($_POST['eleccion']) && !empty($_POST['eleccion'])) {

            $superficie = $_POST['eleccion'];
            $valoresSuperficie = explode('-',$superficie);
            $menor = $valoresSuperficie[0];
            $mayor = $valoresSuperficie[1];
            $pagina = $_POST['pagina'] ?? 1;
            $busqueda = "p.superficie BETWEEN $menor AND $mayor ";

            global $parcelas;
            $parcelaXsuperficie = $parcelas->busquedas($busqueda,$pagina);
            echo json_encode($parcelaXsuperficie);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function mostrarPracelaXplantas(){

        if (isset($_POST['eleccion']) && !empty($_POST['eleccion'])) {

            $plantas = $_POST['eleccion'];
            $valoresPlantas = explode('-',$plantas);
            $menor = $valoresPlantas[0];
            $mayor = $valoresPlantas[1];
            $pagina = $_POST['pagina'] ?? 1;
            $busqueda = "p.num_plantas BETWEEN $menor AND $mayor ";

            global $parcelas;
            $parcelaXplantas = $parcelas->busquedas($busqueda,$pagina);
            echo json_encode($parcelaXplantas);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function eliminarParcela(){

        if (isset($_POST['idBorrar']) && !empty($_POST['idBorrar'])){

            global $parcelas;

            $socioEliminado = $parcelas->eliminarParcela($_POST['idBorrar']);

            if ($socioEliminado){

                $resultado = [

                    "codigo"    => 1,
                    "msg"       => "PARCELA ELIMINADA CORRECTAMENTE"

                ];

            }else{

                $resultado = [

                    "codigo"    => 0,
                    "msg"       => "LA PARCELA NO PUDO ELIMINARSE"

                ];

            }

        }else{

            $resultado = [

                "codigo"    => -1,
                "msg"       => "ERROR!! NO SE HA RECIBIDO EL ID DE LA PARCELA A BORRAR"

            ];

        }

        echo json_encode($resultado);
        //var_dump($resultado);

    }

    function actualizarParcela(){

        if (isset($_POST['datosParcela'],$_POST['idParcela']) && !empty($_POST['datosParcela']) && !empty($_POST['idParcela'])){

            $idParcela = $_POST['idParcela'];
            $datos = json_decode($_POST['datosParcela']);
            global $parcelas;

            $parcelaActualizado = $parcelas->actualizarParcela($datos->sistema, $datos->variedad, $datos->plantas, $idParcela);

            if ($parcelaActualizado){

                $respuesta = [

                    "codigo"    => 1,
                    "msg"       => "PARCELA ACTUALIZADA CORRECTAMENTE"

                ];

            }else{

                $respuesta = [

                    "codigo"    => 0,
                    "msg"       => "SE PRODUJO UN ERROR. LA PARCELA NO PUDO ACTUALIZARSE"

                ];

            }




        }else{

            $respuesta = [

                "codigo"    => -1,
                "msg"       => "NO SE RECIBIÓ EL ID NECESARIO PARA ACTUALIZAR"

            ];

        }

        echo json_encode($respuesta);
        //var_dump($respuesta);

    }

    //////////////////////////////////////////// ZONA DE PRODUCCIÓN ////////////////////////////////////////////////////

    function mostrarParcelaXsocioProd(){

        if (isset($_POST['idSocio']) && !empty($_POST['idSocio'])) {

            $idSocio = $_POST['idSocio'];

            global $parcelas;
            $parcelaXsocio = $parcelas->mostrarParcelaXsocio($idSocio);
            echo json_encode($parcelaXsocio);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function mostrarProdXsocioTemporada(){

        if (isset($_POST['idSocio'],$_POST['temporada']) && !empty($_POST['idSocio']) && !empty($_POST['temporada'])) {

            $idSocio = $_POST['idSocio'];
            $pagina = $_POST['pagina'] ?? 1;

            $temporadas = explode('/',$_POST['temporada']);
            $yearActual = date($temporadas[0] . '-10-01');
            $yearSiguiente = date($temporadas[1] . '-03-31');
            global $producciones;
            $produccionSocioTemporada = $producciones->busquedasProduccion($idSocio,$yearActual,$yearSiguiente,$pagina);
            echo json_encode($produccionSocioTemporada);

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA VÁLIDA"

            ];

            echo json_encode($respuesta);

        }

    }

    function _10MayoresEntradaXtemp(){

        if (isset($_POST['temporada']) && !empty($_POST['temporada'])){

            $temporadas = explode('/',$_POST['temporada']);
            $inicioTemporada = date($temporadas[0] . '-10-01');
            $finTemporada = date($temporadas[1] . '-03-31');
            global $producciones;
            $_10MayoresEntradasXtemp = $producciones->mostrarMayorEntradaXtemporada($inicioTemporada, $finTemporada);
            echo json_encode($_10MayoresEntradasXtemp);
            //var_dump($_10MayoresEntradasXtemp);

        }else{

            $respuesta = [

                "codigo"    => -1,
                "msg"       => "NO SE RECIBIÓ UNA TEMPORADA CONCRETA PARA REALIZAR LA BÚSQUEDA"

            ];

            echo json_encode($respuesta);
            //var_dump($respuesta);

        }

    }

    function mayoresEntradasHistoria(){

        global $producciones;
        $mayoresEntradasHistoria = $producciones->mayoresEntradasHistoria();
        echo json_encode($mayoresEntradasHistoria);
        //var_dump($_10MayoresEntradasXtemp);


    }

    //////////////////////////////////////////// ZONA DE LA TIENDA ////////////////////////////////////////////////////

    function modificaPrecio(){

        if ((isset($_POST['precioAove']) && !empty($_POST['precioAove'])) || (isset($_POST['precioAov']) && !empty($_POST['precioAov']))){

            $precioAove = $_POST['precioAove'];
            $precioAov = $_POST['precioAov'];
            global $productos;
            $actualizaPrecios = $productos->modificarPrecioAceite($precioAove, $precioAov);
            if ($actualizaPrecios){

                $respuesta = [

                    "codigo"    => 1,
                    "msg"       => 'LOS PRECIOS DEL ACEITE SE ACTUALIZARON CORRECTAMENTE'

                ];


            }else{

                $respuesta = [

                    "codigo"    => 0,
                    "msg"       => 'LOS PRECIOS DEL ACEITE NO SE PUDIERON ACTUALIZAR'

                ];

            }

            echo json_encode($respuesta);
            //var_dump($respuesta);

        }else{

            $respuesta = [

                "codigo"    => -1,
                "msg"       => 'INTRODUZCA UNA CANTIDAD CORRECTA PARA MODIFICAR LOS PRECIOS'

            ];

            echo json_encode($respuesta);
            //var_dump($respuesta);

        }

    }

    function paginarProductos(){

        if (isset($_POST['pagina'])) {

            global $productos;
            $paginarProductos = $productos->mostrarProductosPaginacion($_POST['pagina']);
            echo json_encode($paginarProductos);
            //var_dump($paginarProductos);

        }

    }

    function renovarAceite(){

        global $productos;
        $actualizaAceite = $productos->mostrarLitrosAceite();
        echo json_encode($actualizaAceite);

    }

    function eliminarProducto(){

        if (isset($_POST['idBorrar']) && !empty($_POST['idBorrar'])){

            global $productos;

            $productoBorrado = $productos->eliminarProducto($_POST['idBorrar']);

            if ($productoBorrado){

                $resultado = [

                    "codigo"    => 1,
                    "msg"       => "PRODUCTO ELIMINADO CORRECTAMENTE"

                ];

            }else{

                $resultado = [

                    "codigo"    => 0,
                    "msg"       => "EL PRODUCTO SELECCIONADO NO PUDO ELIMINARSE"

                ];

            }

        }else{

            $resultado = [

                "codigo"    => -1,
                "msg"       => "ERROR!! NO SE HA RECIBIDO EL ID DEL PRODUCTO A BORRAR"

            ];

        }

        echo json_encode($resultado);
        //var_dump($resultado);

    }

    function actualizarDatosProducto(){

        if (isset($_POST['datosProducto'],$_POST['idProducto']) && !empty($_POST['datosProducto']) && !empty($_POST['idProducto'])){

            $idProducto = $_POST['idProducto'];
            $datos = json_decode($_POST['datosProducto']);
            global $productos;

            $productoActualizado = $productos->actualizarDatosProducto($datos->descripcion, $datos->dcto,
                $datos->recipiente, $datos->litros_recipiente, $idProducto);

            if ($productoActualizado){

                $respuesta = [

                    "codigo"    => 1,
                    "msg"       => "PRODUCTO ACTUALIZADO CORRECTAMENTE"

                ];

            }else{

                $respuesta = [

                    "codigo"    => 0,
                    "msg"       => "SE PRODUJO UN ERROR. EL PRODUCTO NO PUDO ACTUALIZARSE"

                ];

            }




        }else{

            $respuesta = [

                "codigo"    => -1,
                "msg"       => "NO SE RECIBIÓ EL ID NECESARIO PARA ACTUALIZAR EL PRODUCTO"

            ];

        }

        echo json_encode($respuesta);
        //var_dump($respuesta);

    }

    function actualizarFoto(){

        if (isset($_POST['idProducto'])){

            if (!$_FILES['imgProducto']['size'] == 0 && !$_FILES['imgProducto']['name'] == '') {

                $idProducto = $_POST['idProducto'];

                // Recibo los datos de la imagen
                $nombre_img = $_FILES['imgProducto']['name'];
                $tipo = $_FILES['imgProducto']['type'];
                $tamano = $_FILES['imgProducto']['size'];

                //Si existe imagen y tiene un tamaño correcto
                if (($nombre_img == !NULL) && ($tamano <= 200000)) {
                    //indicamos los formatos que permitimos subir a nuestro servidor
                    if (($tipo == "image/gif") || ($tipo == "image/jpeg") || ($tipo == "image/jpg") || ($tipo == "image/png")
                        || ($tipo == "image/jfif")) {

                        // Ruta donde se guardarán las imágenes que subamos
                        $directorio = "images/productos/";
                        // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                        move_uploaded_file($_FILES['imgProducto']['tmp_name'], $directorio . $nombre_img);
                        $rutaImagen = $directorio . $nombre_img;
                    } else {

                        //si no cumple con el formato
                        $resultado = [

                            "codigo" => -4,
                            "msg" => "ESE FORMATO DE IMAGEN NO ES COMPATIBLE"

                        ];

                        echo json_encode($resultado);
                        //var_dump($resultado);

                    }
                    //si existe la variable pero se pasa del tamaño permitido
                } else if ($nombre_img == !NULL && $tamano > 200000) {


                    $resultado = [

                        "codigo" => -5,
                        "msg" => "LA IMAGEN ES DEMASIADO GRANDE"

                    ];

                    echo json_encode($resultado);
                    //var_dump($resultado);
                }

                if (isset($rutaImagen)) {
                    require_once 'modelo/ProductoModelo.php';
                    $productos = new ProductoModelo();
                    $actualizaFoto = $productos->actualizarFotoProducto($rutaImagen, $idProducto);

                    if ($actualizaFoto) {

                        $resultado = [

                            "codigo" => 1,
                            "msg" => "FOTOGRAFÍA INSERTADA CORRECTAMENTE"

                        ];


                    } else {

                        $resultado = [

                            "codigo" => 0,
                            "msg" => "SE PRODUJO UN ERROR AL ACTUALIZAR LA FOTOGRAFÍA"

                        ];

                    }

                    echo json_encode($resultado);
                    //var_dump($resultado);
                }

            }else{

                $resultado = [

                    "codigo"    => -3,
                    "msg"       =>  "NO HA SELECCIONADO NINGUNA FOTOGRAFÍA. VUELVA A PULSAR EN LA TABLA SOBRE LA IMAGEN"

                ];

                echo json_encode($resultado);

            }
        }else{

            $resultado = [

                "codigo"    => -2,
                "msg"       =>  "DEBE INTRODUCIR UNA FOTOGRAFÍA CORRECTA PARA SU ACTUALIZACIÓN"

            ];

            echo json_encode($resultado);
            //var_dump($resultado);
        }

    }


