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

    }