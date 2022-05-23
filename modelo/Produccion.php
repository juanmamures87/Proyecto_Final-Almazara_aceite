<?php

    class Produccion{

        private $id_albaran;
        private $id_socio;
        private $id_parcela;
        private $tipo_producto;
        private $kg_aceituna;
        private $rendimiento;
        private $litros_aceite;
        private $acidez;
        private $fecha_entrada;
        private $hora_entrada;

        public function __construct(){

            $this->id_albaran = null;
            $this->fecha_entrada = date('Y-m-d');
            $this->hora_entrada = date('H:i:s');

        }

        /**
         * @return null
         */
        public function getIdAlbaran()
        {
            return $this->id_albaran;
        }

        /**
         * @param null $id_albaran
         */
        public function setIdAlbaran($id_albaran): void
        {
            $this->id_albaran = $id_albaran;
        }

        /**
         * @return mixed
         */
        public function getIdSocio()
        {
            return $this->id_socio;
        }

        /**
         * @param mixed $id_socio
         */
        public function setIdSocio($id_socio): void
        {
            $this->id_socio = $id_socio;
        }

        /**
         * @return mixed
         */
        public function getIdParcela()
        {
            return $this->id_parcela;
        }

        /**
         * @param mixed $id_parcela
         */
        public function setIdParcela($id_parcela): void
        {
            $this->id_parcela = $id_parcela;
        }

        /**
         * @return mixed
         */
        public function getTipoProducto()
        {
            return $this->tipo_producto;
        }

        /**
         * @param mixed $tipo_producto
         */
        public function setTipoProducto($tipo_producto): void
        {
            $this->tipo_producto = $tipo_producto;
        }

        /**
         * @return mixed
         */
        public function getKgAceituna()
        {
            return $this->kg_aceituna;
        }

        /**
         * @param mixed $kg_aceituna
         */
        public function setKgAceituna($kg_aceituna): void
        {
            $this->kg_aceituna = $kg_aceituna;
        }

        /**
         * @return mixed
         */
        public function getRendimiento()
        {
            return $this->rendimiento;
        }

        /**
         * @param mixed $rendimiento
         */
        public function setRendimiento($rendimiento): void
        {
            $this->rendimiento = $rendimiento;
        }

        /**
         * @return mixed
         */
        public function getLitrosAceite()
        {
            return $this->litros_aceite;
        }

        /**
         * @param mixed $litros_aceite
         */
        public function setLitrosAceite($litros_aceite): void
        {
            $this->litros_aceite = $litros_aceite;
        }

        /**
         * @return mixed
         */
        public function getAcidez()
        {
            return $this->acidez;
        }

        /**
         * @param mixed $acidez
         */
        public function setAcidez($acidez): void
        {
            $this->acidez = $acidez;
        }

        /**
         * @return mixed
         */
        public function getFechaEntrada()
        {
            return $this->fecha_entrada;
        }

        /**
         * @param mixed $fecha_entrada
         */
        public function setFechaEntrada($fecha_entrada): void
        {
            $this->fecha_entrada = $fecha_entrada;
        }

        /**
         * @return mixed
         */
        public function getHoraEntrada()
        {
            return $this->hora_entrada;
        }

        /**
         * @param mixed $hora_entrada
         */
        public function setHoraEntrada($hora_entrada): void
        {
            $this->hora_entrada = $hora_entrada;
        }



    }