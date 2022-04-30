<?php

    class Conexion{

        private static $instancia;

        private function __construct(){

            try {

                $dsn = "mysql:host=localhost;dbname=proyecto_final_almazara";
                self::$instancia = new PDO($dsn, 'root', '2Cfgs');

            } catch (PDOException $e) {

                $errorLine = $e->getLine();
                echo "<script>alert('¡¡ERROR DE CONEXIÓN CON LA BASE DE DATOS!!\\n Error en la línea: " . $errorLine . "')</script>";

            }

        }

        public static function getConexion(): PDO{

            if (!self::$instancia instanceof self){

                new self();

            }

            return self::$instancia;

        }


    }