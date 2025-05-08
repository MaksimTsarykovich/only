<?php

declare(strict_types=1);

namespace Src\Http;

use Http\Request;

class Router
{
    private array $routes = [];

    public function addRoute(array $route): void
    {
        $this->routes[] = $route;
    }

    public function addRoutes(array $routes): void
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    public function dispatch(Request $request): mixed
    {
        $uri = $request->getPath();
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            [$routeMethod, $routeUri, $controller] = $route;

            if ($routeMethod !== $method && $routeUri !== $uri) {
                continue;
            }

            $handler = [$controller, $routeMethod];

            return $handler;
        }

        return $this->handleNotFound();
    }

    private function executeHandler(array $handler, array $params = []): mixed
    {
        [$controller, $method] = $handler;

        $controllerInstance = new $controller();

        return call_user_func_array([$controllerInstance, $method], $params);
    }

    private function handleNotFound(): mixed
    {
        header("HTTP/1.0 404 Not Found");
        return "404 Not Found";
    }
}