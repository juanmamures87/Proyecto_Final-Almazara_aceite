<?php

    require_once "librerias/nusoap/lib/nusoap.php";
    require_once "modelo/LoginModelo.php";
    $logeos = new LoginModelo();

    function inicioSocios(){

        if (isset($_POST['dni'], $_POST['pass']) && !empty($_POST['dni']) && !empty($_POST['pass'])){

            $dni = $_POST['dni'];
            $pass = $_POST['pass'];

            global $logeos;

            $admin = $logeos->aceptarSocioLogin($dni,$pass);

            if ($admin['codigo'] === 1 && $admin['usuario']->tipo_socio === "admin"){

                session_start();

                $nombre = $admin['usuario']->nombre;
                $apellidos = $admin['usuario']->apellidos;
                $tipoUsuario = $admin['usuario']->tipo_socio;
                $dni = $admin['usuario']->dni;

                // Crear un cliente apuntando al script del servidor (Creado con WSDL)
                $cliente = new nusoap_client('https://ovc.catastro.meh.es/ovcservweb/ovcswlocalizacionrc/ovccallejero.asmx?wsdl', 'wsdl');
                //http://tempuri.org/OVCServWeb/OVCCallejero/ConsultaProvincia

                // Se comprueba si se puede conectar con el servicio
                $error = $cliente->getError();
                if ($error) {

                    echo '<pre style="color: red">' . $error . '</pre>';
                    echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
                    die();

                }
                // 2. Llamar a la función getCliente del servidor

                $resultado = $cliente->call('ObtenerProvincias');

                // Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
                if ($cliente->fault) {

                    echo '<b>Error: ';
                    print_r($resultado);
                    echo '</b>';

                }else{

                    $error = $cliente->getError();
                    if ($error) {

                        echo '<b style="color: red">Error: ' . $error . '</b>';

                    }
                }

                require_once "vista/admin.php";

            }elseif ($admin['codigo'] === 1 && $admin['usuario']->tipo_socio === "comun"){

                session_start();

                $nombre = $admin['usuario']->nombre;
                $apellidos = $admin['usuario']->apellidos;
                $tipoUsuario = $admin['usuario']->tipo_socio;
                $dni = $admin['usuario']->dni;
                require_once "vista/socio.html";

            }elseif ($admin['codigo'] === 2 || $admin['codigo'] === 0 || $admin['codigo'] === -1 || $admin['codigo'] === -2){

                $error = $admin['error'];
                require_once "vista/accesoSocios.php";

            }

        }



    }
