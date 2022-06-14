<?php

    require_once 'modelo/DetallaCompraModelo.php';
    $detalles = new DetallaCompraModelo();

    require_once 'modelo/CompraModelo.php';
    $compras = new CompraModelo();

    require_once 'modelo/AceiteModelo.php';
    $aceites = new AceiteModelo();

    function insertarCompra(){

        if (isset($_POST['idCliente']) || isset($_POST['idAnonimo']) && (isset($_POST['total'],$_POST['productos'])) &&  !empty($_POST['total'])
            && !empty($_POST['productos'])){

            $totalCompra = $_POST['total'];
            $productos = json_decode($_POST['productos']);

            if (!empty($_POST['idCliente'])){

                $idCliente = $_POST['idCliente'];
                $idAnonimo = NULL;

            }else if (!empty($_POST['idAnonimo'])){

                $idCliente = NULL;
                $idAnonimo = $_POST['idAnonimo'];

            }

            global $aceites;
            $aceiteActualizado = true;
            for ($i = 0; $i < count($productos); $i++){

                    $idCatAceite = $productos[$i]->idCat;
                    $litrosXcompra = ($productos[$i]->ltrRecipi * $productos[$i]->recipiente) * $productos[$i]->cantidad;
                    $actualizaAceite = $aceites->actualizaLitrosDeCompra($litrosXcompra, $idCatAceite);
                    if (!$actualizaAceite) {

                        $aceiteActualizado = false;
                        break;

                    }

            }

            if ($aceiteActualizado){

                global $compras;
                $insertaCompra = $compras->insertarCompra($idCliente, $idAnonimo, $totalCompra);

                if ($insertaCompra['resultado'] === true){

                    global $detalles;
                    $detallesCompletados = true;
                    for ($i = 0; $i < count($productos); $i++){

                        $detalleInsertado = $detalles->insertarDetalleCompra($insertaCompra['idCompra'], $productos[$i]->idProducto,
                            $productos[$i]->cantidad, $productos[$i]->precioUni, $productos[$i]->dcto);
                        if (!$detalleInsertado){

                            $detallesCompletados = false;
                            break;

                        }

                    }

                    if(!$detallesCompletados){

                        $resultado = [

                            "codigo" => 0,
                            "msg" => 'HUBO UN ERROR AL INSERTAR LOS DETALLES DE LAS COMPRAS'

                        ];

                    }else{

                        $resultado = [

                            "codigo" => 1,
                            'idCompra' => $insertaCompra['idCompra'],
                            "msg" => 'COMPRA REALIZADA CORRECTAMENTE. PUEDE DESCARGAR EL ALBARÁN'

                        ];

                    }

                }else{

                    $resultado = [

                        "codigo" => -1,
                        "msg" => $insertaCompra['msg']

                    ];

                }
                echo json_encode($resultado);

            }else{

                $resultado = [

                    'codigo'  => -2,
                    'msg'     => 'HUBO UN ERROR AL ACTUALIZAR LOS LITROS DE ACEITE'

                ];

            }

        }else{

            $resultado = [

              'codigo'  => -3,
              'msg'     => 'EL CLIENTE NO EXISTE'

            ];

            echo json_encode($resultado);
        }

    }
