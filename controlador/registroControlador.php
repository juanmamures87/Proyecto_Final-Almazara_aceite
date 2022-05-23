<?php

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

            if ($insertaProd) {

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
                        "msg"       =>  "REMESA DE PRODUCCIÓN INSERTADA CORRECTAMENTE",
                        'msgAceite' =>  "LA CANTIDAD DE LITROS FUE ACTUALIZADA"

                    ];

                }else{

                    $resultado = [

                        "codigo"    =>  0,
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
