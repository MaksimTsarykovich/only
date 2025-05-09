<?php

declare(strict_types=1);

namespace App\Controllers;


use Config\App;
use PDO;
use Src\Controller\AbstractController;
use Src\Http\Response;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render(VIEWS_PATH.'/register.php');
    }

    public function db()
    {
        $db = App::db();
        dd($db->getAttribute(PDO::ATTR_CONNECTION_STATUS));
        return new Response('This method show');
    }
}