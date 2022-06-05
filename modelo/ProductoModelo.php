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

        function insertarProducto($descrip, $dcto, $categoria, $recipientes, $litros_recip, $imagen){

            $conexion = $this->conexion;
            $idProducto = $this->producto->getIdProducto();
            $fechaInsercion = $this->producto->getFechaInser();
            if (empty($dcto) || $dcto <=0){

                $descuento = $this->producto->getDcto();

            }else{

                $this->producto->setDcto($dcto);
                $descuento = $this->producto->getDcto();

            }

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO productos (id_producto, descripcion, fecha_inser, dcto, 
                       categoria, recipiente, litros_recipiente, imagen) VALUES (?,?,?,?,?,?,?,?)");
                $sql->bindParam(1, $idProducto);
                $sql->bindParam(2, $descrip);
                $sql->bindParam(3, $fechaInsercion);
                $sql->bindParam(4, $descuento);
                $sql->bindParam(5, $categoria);
                $sql->bindParam(6, $recipientes);
                $sql->bindParam(7, $litros_recip);
                $sql->bindParam(8, $imagen);
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

        function mostrarProductosPaginacion($pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $productos = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 3;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "SELECT p.id_producto, p.descripcion, p.fecha_inser, p.dcto, a.nombre, p.recipiente, 
                        p.litros_recipiente, p.imagen, a.cantidad_litros  
                        FROM productos p 
                        INNER JOIN aceite a ON a.id_cat_aceite = p.categoria
                        ORDER BY descripcion";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "SELECT p.id_producto, p.descripcion, p.fecha_inser, p.dcto, a.nombre, p.recipiente, 
                        p.litros_recipiente, p.imagen, a.cantidad_litros  
                        FROM productos p 
                        INNER JOIN aceite a ON a.id_cat_aceite = p.categoria
                        ORDER BY descripcion LIMIT $empezarDesde,$tamagnoPaginas";
                $resultado = $conexion->query($sql_limit);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $productos[] = $fila;

                    }

                    $datosFinales = [

                        "productos" => $productos,
                        "paginas" => $totalPaginas

                    ];

                }
            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $datosFinales = [

                    "codigo" => -2,
                    "errorConex" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $datosFinales;

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

        function modificarPrecioAceite($precioAove, $precioAov){

            $conexion = $this->conexion;

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("UPDATE aceite SET precio = CASE id_cat_aceite
                                                WHEN 1 THEN ?
                                                WHEN 2 THEN ?
                                                END 
                                                WHERE id_cat_aceite IN (1,2)");
                $sql->bindParam(1, $precioAove);
                $sql->bindParam(2, $precioAov);
                $resultado = $sql->execute();

                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $usuarios = [

                    "codigo" => -2,
                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];
                $correcto = false;

            }
            unset($conexion);
            return $correcto;

        }

        function mostrarLitrosAceite(){

            $conexion = $this->conexion;
            $litrosAceite = [];

            try{

                $sql = "SELECT id_cat_aceite, cantidad_litros FROM aceite";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $litrosAceite[] = $fila;

                    }

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $litrosAceite = [

                    "codigo" => -2,
                    "errorConex" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $litrosAceite;

        }

        function actualizarDatosProducto($descripcion, $dcto, $recipiente, $litros_recipiente, $idProducto){

            $conexion = $this->conexion;

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("UPDATE productos SET descripcion = ? , dcto = ? , 
                                                recipiente = ?, litros_recipiente = ?
                                                WHERE id_producto = ?");
                $sql->bindParam(1, $descripcion);
                $sql->bindParam(2, $dcto);
                $sql->bindParam(3, $recipiente);
                $sql->bindParam(4, $litros_recipiente);
                $sql->bindParam(5, $idProducto);
                $resultado = $sql->execute();

                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $usuarios = [

                    "codigo" => -2,
                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];
                $correcto = false;

            }
            unset($conexion);
            return $correcto;

        }

        function actualizarFotoProducto($imagen, $idProducto){

            $conexion = $this->conexion;

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("UPDATE productos SET imagen = ?
                                                WHERE id_producto = ?");
                $sql->bindParam(1, $imagen);
                $sql->bindParam(2, $idProducto);
                $resultado = $sql->execute();

                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName;

                $correcto = false;

            }
            unset($conexion);
            return $correcto;

        }

    }