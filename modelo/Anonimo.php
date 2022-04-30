<?php

    class Anonimo{

        private $id_anonimo;
        private $id_usuario;

        public function __construct(){

            $this->id_anonimo = null;

        }

        /**
         * @return null
         */
        public function getIdAnonimo()
        {
            return $this->id_anonimo;
        }

        /**
         * @param null $id_anonimo
         */
        public function setIdAnonimo($id_anonimo): void
        {
            $this->id_anonimo = $id_anonimo;
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



    }