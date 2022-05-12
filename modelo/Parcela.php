<?php

    class Parcela{

        private $id_parcela;
        private $id_socio;
        private $provincia;
        private $municipio;
        private $ref_catastral;
        private $poligono;
        private $parcela;
        private $superficie;
        private $sistema_cultivo;
        private $variedad_aceituna;
        private $num_plantas;

        public function __construct(){

            $this->id_parcela = null;

        }

        /**
         * @return null
         */
        public function getIdParcela()
        {
            return $this->id_parcela;
        }

        /**
         * @param null $id_parcela
         */
        public function setIdParcela($id_parcela): void
        {
            $this->id_parcela = $id_parcela;
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
        public function getProvincia()
        {
            return $this->provincia;
        }

        /**
         * @param mixed $provincia
         */
        public function setProvincia($provincia): void
        {
            $this->provincia = $provincia;
        }

        /**
         * @return mixed
         */
        public function getMunicipio()
        {
            return $this->municipio;
        }

        /**
         * @param mixed $municipio
         */
        public function setMunicipio($municipio): void
        {
            $this->municipio = $municipio;
        }

        /**
         * @return mixed
         */
        public function getRefCatastral()
        {
            return $this->ref_catastral;
        }

        /**
         * @param mixed $ref_catastral
         */
        public function setRefCatastral($ref_catastral): void
        {
            $this->ref_catastral = $ref_catastral;
        }

        /**
         * @return mixed
         */
        public function getPoligono()
        {
            return $this->poligono;
        }

        /**
         * @param mixed $poligono
         */
        public function setPoligono($poligono): void
        {
            $this->poligono = $poligono;
        }

        /**
         * @return mixed
         */
        public function getParcela()
        {
            return $this->parcela;
        }

        /**
         * @param mixed $parcela
         */
        public function setParcela($parcela): void
        {
            $this->parcela = $parcela;
        }

        /**
         * @return mixed
         */
        public function getSuperficie()
        {
            return $this->superficie;
        }

        /**
         * @param mixed $superficie
         */
        public function setSuperficie($superficie): void
        {
            $this->superficie = $superficie;
        }

        /**
         * @return mixed
         */
        public function getSistemaCultivo()
        {
            return $this->sistema_cultivo;
        }

        /**
         * @param mixed $sistema_cultivo
         */
        public function setSistemaCultivo($sistema_cultivo): void
        {
            $this->sistema_cultivo = $sistema_cultivo;
        }

        /**
         * @return mixed
         */
        public function getVariedadAceituna()
        {
            return $this->variedad_aceituna;
        }

        /**
         * @param mixed $variedad_aceituna
         */
        public function setVariedadAceituna($variedad_aceituna): void
        {
            $this->variedad_aceituna = $variedad_aceituna;
        }

        /**
         * @return mixed
         */
        public function getNumPlantas()
        {
            return $this->num_plantas;
        }

        /**
         * @param mixed $num_plantas
         */
        public function setNumPlantas($num_plantas): void
        {
            $this->num_plantas = $num_plantas;
        }



    }