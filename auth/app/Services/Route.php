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


    public static function handle()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            if ('/' . $route['uri'] === $requestUri && $route['method'] === $requestMethod) {
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
