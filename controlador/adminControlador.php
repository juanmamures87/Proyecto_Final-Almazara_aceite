<?php

    require_once "modelo/SocioModelo.php";
    $socios = new SocioModelo();

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

    //No hay manera de que funcione, no recoge la RC de ninguna manera. Dejarla y probar si responde catastro
    function mostrarPoliParceSuperf(){

        require_once "librerias/nusoap/lib/nusoap.php";

        if (isset($_POST['provincia'], $_POST['municipio'], $_POST['refcat']) && !empty($_POST['provincia']) &&
            !empty($_POST['municipio']) && !empty($_POST['refcat'])) {

            $provincia = $_POST['provincia'];
            $municipio = $_POST['municipio'];
            $refcat = $_POST['refcat'];
            $datosParcela = [
                'Provincia' => $provincia,
                'Municipio' => $municipio,
                'RC'        => $refcat
            ];

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

            $resultado = $cliente->call('Consulta_DNPRC', $datosParcela);

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

                    //echo json_encode($resultado);
                    var_dump($resultado);
                    var_dump($refcat);
                    var_dump($provincia);
                    var_dump($municipio);

                }
            }

        }else{

            $respuesta = [

                "codigo"    => -2,
                "msg"       => "DEBE INTRODUCIR UNA PROVINCIA, MUNICIPIO Y REF. CATASTRAL PARA CONSULTAR LOS DATOS"

            ];

            echo json_encode($respuesta);
            //var_dump($respuesta);

        }

    }
