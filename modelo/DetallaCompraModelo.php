<?php

    class DetallaCompraModelo{

        private $conexion;
        private $detalle;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once 'DetalleCompra.php';
            $this->detalle = new DetalleCompra();

        }

        function insertarDetalleCompra($idCompra, $idProducto, $unidades, $pvp, $dcto){

            $conexion = $this->conexion;
            $idDetalle = $this->detalle->getIdDetalle();

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO detalle_compra (id_detalle, id_compra, id_producto, unidades, 
                       pvp, dcto) VALUES (?,?,?,?,?,?)");
                $sql->bindParam(1, $idDetalle);
                $sql->bindParam(2, $idCompra);
                $sql->bindParam(3, $idProducto);
                $sql->bindParam(4, $unidades);
                $sql->bindParam(5, $pvp);
                $sql->bindParam(6, $dcto);
                $resultado = $sql->execute();

                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();

                //echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                $correcto = false;

            }
            unset($conexion);
            return $correcto;


        }

    }