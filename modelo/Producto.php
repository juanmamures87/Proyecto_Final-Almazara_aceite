<?php

    class Producto{

        private $id_producto;
        private $nombre;
        private $fecha_inser;
        private $dcto;
        private $categoria;
        private $imagen;

        public function __construct(){

            $this->id_producto = null;
            $this->fecha_inser = date('Y-m-d');
            $this->dcto = 0;

        }

        /**
         * @return null
         */
        public function getIdProducto()
        {
            return $this->id_producto;
        }

        /**
         * @param null $id_producto
         */
        public function setIdProducto($id_producto): void
        {
            $this->id_producto = $id_producto;
        }

        /**
         * @return mixed
         */
        public function getNombre()
        {
            return $this->nombre;
        }

        /**
         * @param mixed $nombre
         */
        public function setNombre($nombre): void
        {
            $this->nombre = $nombre;
        }

        /**
         * @return string
         */
        public function getFechaInser(): string
        {
            return $this->fecha_inser;
        }

        /**
         * @param string $fecha_inser
         */
        public function setFechaInser(string $fecha_inser): void
        {
            $this->fecha_inser = $fecha_inser;
        }

        /**
         * @return int
         */
        public function getDcto(): int
        {
            return $this->dcto;
        }

        /**
         * @param int $dcto
         */
        public function setDcto(int $dcto): void
        {
            $this->dcto = $dcto;
        }

        /**
         * @return mixed
         */
        public function getCategoria()
        {
            return $this->categoria;
        }

        /**
         * @param mixed $categoria
         */
        public function setCategoria($categoria): void
        {
            $this->categoria = $categoria;
        }

        /**
         * @return mixed
         */
        public function getImagen()
        {
            return $this->imagen;
        }

        /**
         * @param mixed $imagen
         */
        public function setImagen($imagen): void
        {
            $this->imagen = $imagen;
        }

    }