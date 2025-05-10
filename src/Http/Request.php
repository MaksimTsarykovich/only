<?php

declare(strict_types=1);

namespace Src\Http;

use Src\Session\Session;

class Request
{
    private Session $session;

    public function __construct(
        private readonly array $getParams,
        private readonly array $postData,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server,
    ) {}

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getPath(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getRouteArgs()
    {
        return $this->server;
    }

    public function input(string $key, mixed $default = null)
    {
        return $this->postData[$key] ?? $default;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

}