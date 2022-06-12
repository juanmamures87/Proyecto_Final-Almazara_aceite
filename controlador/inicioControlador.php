<?php

    function portada(){

        require_once "vista/index.html";

    }

    function quienesSomos(){

        require_once "vista/quienesSomos.html";

    }

    function actualidad(){

        require_once "vista/actualidad.html";

    }

    function contacto(){

        require_once "vista/contacto.html";

    }

    function tienda(){

        require_once "librerias/nusoap/lib/nusoap.php";

        require_once 'modelo/ProductoModelo.php';
        $productos = new ProductoModelo();
        $muestraTienda = $productos->mostrarProductosTienda();

        //A continuación obtenemos el servicio web del catastro que nos proporciona las provincias de España.
        //Obtenemos una variable que almacena todos los datos y la pasamos a la vista.
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

        require_once "vista/tienda.php";

    }

    function accesoSocios(){

        require_once "vista/accesoSocios.php";

    }

    function carrito(){

        require_once 'vista/carritoCompra.php';

    }


