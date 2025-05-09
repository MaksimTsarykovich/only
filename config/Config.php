<?php

declare(strict_types=1);

namespace Config;

class Config
{
    protected array $config;


    public function __construct()
    {
        $this->config = [
            'db' => [
                'host' => 'db',
                'username' => 'user',
                'password' => 'password',
                'database' => 'app',
                'driver' => 'mysql',
            ],
        ];
    }


    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}