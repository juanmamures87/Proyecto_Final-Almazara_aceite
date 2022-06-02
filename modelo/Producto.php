<?php

    class Producto{

        private $id_producto;
        private $descripcion;
        private $fecha_inser;
        private $dcto;
        private $categoria;
        private $recipiente;
        private $litros_recipiente;
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
        public function getDescripcion()
        {
            return $this->Descripcion;
        }

        /**
         * @param mixed $descripcion
         */
        public function setDescripcion($descripcion): void
        {
            $this->Descripcion = $descripcion;
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
        public function getRecipiente()
        {
            return $this->recipiente;
        }

        /**
         * @param mixed $recipiente
         */
        public function setRecipiente($recipiente): void
        {
            $this->recipiente = $recipiente;
        }

        /**
         * @return mixed
         */
        public function getLitrosRecipiente()
        {
            return $this->litros_recipiente;
        }

        /**
         * @param mixed $litros_recipiente
         */
        public function setLitrosRecipiente($litros_recipiente): void
        {
            $this->litros_recipiente = $litros_recipiente;
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