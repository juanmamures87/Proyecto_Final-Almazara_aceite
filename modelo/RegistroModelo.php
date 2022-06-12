<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require_once "bat/PHPMailerClase/src/Exception.php";
    require_once "bat/PHPMailerClase/src/PHPMailer.php";
    require_once "bat/PHPMailerClase/src/SMTP.php";

    class RegistroModelo{

        private $conexion;
        private $usuario;
        private $socio;
        private $cliente;

        public function __construct(){

            require_once "Conexion.php";
            $this->conexion = Conexion::getConexion();
            require_once "Usuario.php";
            $this->usuario = new Usuario();
            require_once "Socio.php";
            $this->socio = new Socio();
            require_once "Cliente.php";
            $this->cliente = new Cliente();

        }

        function insertarUsuario($nom, $ape, $dni, $tel, $prov, $mun, $dir, $cp, $num_casa, $piso, $puerta, $email, $pass, $activo){

            $conexion = $this->conexion;
            $idUsuario = $this->usuario->getIdUsuario();
            $hasheada = password_hash($pass, PASSWORD_DEFAULT);

            $usuarioInsertado = [];
            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO usuarios (id_usuario, nombre, apellidos, dni, telefono, 
                      provincia, municipio, direccion, cp, num_casa, piso, puerta, email, password, activo) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $sql->bindParam(1, $idUsuario);
                $sql->bindParam(2, $nom);
                $sql->bindParam(3, $ape);
                $sql->bindParam(4, $dni);
                $sql->bindParam(5, $tel);
                $sql->bindParam(6, $prov);
                $sql->bindParam(7, $mun);
                $sql->bindParam(8, $dir);
                $sql->bindParam(9, $cp);
                $sql->bindParam(10, $num_casa);
                $sql->bindParam(11, $piso);
                $sql->bindParam(12, $puerta);
                $sql->bindParam(13, $email);
                $sql->bindParam(14, $hasheada);
                $sql->bindParam(15, $activo);
                $resultado = $sql->execute();

                if ($resultado) {

                    $lastId = $conexion->lastInsertId();
                    $conexion->commit();// Se confirma la transacción actual
                    $usuarioInsertado = [

                        "resultado" => $correcto,
                        "idUsuario" => $lastId,
                        "msg"       => "USUARIO INSERTADO CORRECTAMENTE"

                    ];

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;
                    $usuarioInsertado = [

                        "resultado" => $correcto,
                        "idUsuario" => null,
                        'msg'       => "ERROR EN LA INSERCIÓN DEL USUARIO"

                    ];

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                $correcto = false;

                $usuarioInsertado = [

                    "resultado" => $correcto,
                    //"idUsuario" => $lastId,
                    'msg'       => 'ERROR AL REGISTRAR AL USUARIO. ALGUNO DE LOS DATOS YA SE ENCUENTRA EN EL REGISTRO'
                    //"msg"       => "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName

                ];

            }
            unset($conexion);
            return $usuarioInsertado;

        }

        function insertarSocio($idUsuario){

            $conexion = $this->conexion;
            $idSocio = $this->socio->getIdSocio();
            $tipoSocio = $this->socio->getTipoSocio();
            $fechaAlta = $this->socio->getFechaAlta();
            $fechaBaja = $this->socio->getFechaBaja();
            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO socios (id_socio, id_usuario, tipo_socio, fecha_alta, fecha_baja) 
                            VALUES (?,?,?,?,?)");
                $sql->bindParam(1, $idSocio);
                $sql->bindParam(2, $idUsuario);
                $sql->bindParam(3, $tipoSocio);
                $sql->bindParam(4, $fechaAlta);
                $sql->bindParam(5, $fechaBaja);
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

        function insertarCliente($idUsuario, $empresa){

            $conexion = $this->conexion;
            $idCliente = $this->cliente->getIdCliente();
            $token = $this->cliente->getToken();
            $correcto = true;
            $conexion->beginTransaction();//deshabilito el modo autocommit

            try {

                $sql = $conexion->prepare("INSERT INTO clientes (id_cliente, id_usuario, empresa, token) 
                            VALUES (?,?,?,?)");
                $sql->bindParam(1, $idCliente);
                $sql->bindParam(2, $idUsuario);
                $sql->bindParam(3, $empresa);
                $sql->bindParam(4, $token);
                $resultado = $sql->execute();

                if ($resultado) {

                    $conexion->commit();// Se confirma la transacción actual

                } else {

                    $conexion->rollBack();//si no se puede realizar la inserción la transacción vuelve atrás y no se realiza
                    $correcto = false;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();
                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName;

                $correcto = false;

            }
            unset($conexion);
            return $correcto;

        }

        function tokenClientes($email, $clave){

            $conexion = $this->conexion;
            $token = null;
            try {

                $sql = "SELECT cli.token, u.email, u.password
                        FROM clientes cli 
                        INNER JOIN usuarios u ON cli.id_usuario = u.id_usuario      
                        WHERE LOWER (u.email) = LOWER ('$email')";
                $resultado = $conexion->query($sql);
                if ($resultado) {

                    while ($fila = $resultado->fetch(PDO::FETCH_OBJ)) {

                        if ((password_verify($clave, $fila->password))){

                            $token = $fila->token;
                        }
                    }
                }
            }catch (PDOException $e){

                $errorName = $e->getMessage();

                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName;

                $token = null;

            }

            unset($conexion);
            return $token;

        }

        function correoConfirmacionClientes($nombre, $clave, $email, $token){

            $correcto = true;
            $destinatario = $email;
            $titulo = "Verificación de cuenta";
            $mensaje = "¡Gracias por registrarte!\r\n
                    Su cuenta ha sido creada. Puede iniciar sesión con\r\n 
                    las siguientes credenciales después de haber activado\r\n 
                    su cuenta haciendo click en la URL que encontrará a continuación.
                -----------------------
                Nombre de Usuario: $nombre
                Contraseña: $clave
                -----------------------
                \r\n
                Por favor, pulsa el siguiente link para activar tu cuenta:
                \r\n
                http://server.edu/ProyectoFinalDAW_AlmazaraAceite/index.php?controlador=verificacion&accion=activar&email=$email&token=$token
                \r\n
                Por favor, guarde su clave en un sitio seguro. \r\n
                Un saludo y gracias por confiar en nosotros\r\n\r\n
                ALMAZARA COOPERATIVA MOLINO DEL SUR.";

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->CharSet = "UTF-8";
                $mail->Encoding = "quoted-printable";
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;//Enable verbose debug output Modo desarrollo
                $mail->SMTPDebug = SMTP::DEBUG_OFF;//Modo producción
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'in-v3.mailjet.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'c1ae0c1d43cc1a7cb45d63e468a4ce78';                     //SMTP username
                $mail->Password   = 'eee413e8a167317b3a2f11de712eabf6';                               //SMTP password
                $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('molino_sur_coop@hotmail.com', 'Correo');
                $mail->addAddress($destinatario, $nombre);
                $mail->addReplyTo('molino_sur_coop@hotmail.com', 'Información');

                //Content
                $mail->Subject = $titulo;
                $mail->Body    = $mensaje;

                $mail->send();
                //echo "<script>alert('¡¡MENSAJE ENVIADO CORRECTAMENTE!!')</script>";

            } catch (\Exception) {

                echo "<script>alert('¡¡EL MENSAJE NO HA PODIDO SER ENVIADO!!. Mailer Error: {$mail->ErrorInfo}')</script>";
                $correcto = false;

            }

            return $correcto;

        }

        function comprobarURL($email, $token){

            $conexion = $this->conexion;
            $encontrado = 0;
            try {

                $sql = "SELECT u.email, u.activo, cli.token 
                        FROM usuarios u 
                        INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario
                        WHERE u.email = '$email'  
                        AND u.activo = '0' 
                        AND cli.token = '$token'";
                $resultado = $conexion->query($sql);
                if ($resultado->rowCount() !== 0){

                    $encontrado = 1;

                }

            }catch (PDOException $e){

                $errorName = $e->getMessage();

                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName;

            }

            unset($conexion);
            return $encontrado;

        }

        function actualizarActivado($email, $token){

            $conexion = $this->conexion;
            $conexion->beginTransaction();//deshabilito el modo autocommit
            try {

                $sql = $conexion->prepare("UPDATE usuarios u
                                                 INNER JOIN clientes cli ON cli.id_usuario = u.id_usuario
                                                 SET u.activo = '1' 
                                                 WHERE u.email = ? 
                                                 AND cli.token = ? 
                                                 AND u.activo = '0'");
                $sql->bindParam(1, $email);
                $sql->bindParam(2, $token);
                $resultado = $sql->execute();
                if ($resultado) {

                    $conexion->commit();
                    $actualizado = 1;

                }else{

                    $conexion->rollBack();
                    $actualizado = 0;

                }
            }catch (PDOException $e){

                $errorName = $e->getMessage();

                echo "ERROR DE CONEXIÓN CON LA BASE DE DATOS \n Modelo: " . get_class($this) . "\nMensaje: " . $errorName;
                $actualizado = 0;

            }

            unset($conexion);
            return $actualizado;

        }

        function correoConfirmacionSocios($nombre, $dni, $clave, $email): bool{

            $correcto = true;
            $destinatario   = $email;
            $titulo         = "Verificación de cuenta";
            $mensaje        = "¡Ha sido registrado exitosamente en Molino del Sur!\r\n
                               Le damos la BIENVENIDA COMO NUEVO SOCIO DE NUESTRA COOPERATIVA.\r\n
            
                    Su cuenta ha sido creada y puede iniciar sesión con las siguientes credenciales.\r\n
                -----------------------------------------
                    Usuario - DNI: $dni
                    Contraseña: $clave
                -----------------------------------------
                    
                Por favor, guarde su clave en un sitio seguro. \r\n
                Un saludo y gracias por confiar en nosotros\r\n\r\n
                ALMAZARA COOPERATIVA MOLINO DEL SUR.";
            $mail = new PHPMailer(true);

            try {

                //Server settings
                $mail->CharSet = "UTF-8";
                $mail->Encoding = "quoted-printable";
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                        //Enable verbose debug output Modo desarrollo
                $mail->SMTPDebug = SMTP::DEBUG_OFF;                             //Modo producción
                $mail->isSMTP();                                                //Send using SMTP
                $mail->Host       = 'in-v3.mailjet.com';                        //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                       //Enable SMTP authentication
                $mail->Username   = 'c1ae0c1d43cc1a7cb45d63e468a4ce78';                   //SMTP username
                $mail->Password   = 'eee413e8a167317b3a2f11de712eabf6';                    //SMTP password
                $mail->SMTPSecure = 'tls';                //Enable implicit TLS encryption
                $mail->Port       = 587;//                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('molino_sur_coop@hotmail.com', 'Correo');
                $mail->addAddress($destinatario, $nombre);
                $mail->addReplyTo('molino_sur_coop@hotmail.com', 'Información');

                //Content
                $mail->Subject = $titulo;
                $mail->Body    = $mensaje;

                $mail->send();
                //echo "<script>alert('¡¡MENSAJE ENVIADO CORRECTAMENTE!!')</script>";

            } catch (\Exception) {

                echo "<script>alert('¡¡EL MENSAJE NO HA PODIDO SER ENVIADO!!. Mailer Error: {$mail->ErrorInfo}')</script>";
                $correcto = false;

            }

            return $correcto;

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