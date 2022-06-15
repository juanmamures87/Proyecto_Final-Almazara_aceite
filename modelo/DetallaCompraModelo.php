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

        function mostrarVentas($pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $usuarios = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 5;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "(SELECT u.nombre, u.apellidos, u.email, u.password, p.descripcion, de.dcto, de.unidades, de.pvp, co.total, co.fecha_compra
                        FROM usuarios u
                        INNER JOIN anonimos a ON a.id_usuario = u.id_usuario
                        INNER JOIN compras co ON co.id_anonimo = a.id_anonimo
                        INNER JOIN detalle_compra de on co.id_compra = de.id_compra
                        INNER JOIN productos p on de.id_producto = p.id_producto)
                        UNION
                        (SELECT u.nombre, u.apellidos, u.email, u.password, p.descripcion, de.dcto, de.unidades, de.pvp, co.total, co.fecha_compra
                        FROM usuarios u
                        INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario
                        INNER JOIN compras co ON co.id_anonimo = cli.id_cliente
                        INNER JOIN detalle_compra de on co.id_compra = de.id_compra
                        INNER JOIN productos p on de.id_producto = p.id_producto)
                        ORDER BY apellidos";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "(SELECT u.nombre, u.apellidos, u.email, u.password, p.descripcion, de.dcto, de.unidades, de.pvp, co.total, co.fecha_compra
                        FROM usuarios u
                        INNER JOIN anonimos a ON a.id_usuario = u.id_usuario
                        INNER JOIN compras co ON co.id_anonimo = a.id_anonimo
                        INNER JOIN detalle_compra de on co.id_compra = de.id_compra
                        INNER JOIN productos p on de.id_producto = p.id_producto)
                        UNION
                        (SELECT u.nombre, u.apellidos, u.email, u.password, p.descripcion, de.dcto, de.unidades, de.pvp, co.total, co.fecha_compra
                        FROM usuarios u
                        INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario
                        INNER JOIN compras co ON co.id_anonimo = cli.id_cliente
                        INNER JOIN detalle_compra de on co.id_compra = de.id_compra
                        INNER JOIN productos p on de.id_producto = p.id_producto)
                        ORDER BY apellidos
                        LIMIT $empezarDesde,$tamagnoPaginas";
                $resultado = $conexion->query($sql_limit);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $usuarios[] = $fila;

                    }

                    $datosFinales = [

                        "usuarios" => $usuarios,
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

    }