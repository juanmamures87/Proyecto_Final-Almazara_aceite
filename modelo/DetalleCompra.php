<?php

    class DetalleCompra{

        private $id_detalle;
        private $id_compra;
        private $id_producto;
        private $unidades;
        private $pvp;
        private $dcto;

        public function __construct(){

            $this->id_detalle = null;

        }

        /**
         * @return null
         */
        public function getIdDetalle()
        {
            return $this->id_detalle;
        }

        /**
         * @param null $id_detalle
         */
        public function setIdDetalle($id_detalle): void
        {
            $this->id_detalle = $id_detalle;
        }

        /**
         * @return mixed
         */
        public function getIdCompra()
        {
            return $this->id_compra;
        }

        /**
         * @param mixed $id_compra
         */
        public function setIdCompra($id_compra): void
        {
            $this->id_compra = $id_compra;
        }

        /**
         * @return mixed
         */
        public function getIdProducto()
        {
            return $this->id_producto;
        }

        /**
         * @param mixed $id_producto
         */
        public function setIdProducto($id_producto): void
        {
            $this->id_producto = $id_producto;
        }

        /**
         * @return mixed
         */
        public function getUnidades()
        {
            return $this->unidades;
        }

        /**
         * @param mixed $unidades
         */
        public function setUnidades($unidades): void
        {
            $this->unidades = $unidades;
        }

        /**
         * @return mixed
         */
        public function getPvp()
        {
            return $this->pvp;
        }

        /**
         * @param mixed $pvp
         */
        public function setPvp($pvp): void
        {
            $this->pvp = $pvp;
        }

        /**
         * @return mixed
         */
        public function getDcto()
        {
            return $this->dcto;
        }

        /**
         * @param mixed $dcto
         */
        public function setDcto($dcto): void
        {
            $this->dcto = $dcto;
        }



    }