<?php

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
                require_once "vista/admin.php";

            }elseif ($admin['codigo'] === 1 && $admin['usuario']->tipo_socio === "comun"){

                session_start();

                $nombre = $admin['usuario']->nombre;
                $apellidos = $admin['usuario']->apellidos;
                $tipoUsuario = $admin['usuario']->tipo_socio;
                require_once "vista/socio.html";

            }elseif ($admin['codigo'] === 2 || $admin['codigo'] === 0 || $admin['codigo'] === -1 || $admin['codigo'] === -2){

                $error = $admin['error'];
                require_once "vista/accesoSocios.php";

            }

        }



    }
