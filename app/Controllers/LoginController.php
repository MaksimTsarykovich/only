<?php

namespace App\Controllers;

use App\Services\UserService;
use Config\App;
use Src\Authentication\SessionAuthentication;
use Src\Controller\AbstractController;
use Src\Http\RedirectResponse;
use Src\Http\Response;

class LoginController extends AbstractController
{
    private SessionAuthentication $auth;
    private UserService $userService;


    public function __construct()
    {
        $this->userService = new UserService(App::getDatabase());

    }

    public function form(): Response
    {
        return $this->render(VIEWS_PATH . '/form/login.php');
    }

    public function login()
    {
        $this->setSessionAuthentication();

        $isAuth = $this->auth->authenticate(
            $this->request->input('login'),
            $this->request->input('password')
        );


        if (!$isAuth) {
            $this->request->getSession()->setFlash('error', 'Неверный логин или пароль');

            return new RedirectResponse('/login');
        }

        $this->request->getSession()->setFlash('success', 'Вход выполнен успешно');

        return new RedirectResponse('/dashboard');
    }

    public function logout(): RedirectResponse
    {
        $this->setSessionAuthentication();

        $this->auth->logout();

        return new RedirectResponse('/login');
    }

    private function setSessionAuthentication()
    {
        $this->auth = new SessionAuthentication(
            $this->userService,
            $this->request->getSession()
        );
    }

}