<?php

namespace Src\Http;

use Src\Helpers\Dump;
use Src\Http\Router;

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
            Dump::dd($routeHandler);

            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $e) {
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $e)
    {
        if (in_array($this->appEnv, ['local', 'testing'])) {
            throw $e;
        }
        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('Server Error', 500);
    }

}