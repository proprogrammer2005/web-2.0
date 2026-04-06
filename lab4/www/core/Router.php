<?php
class Router {
    private $routes = [];

    public function add($path, $controller, $method) {
        $this->routes[$path] = ['controller' => $controller, 'method' => $method];
    }

    public function run() {
        $url = isset($_GET['url']) ? '/' . rtrim($_GET['url'], '/') : '/';
        
        $url = explode('?', $url)[0];

        if (array_key_exists($url, $this->routes)) {
            $controllerName = $this->routes[$url]['controller'];
            $methodName = $this->routes[$url]['method'];
            
            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            echo "<h1>404 - Страница не найдена</h1>";
        }
    }
}
?>