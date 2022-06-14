<?php

    class CompraModelo{

        private $conexion;
        private $cliente;
        private $compra;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once 'Cliente.php';
            $this->cliente = new Cliente();
            require_once 'Compra.php';
            $this->compra = new Compra();

        }

        function insertarCompra($idCliente, $idAnonimo, $total){

            $conexion = $this->conexion;
            $idCompra = $this->compra->getIdCompra();
            $fechaCompra = $this->compra->getFechaCompra();
            $compraInsertada = [];

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO compras (id_compra, id_cliente, id_anonimo, fecha_compra, total) 
                                                 VALUES (?,?,?,?,?)");
                $sql->bindParam(1, $idCompra);
                $sql->bindParam(2, $idCliente);
                $sql->bindParam(3, $idAnonimo);
                $sql->bindParam(4, $fechaCompra);
                $sql->bindParam(5, $total);
                $resultado = $sql->execute();

                if ($resultado) {

                    $lastId = $conexion->lastInsertId();
                    $conexion->commit();// Se confirma la transacción actual
                    $compraInsertada = [

                        "resultado" => $correcto,
                        "idCompra" => $lastId,
                        "msg"       => "COMPRA INSERTADA CORRECTAMENTE"

                    ];

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;
                    $compraInsertada = [

                        "resultado" => $correcto,
                        "idCompra" => null,
                        'msg'       => "ERROR EN LA INSERCIÓN DE LA COMPRA"

                    ];

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $lineaError = $e->getLine();

                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName . '. Línea' . $lineaError;

                $correcto = false;

            }
            unset($conexion);
            return $compraInsertada;

        }

    }