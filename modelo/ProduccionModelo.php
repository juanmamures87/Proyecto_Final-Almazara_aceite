<?php

    class ProduccionModelo{

        private $conexion;
        private $produccion;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Produccion.php";
            $this->produccion = new Produccion();

        }

        function insertarProduccion($idSocio, $idParcela, $tipo, $kg, $rendimiento, $litros, $acidez){

            $conexion = $this->conexion;
            $idAlbaran = $this->produccion->getIdAlbaran();
            $fechaEntrada = $this->produccion->fecha_aleatoria();//Utilizo una fecha aleatoria para que sea más certera la temporada de aceituna
            //Esta es la fecha actual recogida de la clase$this->produccion->getFechaEntrada();
            $horaEntrada = $this->produccion->getHoraEntrada();

            $parcelaInsertada = [];
            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO produccion (id_albaran, id_socio, id_parcela, tipo_producto, 
                     kg_aceituna, rendimiento, litros_aceite, acidez, fecha_entrada, hora_entrada) 
                            VALUES (?,?,?,?,?,?,?,?,?,?)");
                $sql->bindParam(1, $idAlbaran);
                $sql->bindParam(2, $idSocio);
                $sql->bindParam(3, $idParcela);
                $sql->bindParam(4, $tipo);
                $sql->bindParam(5, $kg);
                $sql->bindParam(6, $rendimiento);
                $sql->bindParam(7, $litros);
                $sql->bindParam(8, $acidez);
                $sql->bindParam(9, $fechaEntrada);
                $sql->bindParam(10, $horaEntrada);
                $resultado = $sql->execute();

                if ($resultado) {

                    $ultimaParcela = $conexion->lastInsertId();
                    $conexion->commit();// Se confirma la transacción actual
                    $parcelaInsertada = [

                        "resultado" => $correcto,
                        "idParcela" => $ultimaParcela,
                        "msg"       => "PARCELA INSERTADA CORRECTAMENTE"

                    ];

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;
                    $parcelaInsertada = [

                        "resultado" => $correcto,
                        "idParcela" => null,
                        'msg'       => "ERROR EN LA INSERCIÓN DE LA PARCELA"

                    ];

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $correcto = false;

                $parcelaInsertada = [

                    "resultado" => $correcto,
                    //"idUsuario" => $lastId,
                    'msg'       => 'ERROR AL REGISTRAR LA PARCELA. ALGUNO DE LOS DATOS YA SE ENCUENTRA EN EL REGISTRO'
                    //"msg"       => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }
            unset($conexion);
            return $parcelaInsertada;

        }

        function mostrarProduccionXidTicket($idProd){

            $conexion = $this->conexion;
            $remesa = [];

            try{

                $sql = "SELECT u.nombre, u.apellidos, u.direccion, u.cp, u.num_casa, u.piso, u.puerta, u.provincia, u.municipio, u.dni,
                        p.ref_catastral, p.poligono, p.parcela, pro.kg_aceituna, pro.litros_aceite, pro.rendimiento, pro.tipo_producto
                        FROM usuarios u 
                        INNER JOIN socios s ON u.id_usuario = s.id_usuario
                        INNER JOIN parcela p ON p.id_socio = s.id_socio
                        INNER JOIN produccion pro ON pro.id_socio = s.id_socio 
                         WHERE pro.id_albaran = $idProd";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0) {

                    $fila = $resultado->fetch(PDO::FETCH_OBJ);

                    $remesa[] = $fila;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $remesa = [

                    "codigo" => -2,
                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $remesa;

        }

        function busquedasProduccion($idSocio,$yearActual, $yearSiguiente, $pagina){

            $conexion = $this->conexion;

            /*Para realizar la paginación hay que poner la cláusula LIMIT, pero antes hay que apagar las preparaciones
            de consulta emuladas cambiando este atributo a false porque si no la cláusula LIMIT no será aceptada*/
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $parcelas = [];
            $datosFinales = [];

            try{

                $tamagnoPaginas = 5;
                $empezarDesde = ($pagina - 1)*$tamagnoPaginas;
                $sql = "SELECT pro.id_socio, pro.id_albaran, u.nombre, u.apellidos, p.provincia, p.municipio, p.ref_catastral, p.poligono, p.parcela, 
                        pro.kg_aceituna, pro.litros_aceite, pro.rendimiento, pro.acidez, pro.tipo_producto, pro.fecha_entrada, pro.hora_entrada
                        FROM usuarios u
                        INNER JOIN socios s ON u.id_usuario = s.id_usuario
                        INNER JOIN parcela p ON p.id_socio = s.id_socio
                        INNER JOIN produccion pro ON pro.id_parcela = p.id_parcela
                        WHERE pro.id_socio = $idSocio
                        AND (fecha_entrada >= '$yearActual'
                        AND fecha_entrada <= '$yearSiguiente')
                        ORDER BY fecha_entrada ASC";
                $resultado = $conexion->query($sql);
                $numRegistros = $resultado->rowCount();
                $totalPaginas = ceil($numRegistros/$tamagnoPaginas);
                $resultado->closeCursor();

                $sql_limit = "SELECT pro.id_socio, pro.id_albaran, u.nombre, u.apellidos, p.provincia, p.municipio, p.ref_catastral, p.poligono, p.parcela, 
                        pro.kg_aceituna, pro.litros_aceite, pro.rendimiento, pro.acidez, pro.tipo_producto, pro.fecha_entrada, pro.hora_entrada
                        FROM usuarios u
                        INNER JOIN socios s ON u.id_usuario = s.id_usuario
                        INNER JOIN parcela p ON p.id_socio = s.id_socio
                        INNER JOIN produccion pro ON pro.id_parcela = p.id_parcela
                        WHERE pro.id_socio = $idSocio
                        AND (fecha_entrada >= '$yearActual'
                        AND fecha_entrada <= '$yearSiguiente')
                        ORDER BY fecha_entrada ASC LIMIT $empezarDesde,$tamagnoPaginas";
                $resultado = $conexion->query($sql_limit);
                if ($resultado->rowCount() !== 0) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $parcelas[] = $fila;

                    }

                    $datosFinales = [

                        "remesas" => $parcelas,
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

    /*Las 10 mayores entradas de Kg de aceituna en una temporada concreta
     * SELECT pro.id_socio, pro.id_albaran, u.nombre, u.apellidos, p.provincia, p.municipio, p.ref_catastral, p.poligono, p.parcela,
    pro.kg_aceituna, pro.litros_aceite, pro.rendimiento, pro.acidez, pro.tipo_producto, pro.fecha_entrada, pro.hora_entrada
    FROM usuarios u
    INNER JOIN socios s ON u.id_usuario = s.id_usuario
    INNER JOIN parcela p ON p.id_socio = s.id_socio
    INNER JOIN produccion pro ON pro.id_parcela = p.id_parcela
    WHERE (fecha_entrada >= '2018-10-01'
    AND fecha_entrada <= '2019-03-31')
    ORDER BY pro.kg_aceituna DESC
    LIMIT 10*/

        /* Las 10 mayores estradas de Kg de aceituna de todos los tiempos de la almazara
         * SELECT pro.id_socio, pro.id_albaran, u.nombre, u.apellidos, p.provincia, p.municipio, p.ref_catastral, p.poligono, p.parcela,
                        pro.kg_aceituna, pro.litros_aceite, pro.rendimiento, pro.acidez, pro.tipo_producto, pro.fecha_entrada, pro.hora_entrada
                        FROM usuarios u
                        INNER JOIN socios s ON u.id_usuario = s.id_usuario
                        INNER JOIN parcela p ON p.id_socio = s.id_socio
                        INNER JOIN produccion pro ON pro.id_parcela = p.id_parcela
                        ORDER BY pro.kg_aceituna DESC
                        LIMIT 10
         */

    }