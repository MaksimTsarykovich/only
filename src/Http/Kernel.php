<?php

declare(strict_types=1);

namespace Src\Http;

use Src\Http\Exceptions\HttpException;
use Src\Routing\Router;

class Kernel
{
    public function __construct(
        private Router $router,
    )
    {
    }

    public function handle(Request $request)
    {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request);
            [$class, $method] = $routeHandler;

            $controller = new $class;

            $controller->setRequest($request);

            $response = $controller->$method($vars);

        } catch (\Exception $e) {
           $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Throwable $e)
    {
        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('Server Error', 500);
    }

}