<?php

namespace App\Services;

class Route
{
    private static $routes = [];
    public static $controllerNamespace = 'App\Controllers\\';
    public static function add(string $uri, string $controller, string $action, string $method = 'GET', array $middleware = [])
    {
        self::$routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
            'middleware' => $middleware
        ];
    }


    public static function get(string $uri, string $controller, string $action, array $middleware = [])
    {
        self::add($uri, $controller, $action, 'GET', $middleware);
    }

    public static function post(string $uri, string $controller, string $action, array $middleware = [])
    {
        self::add($uri, $controller, $action, 'POST', $middleware);
    }


    public static function handle()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            if ('/' . $route['uri'] === $requestUri && $route['method'] === $requestMethod) {
                
                // hanlde middleware
                foreach ($route['middleware'] as $middleware) {
                    $middlewareInstance = new $middleware();
                    $middlewareInstance->handle();
                }

                $controllerClass = self::$controllerNamespace . $route['controller'];
                $action = $route['action'];

                $controller = new $controllerClass();
                $controller->$action();
                return;
            }
        }
        echo '404 - page not found';
    }
}
