<?php
class Router {
    private $routes = [];
    private $notFoundCallback;

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function setNotFound($callback) {
        $this->notFoundCallback = $callback;
    }

    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Supprimer le préfixe du chemin de base si présent
        $basePath = '/digita-marketing';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Si l'URI est vide ou '/', utiliser '/'
        $uri = $uri ?: '/';

        // Vérifier d'abord les routes exactes
        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            return call_user_func($callback);
        }

        // Vérifier les routes avec paramètres dynamiques
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $callback) {
                // Convertir :param en regex
                $pattern = preg_replace('/:\w+/', '([^/]+)', $route);
                $pattern = '#^' . $pattern . '$#';
                
                if (preg_match($pattern, $uri, $matches)) {
                    // Supprimer le premier élément (match complet)
                    array_shift($matches);
                    // Appeler le callback avec les paramètres
                    return call_user_func_array($callback, $matches);
                }
            }
        }

        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }

        header("HTTP/1.0 404 Not Found");
        return "Page non trouvée";
    }
}
