<?php

    class Compra{

        private $id_compra;
        private $id_cliente;
        private $fecha_compra;
        private $total;

        public function __construct(){

            $this->id_compra = null;
            $this->fecha_compra = date('Y-m-d');

        }

        /**
         * @return null
         */
        public function getIdCompra()
        {
            return $this->id_compra;
        }

        /**
         * @param null $id_compra
         */
        public function setIdCompra($id_compra): void
        {
            $this->id_compra = $id_compra;
        }

        /**
         * @return mixed
         */
        public function getIdCliente()
        {
            return $this->id_cliente;
        }

        /**
         * @param mixed $id_cliente
         */
        public function setIdCliente($id_cliente): void
        {
            $this->id_cliente = $id_cliente;
        }

        /**
         * @return string
         */
        public function getFechaCompra(): string
        {
            return $this->fecha_compra;
        }

        /**
         * @param string $fecha_compra
         */
        public function setFechaCompra(string $fecha_compra): void
        {
            $this->fecha_compra = $fecha_compra;
        }

        /**
         * @return mixed
         */
        public function getTotal()
        {
            return $this->total;
        }

        /**
         * @param mixed $total
         */
        public function setTotal($total): void
        {
            $this->total = $total;
        }



    }