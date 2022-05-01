<?php

    class RegistroModelo{

        private $conexion;
        private $usuario;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Usuario.php";
            $this->usuario = new Usuario();

        }

        function getCodigoPostal($poblacion){

            $conexion = $this->conexion;
            $codPost = array();

            try {

                $sql = "SELECT cod FROM codigospostales WHERE poblacion = '$poblacion'";
                $resultado = $conexion->query($sql);
                if ($resultado) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        $codPost[] = $fila->cod;

                    }

                }else {

                    $codPost = array(

                        "Mensaje" => 'Error, no hay ninguna coincicendia'
                    );

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $codPost = [

                    "msg" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $codPost;
        }

    }