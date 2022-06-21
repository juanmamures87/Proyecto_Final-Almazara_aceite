<?php

    //Librería externa para crear un servicio soap y poder consultar el catastro
    require_once "librerias/nusoap/lib/nusoap.php";

    function muestraMunicipio(){

        if (isset($_POST['Provincia']) && !isset($_POST['Municipio']) && !isset($_POST['codPost'])){

            $provincia = utf8_decode($_POST['Provincia']);

            // Crear un cliente apuntando al script del servidor (Creado con WSDL)
            $cliente = new nusoap_client('https://ovc.catastro.meh.es/ovcservweb/ovcswlocalizacionrc/ovccallejero.asmx?wsdl', 'wsdl');

            // Se comprueba si se puede conectar con el servicio
            $error = $cliente->getError();
            if ($error) {

                echo '<pre style="color: red">' . $error . '</pre>';
                echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
                die();

            }
            // 2. Llamar a la función getCliente del servidor

            $resultado = $cliente->call(
                'ObtenerMunicipios',
                array("Provincia"=>$provincia)

            );

            // Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
            if ($cliente->fault) {

                echo '<b>Error: ';
                print_r($resultado);
                echo '</b>';

            }else{

                $error = $cliente->getError();
                if ($error) {

                    echo '<b style="color: red">Error: ' . $error . '</b>';

                }else{

                    $municipios = $resultado['consulta_municipiero']['municipiero']['muni'];
                    $devolverMuni = array();

                    if (count($municipios) > 3) {
                        foreach ($municipios as $muni) {

                            $devolverMuni[] = (utf8_encode($muni['nm']));

                        }

                        $devolverMuni = json_encode($devolverMuni);
                        echo $devolverMuni;

                    }else{

                        $unicoMunicipio = array(

                            utf8_encode($municipios['nm'])

                        );
                        echo json_encode($unicoMunicipio);

                    }
                }
            }

        }

    }

    function muestraDireccion(){

        if (isset($_POST['Provincia']) && isset($_POST['Municipio']) && !isset($_POST['codPost'])){

            $provincia = utf8_decode($_POST['Provincia']);
            $municipio = utf8_decode($_POST['Municipio']);

            // Crear un cliente apuntando al script del servidor (Creado con WSDL)
            $cliente = new nusoap_client('https://ovc.catastro.meh.es/ovcservweb/ovcswlocalizacionrc/ovccallejero.asmx?wsdl', 'wsdl');

            // Se comprueba si se puede conectar con el servicio
            $error = $cliente->getError();
            if ($error) {

                echo '<pre style="color: red">' . $error . '</pre>';
                echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
                die();

            }
            // 2. Llamar a la función getCliente del servidor

            $resultado = $cliente->call(
                'ObtenerCallejero',
                array("Provincia"=>$provincia,
                    "Municipio" => $municipio)

            );

            // Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
            if ($cliente->fault) {

                echo '<b>Error: ';
                print_r($resultado);
                echo '</b>';

            }else{

                $error = $cliente->getError();
                if ($error) {

                    echo '<b style="color: red">Error: ' . $error . '</b>';

                }else{

                    $direcciones = $resultado['consulta_callejero']['callejero']['calle'];
                    $devolverDir = array();

                    foreach ($direcciones as $dir){

                        $devolverDir[] = (utf8_encode($dir['dir']['nv']));

                    }

                    $devolverDir = json_encode($devolverDir);
                    echo $devolverDir;

                }
            }

        }

    }

    function muestraCp(){

        if (isset($_POST['codPost']) && isset($_POST['Municipio'])){

            $municipio = $_POST['Municipio'];

            require_once "modelo/RegistroModelo.php";

            $cp = new RegistroModelo();
            $codigos = $cp->getCodigoPostal($municipio);
            $arrayCP = json_encode($codigos);
            echo $arrayCP;

        }

    }

    function registroSocio(){

        $nombre     = $_POST['nombreSocio'];
        $apellidos  = $_POST['apeSocio'];
        $dni        = $_POST['dniSocio'];
        $tel        = $_POST['telSocio'];
        $prov       = $_POST['provSocio'];
        $provAlter  = $_POST['provSocioAlterna'];
        $mun        = $_POST['munSocio'];
        $munAlter   = $_POST['munSocioAlterna'];
        $dir        = $_POST['dirSocio'];
        $dirAlter   = $_POST['dirSocioAlterna'];
        $cp         = $_POST['cpSocio'];
        $cpAlter    = $_POST['cpSocioAlterna'];
        $num        = $_POST['numCasaSocio'];
        $piso       = $_POST['pisoSocio'];
        $puerta     = $_POST['puertaSocio'];
        $email      = $_POST['emailSocio'];
        $clave      = "molinoSur_" . rand(100,600) . "_" . rand(600,999);

        if (isset($_POST['activoSocio'])){

            $activado = 1;

        }else {

            $activado = 0;

        }


        if ($prov === "PROVINCIA"){

            $prov = $provAlter;

        }
        if ($mun === "MUNICIPIO"){

            $mun = $munAlter;

        }
        if ($dir === "DIRECCIÓN"){

            $dir = $dirAlter;

        }
        if ($cp === "CÓDIGO POSTAL"){

            $cp = $cpAlter;

        }
        if ($piso === ""){

            $piso = "-";

        }
        if ($puerta === ""){


            $puerta = "-";
        }


        require_once "modelo/RegistroModelo.php";
        $usuarios = new RegistroModelo();
        $usuario = $usuarios->insertarUsuario($nombre, $apellidos, $dni, $tel, $prov, $mun, $dir, $cp, $num, $piso, $puerta, $email, $clave, $activado);

        if ($usuario['resultado'] === true){

            $registroSocio = $usuarios->insertarSocio($usuario['idUsuario']);

            if ($registroSocio){

                require_once "modelo/RegistroModelo.php";
                $registro = new RegistroModelo();
                $nombreCompleto = $nombre . " " . $apellidos;
                $mailConfirm = $registro->correoConfirmacionSocios($nombreCompleto, $dni, $clave, $email);

                $mailConfirm ? $envio = "Correo de verificación enviado correctamente" : $envio = "El correo de verificación no pudo ser enviado";
                require_once "modelo/SocioModelo.php";
                $nuevos = new SocioModelo();
                $nuevoUsuario = $nuevos->mostrarSocioXid($usuario['idUsuario']);

                $resultado = [

                    "codigo"    => 1,
                    "usuario"   => $nuevoUsuario,
                    "msgCorreo" => $envio,
                    "msg"       =>  "USUARIO REGISTRADO CORRECTAMENTE"

                ];

                //var_dump($resultado);

            }else{

                $resultado = [

                    "codigo"    => 0,
                    "msg"       =>  "ERROR AL REGISTRAR AL USUARIO ALGUNO DE LOS DATOS YA SE ENCUENTRA EN EL REGISTRO"

                ];

            }

        }else{

            $resultado = [

                "codigo"    => -1,
                "msg"       =>  $usuario['msg']

            ];

        }

        echo json_encode($resultado);
        //var_dump($resultado);
    }

    function insertarParcela(){

        if (isset($_POST['selSocioParcela']) && !empty($_POST['selSocioParcela'])){

            $idSocio    = $_POST['selSocioParcela'];
            $provincia  = $_POST['selProvParcela'];
            $municipio  = $_POST['selMunParcela'];
            $refCat     = $_POST['refCatParcela'];
            $poligono   = $_POST['polParcela'];
            $parcela    = $_POST['parParcela'];
            $superficie = $_POST['superParcela'];
            $sistema    = $_POST['selSisParcela'];
            $variedad   = $_POST['selVarParcela'];
            $plantas    = $_POST['plantasParcela'];

            require_once "modelo/ParcelaModelo.php";
            $parcelas = new ParcelaModelo();
            $nuevaParcela = $parcelas->insertarParcela($idSocio, $provincia, $municipio, $refCat, $poligono, $parcela,
                $superficie, $sistema, $variedad, $plantas);

            if ($nuevaParcela){

                $resultado = [

                    "codigo"    => 1,
                    "msg"       =>  "PARCELA REGISTRADA CORRECTAMENTE"

                ];

            }else{

                $resultado = [

                    "codigo"    => 0,
                    "msg"       =>  'SE PRODUJO UN ERROR. NO SE PUDO REGISTRAR LA PARCELA O YA ESTÁ REGISTRADA'

                ];

            }

            //var_dump($resultado);
            echo json_encode($resultado);

        }else{

            $resultado = [

                "codigo"    => -2,
                "msg"       =>  "DEBE SELECCIONAR UN USUARIO CORRECTO PARA INSERTAR LA PARCELA"

            ];

            //var_dump($resultado);
            echo json_encode($resultado);

        }


    }

    function insertarProduccion(){

        if (isset($_POST['selSocioProd'],$_POST['selParcelaProd']) && !empty($_POST['selSocioProd']) &&
            !empty($_POST['selParcelaProd'])){

            $idSocio = $_POST['selSocioProd'];
            $idParcela = $_POST['selParcelaProd'];
            $tipo = $_POST['selTipoProd'];
            $kg = $_POST['kgProd'];
            $rendimiento = $_POST['renProd'];
            $acidez = $_POST['acidezProd'];

            $litros = ($kg * $rendimiento)/100;

            require_once "modelo/ProduccionModelo.php";
            $producciones = new ProduccionModelo();

            $insertaProd = $producciones->insertarProduccion($idSocio,$idParcela,$tipo,$kg,$rendimiento,$litros,$acidez);

            if ($insertaProd['resultado'] === true) {

                $remesa = $producciones->mostrarProduccionXidTicket($insertaProd['idParcela']);

                require_once "modelo/AceiteModelo.php";
                $aceites = new AceiteModelo();

                if ($acidez <= 0.8) {

                    $actualizaLitros = $aceites->actualizaAove($litros);

                } else {

                    $actualizaLitros = $aceites->actualizaVirgen($litros);

                }

                if ($actualizaLitros){

                    $resultado = [

                        "codigo"    =>  1,
                        'remesa'    =>  $remesa,
                        "msg"       =>  "REMESA DE PRODUCCIÓN INSERTADA CORRECTAMENTE",
                        'msgAceite' =>  "LA CANTIDAD DE LITROS FUE ACTUALIZADA"

                    ];

                }else{

                    $resultado = [

                        "codigo"    =>  0,
                        'remesa'    =>  $remesa,
                        "msg"       =>  "REMESA DE PRODUCCIÓN INSERTADA CORRECTAMENTE",
                        'msgAceite' =>  "SE PRODUJO UN ERROR AL ACTUALIZAR LOS LITROS DE LA BODEGA"

                    ];

                }

            }else{

                $resultado = [

                    "codigo"    => -1,
                    "msg"       =>  "LA REMESA DE PRODUCCIÓN NO PUDO INSERTARSE"

                ];

            }

        }else{

            $resultado = [

                "codigo"    => -2,
                "msg"       =>  "DEBE SELECCIONAR UN USUARIO Y UNA PARCELA CORRECTA"

            ];

        }

        echo json_encode($resultado);

    }

    function insertaProducto(){

        if (isset($_POST['nomProducto'],$_POST['selCatProducto'])){

            $nombreProducto = $_POST['nomProducto'];
            $cat = $_POST['selCatProducto'];
            $dcto = $_POST['descProducto'];
            $recipiente = $_POST['recipienteProducto'];
            $litrosRecip = $_POST['l/recipiente'];

            // Recibo los datos de la imagen
            $nombre_img = $_FILES['imgProducto']['name'];
            $tipo = $_FILES['imgProducto']['type'];
            $tamano = $_FILES['imgProducto']['size'];

            //Si existe imagen y tiene un tamaño correcto
            if (($nombre_img == !NULL) && ($tamano <= 200000)){
                //indicamos los formatos que permitimos subir a nuestro servidor
                if (($tipo == "image/gif") || ($tipo == "image/jpeg") || ($tipo == "image/jpg") || ($tipo == "image/png")
                    || ($tipo == "image/jfif")){

                    // Ruta donde se guardarán las imágenes que subamos
                    $directorio = "images/productos/";
                    // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                    move_uploaded_file($_FILES['imgProducto']['tmp_name'],$directorio . $nombre_img);
                    $rutaImagen = $directorio . $nombre_img;
                }else{

                    //si no cumple con el formato
                    $resultado = [

                        "codigo"    => -4,
                        "msg"       =>  "ESE FORMATO DE IMAGEN NO ES COMPATIBLE"

                    ];

                    echo json_encode($resultado);
                    //var_dump($resultado);

                }
                //si existe la variable pero se pasa del tamaño permitido
            }else if ($nombre_img == !NULL && $tamano > 200000){


                $resultado = [

                    "codigo"    => -5,
                    "msg"       =>  "LA IMAGEN ES DEMASIADO GRANDE"

                ];

                echo json_encode($resultado);
                //var_dump($resultado);
            }

            if (isset($rutaImagen)) {
                require_once 'modelo/ProductoModelo.php';
                $productos = new ProductoModelo();
                $productoInsertado = $productos->insertarProducto($nombreProducto, $dcto, $cat, $recipiente, $litrosRecip, $rutaImagen);

                if ($productoInsertado) {

                    $resultado = [

                        "codigo" => 1,
                        "msg" => "PRODUCTO INSERTADO CORRECTAMENTE"

                    ];


                } else {

                    $resultado = [

                        "codigo" => 0,
                        "msg" => "SE PRODUJO UN ERROR AL INSERTAR EL PRODUCTO"

                    ];

                }

                echo json_encode($resultado);
                //var_dump($resultado);
            }
        }else{

            $resultado = [

                "codigo"    => -2,
                "msg"       =>  "DEBE INTRODUCIR UN NOMBRE Y UNA CATEGORÍA CORRECTA"

            ];

            echo json_encode($resultado);
            //var_dump($resultado);
        }

    }

    function registroUsuarios(){

        if (!empty($_POST['passReg']) && !empty($_POST['emailReg'])) {

            $nombre = $_POST['nombreReg'];
            $apellidos = $_POST['apeReg'];
            $dni = $_POST['dniReg'];
            $tel = $_POST['telReg'];
            $prov = $_POST['provReg'];
            $mun = $_POST['munReg'];
            $dir = $_POST['dirReg'];
            $cp = $_POST['cpReg'];
            $num = $_POST['numCasaReg'];
            $piso = $_POST['pisoReg'];
            $puerta = $_POST['puertaReg'];
            $email = $_POST['emailReg'];
            $clave = $_POST['passReg'];
            $empresa = $_POST['emReg'];
            $activado = 0;

            if ($dni === ''){

                $dni = '-';

            }
            if ($piso === "") {

                $piso = "-";

            }
            if ($puerta === "") {

                $puerta = "-";

            }
            if ($empresa === ''){

                $empresa = '-';

            }


            require_once "modelo/RegistroModelo.php";
            $usuarios = new RegistroModelo();

            $compruebaUsuarios = $usuarios->compruebaUsuarios($nombre, $apellidos, $dni, $tel, $email);
            if ($compruebaUsuarios > 0){

                $resultado = [

                    "codigo" => -2,
                    "msg" => 'ESTE USUARIO YA SE ENCUENTRA REGISTRADO. INICIE SESIÓN'

                ];

            }else {

                $cliente = $usuarios->insertarUsuario($nombre, $apellidos, $dni, $tel, $prov, $mun, $dir, $cp, $num, $piso, $puerta, $email, $clave, $activado);

                if ($cliente['resultado'] === true) {

                    $registroCliente = $usuarios->insertarCliente($cliente['idUsuario'], $empresa);

                    if ($registroCliente) {

                        $token = $usuarios->tokenClientes($email, $clave);

                        $nombreCompleto = $nombre . " " . $apellidos;
                        $mailConfirm = $usuarios->correoConfirmacionClientes($nombreCompleto, $clave, $email, $token);

                        $mailConfirm ? $envio = "Consulte su correo para verificar la cuenta" : $envio = "El correo de verificación no pudo ser enviado";

                        $resultado = [

                            "codigo" => 1,
                            "msgCorreo" => $envio,
                            "msg" => "CLIENTE REGISTRADO CORRECTAMENTE"

                        ];

                    } else {

                        $resultado = [

                            "codigo" => 0,
                            "msg" => "DATOS INVÁLIDOS. NO PUDO REGISTRARSE EL USUARIO"

                        ];

                    }

                } else {

                    $resultado = [

                        "codigo" => -1,
                        "msg" => $cliente['msg']

                    ];

                }
            }

            echo json_encode($resultado);

        }elseif(empty($_POST['passReg'])) {

            $nombre = $_POST['nombreReg'];
            $apellidos = $_POST['apeReg'];
            $dni = $_POST['dniReg'];
            $tel = $_POST['telReg'];
            $prov = $_POST['provReg'];
            $mun = $_POST['munReg'];
            $dir = $_POST['dirReg'];
            $cp = $_POST['cpReg'];
            $num = $_POST['numCasaReg'];
            $piso = $_POST['pisoReg'];
            $puerta = $_POST['puertaReg'];
            $email = $_POST['emailReg'];
            $clave = '-';
            $empresa = '-';
            $activado = 0;

            if ($dni === '') {

                $dni = '-';

            }
            if ($piso === "") {

                $piso = "-";

            }
            if ($puerta === "") {

                $puerta = "-";

            }

            require_once "modelo/RegistroModelo.php";
            $usuarios = new RegistroModelo();

            require_once 'modelo/LoginModelo.php';
            $logeos = new LoginModelo();

            $compruebaUsuarios = $usuarios->compruebaUsuarios($nombre, $apellidos, $dni, $tel, $email);
            if ($compruebaUsuarios > 0) {

                $anonimoActio = $logeos->aceptarAnonimos($compruebaUsuarios);

                $resultado = [

                    'codigo' => 10,
                    'usuario' => $anonimoActio['anonimo'],
                    'msg' => 'ESTE USUARIO YA SE ENCUENTRA REGISTRADO. DATOS RECUPERADOS'

                ];

            } else {

                $anonimo = $usuarios->insertarUsuario($nombre, $apellidos, $dni, $tel, $prov, $mun, $dir, $cp, $num, $piso, $puerta, $email, $clave, $activado);

                if ($anonimo['resultado'] === true) {

                    $registroAnonimo = $usuarios->insertarAnonimo($anonimo['idUsuario']);

                    if ($registroAnonimo) {

                        $anonimoActio = $logeos->aceptarAnonimos($anonimo['idUsuario']);

                        $resultado = [

                            'codigo' => 10,
                            'usuario' => $anonimoActio['anonimo'],
                            'msg' => 'DATOS DE ENVÍO CORRECTOS'

                        ];

                    } else {

                        $resultado = [

                            'codigo' => 20,
                            'msg' => 'ERROR AL INTRODUCIR EL USUARIO INVITADO'

                        ];

                    }

                } else {

                    $resultado = [

                        'codigo' => 30,
                        'msg' => 'NO SE HA PODIDO REGISTRAR AL USUARIO'

                    ];

                }

            }
            echo json_encode($resultado);
        }

    }
