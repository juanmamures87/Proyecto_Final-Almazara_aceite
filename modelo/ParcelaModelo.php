<?php

    class ParcelaModelo{

        private $conexion;
        private $parcela;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Parcela.php";
            $this->parcela = new Parcela();

        }

        function mostrarVariedadAceituna(){

            $conexion = $this->conexion;
            $variedad = [];

            try{

                $sql = "SELECT * FROM variedad_aceituna ORDER BY nombre ASC";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $variedad[] = $fila;

                    }

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $variedad = [

                    "codigo" => -2,
                    "errorConex" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $variedad;

        }

        function mostrarSistemaCultivo(){

            $conexion = $this->conexion;
            $sistema = [];

            try{

                $sql = "SELECT * FROM sistema_cultivo ORDER BY nombre ASC";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $sistema[] = $fila;

                    }

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $sistema = [

                    "codigo" => -2,
                    "errorConex" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $sistema;

        }

        function insertarParcela($idSocio, $prov, $mun, $refCat, $pol, $par, $super, $sis, $variedad, $plantas){

            $conexion = $this->conexion;
            $idParcela = $this->parcela->getIdParcela();
            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO parcela (id_parcela, id_socio, provincia, municipio, 
                     ref_catastral, poligono, parcela, superficie, sistema_cultivo, variedad_aceituna, num_plantas) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                $sql->bindParam(1, $idParcela);
                $sql->bindParam(2, $idSocio);
                $sql->bindParam(3, $prov);
                $sql->bindParam(4, $mun);
                $sql->bindParam(5, $refCat);
                $sql->bindParam(6, $pol);
                $sql->bindParam(7, $par);
                $sql->bindParam(8, $super);
                $sql->bindParam(9, $sis);
                $sql->bindParam(10, $variedad);
                $sql->bindParam(11, $plantas);
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

        function busquedas($busqueda, $pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $parcelas = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 5;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "SELECT p.id_parcela, p.id_socio, u.apellidos, u.nombre AS 'nombre_socio', p.provincia, p.municipio, 
                        p.ref_catastral, p.poligono, p.parcela, p.superficie, v.nombre AS 'nombre_variedad', 
                        sis.nombre AS 'nombre_sistema' FROM parcela p 
                        INNER JOIN socios s ON p.id_socio = s.id_socio 
                        INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
                        INNER JOIN variedad_aceituna v ON v.id_aceituna = p.variedad_aceituna
                        INNER JOIN sistema_cultivo sis ON sis.id_sistema = p.sistema_cultivo                                                        
                        WHERE $busqueda";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "SELECT p.id_parcela, p.id_socio, u.apellidos, u.nombre AS 'nombre_socio', p.provincia, p.municipio, 
                        p.ref_catastral, p.poligono, p.parcela, p.superficie, p.num_plantas, v.nombre AS 'nombre_variedad', 
                        sis.nombre AS 'nombre_sistema' FROM parcela p 
                        INNER JOIN socios s ON p.id_socio = s.id_socio 
                        INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
                        INNER JOIN variedad_aceituna v ON v.id_aceituna = p.variedad_aceituna
                        INNER JOIN sistema_cultivo sis ON sis.id_sistema = p.sistema_cultivo                                                        
                        WHERE $busqueda LIMIT $empezarDesde,$tamagnoPaginas";
                $resultado = $conexion->query($sql_limit);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $parcelas[] = $fila;

                    }

                    $datosFinales = [

                        "usuarios" => $parcelas,
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

        function busquedaParcelaXprov($provincia, $pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $parcelas = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 5;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "SELECT p.id_parcela, p.id_socio, u.apellidos, u.nombre AS 'nombre_socio', p.provincia, p.municipio, 
                        p.ref_catastral, p.poligono, p.parcela, p.superficie, v.nombre AS 'nombre_variedad', 
                        sis.nombre AS 'nombre_sistema' FROM parcela p 
                        INNER JOIN socios s ON p.id_socio = s.id_socio 
                        INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
                        INNER JOIN variedad_aceituna v ON v.id_aceituna = p.variedad_aceituna
                        INNER JOIN sistema_cultivo sis ON sis.id_sistema = p.sistema_cultivo                                                        
                        WHERE p.provincia = '$provincia'";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "SELECT p.id_parcela, p.id_socio, u.apellidos, u.nombre AS 'nombre_socio', p.provincia, p.municipio, 
                        p.ref_catastral, p.poligono, p.parcela, p.superficie, p.num_plantas, v.nombre AS 'nombre_variedad', 
                        sis.nombre AS 'nombre_sistema' FROM parcela p 
                        INNER JOIN socios s ON p.id_socio = s.id_socio 
                        INNER JOIN usuarios u ON s.id_usuario = u.id_usuario
                        INNER JOIN variedad_aceituna v ON v.id_aceituna = p.variedad_aceituna
                        INNER JOIN sistema_cultivo sis ON sis.id_sistema = p.sistema_cultivo                                                        
                        WHERE p.provincia = '$provincia' LIMIT $empezarDesde,$tamagnoPaginas";
                $resultado = $conexion->query($sql_limit);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $parcelas[] = $fila;

                    }

                    $datosFinales = [

                        "usuarios" => $parcelas,
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

        function eliminarParcela($idParcela){

            $correcto = true;
            $conexion = $this->conexion;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("DELETE FROM parcela WHERE id_parcela = ?");
                $sql->bindParam(1, $idParcela);
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

        function actualizarParcela($sistema, $variedad, $plantas, $idParcela){

            $conexion = $this->conexion;

            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("UPDATE parcela p 
                        INNER JOIN sistema_cultivo sis ON sis.nombre = ? 
                        INNER JOIN variedad_aceituna v ON v.nombre = ?
                        SET p.sistema_cultivo = sis.id_sistema , p.variedad_aceituna = v.id_aceituna , p.num_plantas = ?
                        WHERE id_parcela = ?");
                $sql->bindParam(1, $sistema);
                $sql->bindParam(2, $variedad);
                $sql->bindParam(3, $plantas);
                $sql->bindParam(4, $idParcela);
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