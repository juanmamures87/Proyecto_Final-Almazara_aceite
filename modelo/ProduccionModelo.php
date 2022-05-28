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
            $fechaEntrada = $this->produccion->getFechaEntrada();
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

        function mostrarProduccionXid($idProd){

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

    }