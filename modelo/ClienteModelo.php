<?php

    class ClienteModelo{

        private $conexion;
        private $usuario;
        private $cliente;
        private $anonimo;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Usuario.php";
            $this->usuario = new Usuario();
            require_once 'Cliente.php';
            $this->cliente = new Cliente();
            require_once 'Anonimo.php';
            $this->anonimo = new Anonimo();

        }

        function mostrarClientes($pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $usuarios = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 5;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "(SELECT u.id_usuario, u.nombre, u.apellidos, u.telefono, u.provincia, u.municipio, u.direccion, 
                u.cp, u.num_casa, u.piso, u.puerta, u.email, u.password FROM usuarios u INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario)
                UNION
                (SELECT u.id_usuario, u.nombre, u.apellidos, u.telefono, u.provincia, u.municipio, u.direccion, u.cp, 
                u.num_casa, u.piso, u.puerta, u.email, u.password FROM usuarios u INNER JOIN anonimos a ON a.id_usuario = u.id_usuario)
                ORDER BY apellidos";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "(SELECT u.id_usuario, u.nombre, u.apellidos, u.telefono, u.provincia, u.municipio, u.direccion, 
                u.cp, u.num_casa, u.piso, u.puerta, u.email, u.password FROM usuarios u INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario)
                UNION
                (SELECT u.id_usuario, u.nombre, u.apellidos, u.telefono, u.provincia, u.municipio, u.direccion, u.cp, 
                u.num_casa, u.piso, u.puerta, u.email, u.password FROM usuarios u INNER JOIN anonimos a ON a.id_usuario = u.id_usuario)
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