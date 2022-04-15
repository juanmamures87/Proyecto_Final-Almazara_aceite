<?php

    //JUAN MARÍA CASTRO ARJONA-Proyecto Final Ciclo DAW - Almazara Aceite

    /*Declaración de tres constantes para indicar la carpeta por defecto donde están los controladores a utilizar,
    el controlador por defecto que se va a utilizar y la acción que se va a coger por defecto respectivamente*/
    const CONTROLADOR_DIRECTORIO = "controlador/";
    const CONTROLADOR_DEFECTO = "inicio";
    const ACCION_DEFECTO = "portada";

    /*******************************VARIABLES CONTROLADAS CON GET, POST O SESSION****************************************/

    //Controlamos que el nombre de controlador llegue por GET, POST o SESSION
    $controlador = CONTROLADOR_DEFECTO;
    if (!empty($_GET['controlador'])) {

        $controlador = $_GET['controlador'];

    }elseif (!empty($_POST['controlador'])){

        $controlador = $_POST['controlador'];

    }elseif (!empty($_SESSION['controlador'])){

        $controlador = $_SESSION['controlador'];

    }

    //Controlamos que la acción a utilizar llegue por GET, POST o SESSION
    $accion = ACCION_DEFECTO;
    if (!empty($_GET['accion'])) {

        $accion = $_GET['accion'];

    }elseif (!empty($_POST['accion'])){

        $accion = $_POST['accion'];

    }elseif (!empty($_SESSION['accion'])){

        $accion = $_SESSION['accion'];

    }

    //Aqui formamos el archivo con el controlador y la acción a utilizar
    $controlador = CONTROLADOR_DIRECTORIO . $controlador . 'Controlador.php';

    //Si es un archivo utiliza require_once para llamarlo, si no es así da error de que no existe
    if ( is_file ( $controlador ) )

        require_once ($controlador);

    else

        die ('<div style="text-align: center; margin-top: 50px"><h1>EL CONTROLADOR NO EXISTE - 404 NO ENCONTRADO</h1></div>');

    //Aquí si la acción recogida anteriormente es una función del controlador en cuestión la utiliza, si no indica que no existe.
    if (is_callable($accion))

        $accion();

    else

        die ('<div style="text-align: center; margin-top: 50px"><h1>LA ACCIÓN NO EXISTE - 404 NO ENCONTRADA</h1></div>');
