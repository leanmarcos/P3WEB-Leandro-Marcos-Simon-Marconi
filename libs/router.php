<?php

require_once 'libs/request.php'; // Se comunica con request (toma el pedido del cliente y lo decodifica)
require_once 'libs/response.php'; // Se comunica con response (envia la respesuta al cliente)

class Route
{
    private $url; // la url de la peticion
    private $verb; // el verbo (GET, POST, PUT, DELETE, etc)
    private $controller; // A cual controller se dirije
    private $method; // A cual metodo de ese controller se dirije
    private $params; // Los parametros (tareas/7)

    // Conecta a todas las variables con sus $this->
    public function __construct($url, $verb, $controller, $method)
    {
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = [];
    }

    // Match:
    public function match($url, $verb)
    {
        if ($this->verb != $verb) {
            return false; // Si el verbo es diferente a su $this-> entonces corta
        }
        $partsURL = explode("/", trim($url, '/')); // Explota la url (tareas/1 = ['tares' , 1])
        $partsRoute = explode("/", trim($this->url, '/')); // Explota el this-> de la url (tareas/1 = ['tares' , 1])

        if (count($partsRoute) != count($partsURL)) { // Si dan diferente cantidad (en una hay mas parametros) 
            return false; // Corta
        }

        foreach ($partsRoute as $key => $part) {  // Recorre cada parametro de la peticion
            if ($part[0] != ":") {  // Si no es un parametro (tareas/hola)
                if ($part != $partsURL[$key])
                    return false; // Chequea que sea exactamente igual, si no corta
            } else {
                $this->params['' . substr($part, 1)] = $partsURL[$key]; // Si encuentra un parametro lo guarda
            }

        }
        return true; // Devuelve verdadero (son iguales)
    }


    public function run($request, $response)
    {
        $controller = $this->controller; // Guarda el controller 
        $method = $this->method; // Guarda el metodo
        $request->params = (object) $this->params; // Guarda los parametros como objeto

        (new $controller())->$method($request, $response); // Le manda al metodo en el controller request y response
    }
}

// Router se encarga de almacenar las rutas
class Router
{

    // Define variables
    private $routeTable = []; 
    private $middlewares = [];
    private $defaultRoute;
    private $request;
    private $response;

    public function __construct()
    {
        $this->defaultRoute = null; // La ruta por defecto empieza siendo nula
        $this->request = new Request(); // Recibe Request
        $this->response = new Response(); // Recibe Response
    }

    // Busca a la ruta que coincida con la peticion
    public function route($url, $verb)
    {
        // Ejecuta todos los middleware, pasando request y response
        foreach ($this->middlewares as $middleware) {
            $middleware->run($this->request, $this->response);
        }

        //$ruta->url //no compila!
        foreach ($this->routeTable as $route) {
            if ($route->match($url, $verb)) { // Si todos los componentes de la tabla estan iguales en verbo y url
                $route->run($this->request, $this->response); // Ejecuta
                return; // Corta
            }
        }



        //Si ninguna ruta coincide con el pedido y se configuró ruta por defecto.
        if ($this->defaultRoute != null) {
            $this->defaultRoute->run($this->request, $this->response);
        }
    }

    // Añadir un nuevo middleware
    public function addMiddleware($middleware)
    {
        $this->middlewares[] = $middleware;
    }

    // Añadir un nueva direccion de router
    public function addRoute($url, $verb, $controller, $method)
    {
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }

    // Añadir una nueva direccion de default
    public function setDefaultRoute($controller, $method)
    {
        $this->defaultRoute = new Route("", "", $controller, $method);
    }
}
