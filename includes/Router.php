<?php
class Router {
    private $routes = [];
    private $notFoundCallback;

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function setNotFound($callback) {
        $this->notFoundCallback = $callback;
    }

    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Supprimer le préfixe du chemin de base
        $basePath = '/digita-marketing';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Si l'URI est vide ou '/', utiliser '/'
        $uri = $uri ?: '/';

        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            return call_user_func($callback);
        }

        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }

        header("HTTP/1.0 404 Not Found");
        return "Page non trouvée";
    }
}
