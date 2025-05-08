<?php

declare(strict_types=1);

namespace Routing;

class Route
{
    public static function get($uri, $handler): array
    {
        return ['GET', $uri, $handler];
    }

    public static function post($uri, $handler): array
    {
        return ['POST', $uri, $handler];
    }
}