<?php

    function cerrarSesion(){

        session_start();
        session_destroy();
        header("location: portada");

    }

