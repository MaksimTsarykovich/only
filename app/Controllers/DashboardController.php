<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Forms\User\UpdateForm;
use App\Services\UserService;
use Config\App;
use Src\Authentication\SessionAuthentication;
use Src\Controller\AbstractController;
use Src\Http\RedirectResponse;
use Src\Session\Session;

class DashboardController extends AbstractController
{

    private SessionAuthentication $auth;
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService(App::getDatabase());
    }

    public function index()
    {
        $this->auth = new SessionAuthentication(
            $this->userService,
            $this->request->getSession()
        );

        if (!$this->auth->check()) {
            $this->request
                ->getSession()
                ->setFlash('error', 'Чтобы продолжить, нужно войти');
            return new RedirectResponse('/login');
        }

        $user = $this->userService->findByField(
            'id',
            $this->request->getSession()->get(Session::AUTH_KEY)
        );

        return $this->render(
            VIEWS_PATH . '/dashboard.php',
            [
                'name' => $user->getName(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail(),
            ]
        );
    }

    public function update()
    {
        $form = new UpdateForm($this->userService);
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('phone'),
            $this->request->input('password'),
            $this->request->input('passwordConfirm'),
            $this->request->input('name')
        );



    return $this->render(
        VIEWS_PATH . '/dashboard.php',
        [
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
        ]
    );
    }
}