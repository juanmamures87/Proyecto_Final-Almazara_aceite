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

    }