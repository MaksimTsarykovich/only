<?php

declare(strict_types=1);

namespace Src\Controller;

use Src\Http\Request;
use Src\Http\Response;

abstract class AbstractController
{
    protected ?Request $request = null;

    public function render(string $view, array $parameters = [], Response $response = null): Response
    {
        ob_start();

        include $view;

        $content = ob_get_clean();

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }

    public function setRequest(?Request $request): void
    {
        $this->request = $request;
    }

}