<?php

    function portada(){

        require_once "vista/index.html";

    }

    function quienesSomos(){

        require_once "vista/quienesSomos.html";

    }

    function actualidad(){

        require_once "vista/actualidad.html";

    }

    function contacto(){

        require_once "vista/contacto.html";

    }

    function tienda(){

        require_once 'modelo/ProductoModelo.php';
        $productos = new ProductoModelo();
        $muestraTienda = $productos->mostrarProductosTienda();
        require_once "vista/tienda.php";

    }

    function accesoSocios(){

        require_once "vista/accesoSocios.php";

    }

    function carrito(){

        require_once 'vista/carritoCompra.php';

    }


