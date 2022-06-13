<?php

    class LoginModelo{

        private $conexion;
        private $usuario;
        private $cliente;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Usuario.php";
            $this->usuario = new Usuario();
            require_once 'Cliente.php';
            $this->cliente = new Cliente();

        }

        function aceptarSocioLogin($dni, $password){

            $conexion = $this->conexion;
            $datos = [];

            try {

                $sql = "SELECT u.id_usuario, u.nombre, u.apellidos, u.dni, u.password, u.activo, s.id_socio, s.tipo_socio FROM usuarios u 
                        INNER JOIN socios s ON u.id_usuario = s.id_usuario WHERE lower(u.dni) LIKE lower('$dni')";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0){

                    $fila = $resultado->fetch(PDO::FETCH_OBJ);

                        if ((password_verify($password, $fila->password)) && ($fila->activo == 1)) {

                            $datos = [

                                "codigo" => 1,
                                "usuario" => $fila

                            ];

                        } else if((password_verify($password, $fila->password)) && ($fila->activo == 0)) {

                            $datos =[

                                "codigo" => 2,
                                "error" => "SOCIO SIN PERMISO PARA ACCEDER. PÓNGASE EN CONTACTO CON EL ADMINISTRADOR"

                            ];

                        }else if (!password_verify($password, $fila->password)){

                            $datos =[

                                "codigo" => 0,
                                "error" => "CONTRASEÑA INCORRECTA VUELVA A INTRODUCIRLA"

                            ];

                        }

                }else{

                    $datos = [

                        "codigo" => -1,
                        "error" => "LOS DATOS INTRODUCIDOS NO CORRESPONDEN A NINGÚN SOCIO"

                    ];

                }
            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $datos = [

                    "codigo" => -2,
                    "errorConex" => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }

            unset($conexion);
            return $datos;

        }

        function aceptarClienteLogin($email, $password){

            $conexion = $this->conexion;
            $datos = [];

            try {

                $sql = "SELECT * FROM usuarios u 
                        INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario 
                        WHERE lower(u.email) LIKE lower('$email')";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0){

                    $fila = $resultado->fetch(PDO::FETCH_OBJ);

                    if ((password_verify($password, $fila->password)) && ($fila->activo == 1)) {

                        $datos = [

                            "codigo" => 1,
                            "usuario" => $fila

                        ];

                    } else if((password_verify($password, $fila->password)) && ($fila->activo == 0)) {

                        $datos =[

                            "codigo" => 2

                        ];

                    }else if (!password_verify($password, $fila->password)){

                        $datos =[

                            "codigo" => 0

                        ];

                    }

                }else{

                    $datos = [

                        "codigo" => -1

                    ];

                }
            }catch (PDOException $e){

                $errorName = $e->getMessage();
                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName;


            }

            unset($conexion);
            return $datos;

        }

    }