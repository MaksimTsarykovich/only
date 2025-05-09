<?php

declare(strict_types=1);


use Config\App;

define('BASE_PATH', dirname(__DIR__));
const VIEWS_PATH = BASE_PATH . '/resources/views';

require BASE_PATH . '/vendor/autoload.php';


$config = [
    'database' => require BASE_PATH . '/config/database.php',
    'routes' => require BASE_PATH . '/routes/web.php',
];

$app = App::getInstance($config);

$app->run();