<?php

declare(strict_types=1);

namespace Config;

use Src\Database\Database;
use Src\Database\EntityService;
use Src\Http\Kernel;
use Src\Http\Request;
use Src\Http\Response;
use Src\Routing\Router;
use Src\Session\Session;

class App
{
    private static ?App $instance = null;
    private Kernel $kernel;
    private Request $request;
    private Database $db;

    private EntityService $entityService;


    private function __construct(
        private array $config,
    )
    {
        $this->db = new Database($this->config['database']  ?? []);

        $this->request = Request::createFromGlobals();

        $this->request->setSession(Session::start());

        $router = new Router();

        $router->addRoutes($this->config['routes'] ?? []);

        $this->kernel = new Kernel($router);

        $this->entityService = new EntityService($this->db);

    }

    public static function getInstance(array $config = []): self
    {
        if (static::$instance === null) {
            static::$instance = new static($config);
        }

        return static::$instance;
    }

    public function run(): Response
    {
        $response = $this->kernel->handle($this->request);
        $response->send();

         $this->kernel->terminate($this->request, $response);

        return $response;
    }

    public static function getDatabase(): Database
    {
        return static::getInstance()->db;
    }
    public function getKernel(): Kernel
    {
        return $this->kernel;
    }

}