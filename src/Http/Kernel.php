<?php

declare(strict_types=1);

namespace Src\Http;

use Src\Http\Exceptions\RouteNotFoundException;
use Src\Routing\Router;

class Kernel
{
    public function __construct(
        private Router $router,
    )
    {
    }

    public function handle(Request $request): Response
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

    public function terminate(Request $request):void
    {
        $request->getSession()?->clearFlash();
    }

    private function createExceptionResponse(\Throwable $e): Response
    {

        if ($e instanceof RouteNotFoundException) {
            $e->setStatusCode(404);
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('Server Error', 500);
    }

}