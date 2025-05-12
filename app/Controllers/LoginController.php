<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;
use Config\App;
use Config\Config;
use Src\Authentication\SessionAuthentication;
use Src\Authentication\YandexSmartCaptcha;
use Src\Controller\AbstractController;
use Src\Http\RedirectResponse;
use Src\Http\Response;

class LoginController extends AbstractController
{
    private SessionAuthentication $auth;
    private UserService $userService;

    private YandexSmartCaptcha $captcha;



    public function __construct()
    {
        $this->userService = new UserService(App::getDatabase());
        $this->captcha = new YandexSmartCaptcha(Config::YANDEX_SERVER_KEY);

    }

    public function form(): Response
    {
        return $this->render(VIEWS_PATH . '/form/login.php');
    }

    public function login()
    {
        $this->setSessionAuthentication();

        $captchaToken = $this->request->input('smart-token');
        if (!$this->captcha->verify($captchaToken)) {
            $errorMessage = $this->captcha->getLastError() ?? 'Пожалуйста, подтвердите, что вы не робот';
            $this->request->getSession()->setFlash('error', $errorMessage);
            return new RedirectResponse('/login');
        }

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