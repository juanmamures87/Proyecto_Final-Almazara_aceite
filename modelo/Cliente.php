<?php

    class Cliente{

        private $id_cliente;
        private $id_usuario;
        private $empresa;
        private $token;

        public function __construct(){

            $this->id_cliente = null;
            $this->token = md5(rand(0,1000));

        }

        /**
         * @return null
         */
        public function getIdCliente()
        {
            return $this->id_cliente;
        }

        /**
         * @param null $id_cliente
         */
        public function setIdCliente($id_cliente): void
        {
            $this->id_cliente = $id_cliente;
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
        public function getEmpresa()
        {
            return $this->empresa;
        }

        /**
         * @param mixed $empresa
         */
        public function setEmpresa($empresa): void
        {
            $this->empresa = $empresa;
        }

        /**
         * @return mixed
         */
        public function getToken()
        {
            return $this->token;
        }

        /**
         * @param mixed $token
         */
        public function setToken($token): void
        {
            $this->token = $token;
        }



    }