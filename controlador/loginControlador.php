<?php

    require_once "librerias/nusoap/lib/nusoap.php";
    require_once "modelo/LoginModelo.php";
    $logeos = new LoginModelo();

    require_once "modelo/ParcelaModelo.php";
    $parcelas = new ParcelaModelo();

    require_once "modelo/SocioModelo.php";
    $socios = new SocioModelo();

    require_once "modelo/ProductoModelo.php";
    $productos = new ProductoModelo();

    function inicioSocios(){

        //Si el dni y la contraseña que se le proporciona al socio concuerdan, puede acceder.
        if (isset($_POST['dni'], $_POST['pass']) && !empty($_POST['dni']) && !empty($_POST['pass'])){

            $dni = $_POST['dni'];
            $pass = $_POST['pass'];

            global $logeos;

            $admin = $logeos->aceptarSocioLogin($dni,$pass);

            //Si puede acceder y es tipo admin, accede a la página del administrador
            if ($admin['codigo'] === 1 && $admin['usuario']->tipo_socio === "admin"){

                session_start();

                $nombre = $admin['usuario']->nombre;
                $apellidos = $admin['usuario']->apellidos;
                $tipoUsuario = $admin['usuario']->tipo_socio;
                $dni = $admin['usuario']->dni;

                /*Llamamos a las funciones correspondientes que nos mostrarán en la vista del admin la variedad
                de aceituna y el sistema de cultivo para registrar las parcelas*/
                global $parcelas;
                $variedad = $parcelas->mostrarVariedadAceituna();
                $sistema = $parcelas->mostrarSistemaCultivo();

                //Llamamos a la función para mostrar todos los socios en la página del administrador
                global $socios;
                $pagina = 1;
                $mostrarSocios = $socios->mostrarSocios($pagina);

                //Llamamos a la función que mostrará las categorías de aceite registradas, para poder insertar un producto
                global $productos;
                $mostrarCategorias = $productos->mostrarCategoriaAceite();

                //Llamamos a la función que mostrará todos los productos registrados en la base de datos
                $mostrarProductos = $productos->mostrarProductosPaginacion($pagina);

                //Llamamos a la función que mostrará las cantidades de litros de aceite de cada variedad para mostrarlo
                $mostrarLitros = $productos->mostrarLitrosAceite();

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

                require_once "vista/admin.php";

            }elseif ($admin['codigo'] === 1 && $admin['usuario']->tipo_socio === "común"){

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

    function inicioUsuarios(){

        //Si el dni y la contraseña que se le proporciona al socio concuerdan, puede acceder.
        if (isset($_POST['emailInicioSesion'], $_POST['psswInicioSesion']) && !empty($_POST['emailInicioSesion']) &&
            !empty($_POST['psswInicioSesion'])){

            $email = $_POST['emailInicioSesion'];
            $clave = $_POST['psswInicioSesion'];

            global $logeos;
            $inicioCliente = $logeos->aceptarClienteLogin($email,$clave);

            if ($inicioCliente['codigo'] === 1){

                $resultado = [

                    'codigo' => 1,
                    'usuario' => $inicioCliente['usuario'],
                    'msg' => 'USUARIO VERIFICADO'

                ];

                echo json_encode($resultado);

            }elseif ($inicioCliente['codigo'] === 2){

                $resultado = [

                    'codigo' => 2,
                    'msg' => "SOCIO SIN PERMISO PARA ACCEDER. PÓNGASE EN CONTACTO CON EL ADMINISTRADOR"

                ];

                echo json_encode($resultado);

            }elseif ($inicioCliente['codigo'] === 0){

                $resultado = [

                    'codigo' => 0,
                    'msg' => "CONTRASEÑA INCORRECTA VUELVA A INTRODUCIRLA"

                ];

                echo json_encode($resultado);

            }elseif ($inicioCliente['codigo'] === -1){

                $resultado = [

                    'codigo' => -1,
                    'msg' => "LOS DATOS INTRODUCIDOS NO CORRESPONDEN A NINGÚN SOCIO"

                ];

                echo json_encode($resultado);

            }

        }else{

            $resultado = [

                'codigo' => -2,
                'msg' => "ERROR EN LOS DATOS INTRODUCIDOS"

            ];

            echo json_encode($resultado);

        }

    }
