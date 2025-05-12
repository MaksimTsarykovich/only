<?php

declare(strict_types=1);

namespace Src\Routing;

use Src\Http\Exceptions\RouteNotFoundException;
use Src\Http\Request;

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

            if ($routeMethod !== $method || $routeUri !== $uri) {
                continue;
            }

            $handler = [$controller, $routeMethod];

            return $handler;
        }

        throw new RouteNotFoundException();
    }

    private function handleNotFound(): mixed
    {
        header("HTTP/1.0 404 Not Found");
        return "404 Not Found";
    }
}