<?php

    class Socio{

        private $id_socio;
        private $id_usuario;
        private $tipo_socio;
        private $fecha_alta;
        private $fecha_baja;

        public function __construct(){

            $this->id_socio = null;
            $this->tipo_socio = "común";
            $this->fecha_alta = date('Y-m-d');
            $this->fecha_baja = null;

        }

        /**
         * @return null
         */
        public function getIdSocio()
        {
            return $this->id_socio;
        }

        /**
         * @param null $id_socio
         */
        public function setIdSocio($id_socio): void
        {
            $this->id_socio = $id_socio;
        }

        /**
         * @return mixed
         */
        public function getIdUsuario()
        {
            return $this->id_usuario;
        }

        /**
         * @param mixed $id_usuario
         */
        public function setIdUsuario($id_usuario): void
        {
            $this->id_usuario = $id_usuario;
        }

        /**
         * @return mixed
         */
        public function getTipoSocio()
        {
            return $this->tipo_socio;
        }

        /**
         * @param mixed $tipo_socio
         */
        public function setTipoSocio($tipo_socio): void
        {
            $this->tipo_socio = $tipo_socio;
        }

        /**
         * @return string
         */
        public function getFechaAlta(): string
        {
            return $this->fecha_alta;
        }

        /**
         * @param string $fecha_alta
         */
        public function setFechaAlta(string $fecha_alta): void
        {
            $this->fecha_alta = $fecha_alta;
        }

        /**
         * @return mixed
         */
        public function getFechaBaja()
        {
            return $this->fecha_baja;
        }

        /**
         * @param mixed $fecha_baja
         */
        public function setFechaBaja($fecha_baja): void
        {
            $this->fecha_baja = $fecha_baja;
        }



    }