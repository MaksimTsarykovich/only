<?php

declare(strict_types=1);

use Config\App;
use Config\Config;

define('BASE_PATH', dirname(__DIR__));
const VIEWS_PATH = BASE_PATH . '/resources/views';

require BASE_PATH . '/vendor/autoload.php';


$app = App::getInstance(Config::getRoutes());

$app->run();