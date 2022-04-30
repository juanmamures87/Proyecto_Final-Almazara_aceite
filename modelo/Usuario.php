<?php

    class Usuario{

        private $id_usuario;
        private string $nombre;
        private string $apellidos;
        private string $dni;
        private int $telefono;
        private string $provincia;
        private string $municipio;
        private string $direccion;
        private int $cp;
        private int $num_casa;
        private int $piso;
        private string $puerta;
        private string $email;
        private string $password;
        private int $activo;

        public function __construct(){

            $this->id_usuario = null;

        }

        /**
         * @return null
         */
        public function getIdUsuario()
        {
            return $this->id_usuario;
        }

        /**
         * @param null $id_usuario
         */
        public function setIdUsuario($id_usuario): void
        {
            $this->id_usuario = $id_usuario;
        }

        /**
         * @return string
         */
        public function getNombre(): string
        {
            return $this->nombre;
        }

        /**
         * @param string $nombre
         */
        public function setNombre(string $nombre): void
        {
            $this->nombre = $nombre;
        }

        /**
         * @return string
         */
        public function getApellidos(): string
        {
            return $this->apellidos;
        }

        /**
         * @param string $apellidos
         */
        public function setApellidos(string $apellidos): void
        {
            $this->apellidos = $apellidos;
        }

        /**
         * @return string
         */
        public function getDni(): string
        {
            return $this->dni;
        }

        /**
         * @param string $dni
         */
        public function setDni(string $dni): void
        {
            $this->dni = $dni;
        }

        /**
         * @return int
         */
        public function getTelefono(): int
        {
            return $this->telefono;
        }

        /**
         * @param int $telefono
         */
        public function setTelefono(int $telefono): void
        {
            $this->telefono = $telefono;
        }

        /**
         * @return string
         */
        public function getProvincia(): string
        {
            return $this->provincia;
        }

        /**
         * @param string $provincia
         */
        public function setProvincia(string $provincia): void
        {
            $this->provincia = $provincia;
        }

        /**
         * @return string
         */
        public function getMunicipio(): string
        {
            return $this->municipio;
        }

        /**
         * @param string $municipio
         */
        public function setMunicipio(string $municipio): void
        {
            $this->municipio = $municipio;
        }

        /**
         * @return string
         */
        public function getDireccion(): string
        {
            return $this->direccion;
        }

        /**
         * @param string $direccion
         */
        public function setDireccion(string $direccion): void
        {
            $this->direccion = $direccion;
        }

        /**
         * @return int
         */
        public function getCp(): int
        {
            return $this->cp;
        }

        /**
         * @param int $cp
         */
        public function setCp(int $cp): void
        {
            $this->cp = $cp;
        }

        /**
         * @return int
         */
        public function getNumCasa(): int
        {
            return $this->num_casa;
        }

        /**
         * @param int $num_casa
         */
        public function setNumCasa(int $num_casa): void
        {
            $this->num_casa = $num_casa;
        }

        /**
         * @return int
         */
        public function getPiso(): int
        {
            return $this->piso;
        }

        /**
         * @param int $piso
         */
        public function setPiso(int $piso): void
        {
            $this->piso = $piso;
        }

        /**
         * @return string
         */
        public function getPuerta(): string
        {
            return $this->puerta;
        }

        /**
         * @param string $puerta
         */
        public function setPuerta(string $puerta): void
        {
            $this->puerta = $puerta;
        }

        /**
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * @param string $email
         */
        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        /**
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * @param string $password
         */
        public function setPassword(string $password): void
        {
            $this->password = $password;
        }

        /**
         * @return int
         */
        public function getActivo(): int
        {
            return $this->activo;
        }

        /**
         * @param int $activo
         */
        public function setActivo(int $activo): void
        {
            $this->activo = $activo;
        }



    }