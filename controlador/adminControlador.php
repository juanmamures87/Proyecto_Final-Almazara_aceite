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
