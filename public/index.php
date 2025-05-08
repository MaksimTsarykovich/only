<?php

use Src\Http\Kernel;
use Src\Http\Request;
use Src\Http\Router;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$router = new Router();

$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);

var_dump($request);