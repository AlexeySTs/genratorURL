<?php
    namespace Helper;

    class Route 
    {
        private $path;
        private $controller;
        private $method;

        public function __construct($path, $controller, $method) {
            $this->path = $path;
            $this->controller = $controller;
            $this->method = $method;
        }

        public function __get($parameter) {
            return $this->$parameter;
        }
    }