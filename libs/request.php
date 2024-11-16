<?php
    class Request {
        public $body = null; // Recibe el body de la solicitud (en POST o PUT los nuevos valores)
        public $params = null; // Recibe el parametro (hola/1)
        public $query = null; // Guarda las condiciones en parametros de la url, por ejemplo ?soloFinalizadas=true (solo mostrar los que esten finalizados)

        public function __construct() {
            try {
                $this->body = json_decode(file_get_contents('php://input')); // Obtiene todos los datos del body y los guarda, mas que nada cuando es POST o PUT
            }
            catch (Exception $e) {
                $this->body = null; // Si hay algun error, el body esta vacio
            }
            
            $this->query = (object) $_GET; // Obtiene los parametros y los convierte en un objeto
        }
    }
