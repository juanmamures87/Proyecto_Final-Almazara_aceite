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

                    foreach ($municipios as $muni){

                        $devolverMuni[] = (utf8_encode($muni['nm']));

                    }

                    $devolverMuni = json_encode($devolverMuni);
                    echo $devolverMuni;;
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
