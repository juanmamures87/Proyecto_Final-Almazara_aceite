<?php

    class ProductoModelo{

        private $conexion;
        private $producto;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Producto.php";
            $this->producto = new Producto();

        }

        function mostrarCategoriaAceite(){

            $conexion = $this->conexion;
            $categoriaAceite = [];

            try{

                $sql = "SELECT * FROM aceite";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $categoriaAceite[] = $fila;

                    }

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $categoriaAceite = [

                    "codigo" => -2,
                    "errorConex" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $categoriaAceite;

        }

        function insertarProducto($nombre, $categoria, $imagen){

            $conexion = $this->conexion;
            $idProducto = $this->producto->getIdProducto();
            $fechaInsercion = $this->producto->getFechaInser();
            $dcto = $this->producto->getDcto();
            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO productos (id_producto, nombre, fecha_inser, dcto, 
                       categoria, imagen) VALUES (?,?,?,?,?,?)");
                $sql->bindParam(1, $idProducto);
                $sql->bindParam(2, $nombre);
                $sql->bindParam(3, $fechaInsercion);
                $sql->bindParam(4, $dcto);
                $sql->bindParam(5, $categoria);
                $sql->bindParam(6, $imagen);
                $resultado = $sql->execute();

                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $codPost = [

                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];
                $correcto = false;

            }
            unset($conexion);
            return $correcto;

        }

        function mostrarProductos(){

            $conexion = $this->conexion;
            $productos = [];

            try{

                $sql = "SELECT * FROM productos";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $productos[] = $fila;

                    }

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $productos = [

                    "codigo" => -2,
                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $productos;

        }

        function eliminarProducto($idProducto){

            $correcto = true;
            $conexion = $this->conexion;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
                $sql->bindParam(1, $idProducto);
                $resultado = $sql->execute();
                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }
            }catch (PDOException $e){

                $errorLine = $e->getLine();
                echo "<script>alert('¡¡ERROR DE CONEXIÓN CON LA BASE DE DATOS!!\\n Error en la línea: " . $errorLine . "')</script>";
                $correcto = false;
            }

            unset($conexion);
            return $correcto;

        }

    }