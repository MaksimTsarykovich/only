<?php

declare(strict_types=1);

namespace Config;

class Config
{
    public const YANDEX_SITE_KEY = 'ysc1_aLnsFqR0IVvstUVt9tcakLLHZWcPjXFJgS78yK8Kc699e978';
    public const YANDEX_SERVER_KEY = 'ysc2_aLnsFqR0IVvstUVt9tcaSI3ezQ2cbr8P4RquhJgU08171724';

    public const DB_HOST = 'db';
    public const DB_USERNAME = 'user';
    public const DB_PASSWORD = 'password';
    public const DB_DATABASE = 'app';
    public const DB_DRIVER = 'mysql';

    public static function getRoutes(): array
    {
        return [
            'routes' => require BASE_PATH . '/routes/web.php',
        ];
    }
}