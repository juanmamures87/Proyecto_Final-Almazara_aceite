<?php

    class SocioModelo{

        private $conexion;
        private $usuario;
        private $socio;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Usuario.php";
            $this->usuario = new Usuario();
            require_once "Socio.php";
            $this->socio = new Socio();

        }

        function mostrarSocios($pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $usuarios = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 5;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "SELECT * FROM usuarios u INNER JOIN socios s ON u.id_usuario = s.id_usuario ORDER BY apellidos ASC";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "SELECT * FROM usuarios u INNER JOIN socios s ON u.id_usuario = s.id_usuario ORDER BY apellidos ASC LIMIT $empezarDesde,$tamagnoPaginas";
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

        function mostrarSocioDeterminado($idUsuario){

            $conexion = $this->conexion;
            $usuarios = [];

            try{

                $sql = "SELECT * FROM usuarios u INNER JOIN socios s ON u.id_usuario = s.id_usuario WHERE u.id_usuario = $idUsuario";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    $fila = $resultado->fetch(PDO::FETCH_OBJ);

                        $usuarios[] = $fila;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $usuarios = [

                    "codigo" => -2,
                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $usuarios;

        }

        function eliminarSocio($idSocio){

            $correcto = true;
            $conexion = $this->conexion;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("DELETE usuarios, socios FROM usuarios 
                                    JOIN socios ON usuarios.id_usuario = socios.id_usuario WHERE socios.id_socio = ?");
                $sql->bindParam(1, $idSocio);
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

        function actualizarSocio($id, $tel, $prov, $mun, $dir, $cp, $num_casa, $piso, $puerta, $email, $acceso, $tipo, $fechaBaja){

            $conexion = $this->conexion;

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("UPDATE usuarios u INNER JOIN socios s ON u.id_usuario = s.id_usuario SET u.telefono = ?, 
                                                 u.provincia = ?, u.municipio = ?, u.direccion = ?, u.cp = ?, u.num_casa = ?, 
                                                 u.piso = ?, u.puerta = ?, u.email = ?, u.activo = ?, s.tipo_socio = ?, 
                                                 s.fecha_baja = ? WHERE s.id_socio = ?");
                $sql->bindParam(1, $tel);
                $sql->bindParam(2, $prov);
                $sql->bindParam(3, $mun);
                $sql->bindParam(4, $dir);
                $sql->bindParam(5, $cp);
                $sql->bindParam(6, $num_casa);
                $sql->bindParam(7, $piso);
                $sql->bindParam(8, $puerta);
                $sql->bindParam(9, $email);
                $sql->bindParam(10, $acceso);
                $sql->bindParam(11, $tipo);
                $sql->bindParam(12, $fechaBaja);
                $sql->bindParam(13, $id);
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

    }