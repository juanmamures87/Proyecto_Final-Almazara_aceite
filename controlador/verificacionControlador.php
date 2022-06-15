<?php

    //Controlador que verificará el correo de un usuario registrado como cliente y al que se le requiere confirmación
    function activar(){

        if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['token']) && !empty($_GET['token'])) {

            $email = $_GET['email'];
            $token = $_GET['token'];

            require_once "modelo/RegistroModelo.php";
            $usuarios = new RegistroModelo();

            $comprobado = $usuarios->comprobarURL($email, $token);

            if ($comprobado === 1) {

                $actualizado = $usuarios->actualizarActivado($email, $token);
                if ($actualizado === 1) {

                    //header('Refresh: 10; URL=controlador.php'); Otra manera de mandar un alert con location

                    echo "<script>alert('TU CUENTA FUE ACTIVADA, PUEDES INICIAR SESIÓN');window.location = 'http://molinodelsur.edu/tienda'</script>";

                } else {

                    echo "<script>alert('NO SE HA PODIDO ACTIVAR LA CUENTA');window.location = 'http://molinodelsur.edu/tienda'</script>";

                }

            } else {

                echo "<script>alert('URL INVÁLIDA O LA CUENTA YA FUE ACTIVADA');window.location = 'http://molinodelsur.edu/tienda'</script>";

            }

        } else {

            echo "<script>alert('ACCESO DENEGADO. UTILICE EL ENLACE QUE SE HA ENVIADO A SU CORREO ELECTRÓNICO');window.location = 'http://molinodelsur.edu/tienda'</script>";

        }

        require_once 'index.php';

    }
