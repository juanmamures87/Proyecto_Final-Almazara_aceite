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

    }