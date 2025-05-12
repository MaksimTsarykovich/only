<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Forms\User\RegisterForm;
use App\Forms\Validation\ValidatorForm;
use App\Services\UserService;
use Config\App;
use Src\Authentication\SessionAuthentication;
use Src\Controller\AbstractController;
use Src\Http\RedirectResponse;
use Src\Http\Response;

class RegisterController extends AbstractController
{

    private SessionAuthentication $auth;

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService(App::getDatabase());
    }

    public function form()
    {
        return $this->render(VIEWS_PATH . '/form/register.php');
    }

    public function register(): Response
    {
        $this->auth = new SessionAuthentication(
            $this->userService,
            $this->request->getSession()
        );

        $form = new RegisterForm(
            $this->userService,
            new ValidatorForm($this->userService)
        );
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('phone'),
            $this->request->input('password'),
            $this->request->input('passwordConfirm'),
            $this->request->input('name')
        );

        if($form->hasValidationErrors()){
            foreach($form->getErrors() as $error){
                $this->request->getSession()->setFlash('error', $error);
            }
            return new RedirectResponse('/register');
        }

        $user = $form->save();

        $this->request->getSession()->setFlash('success',"Пользователь {$user->getEmail()} успешно зарегестрирован");

        $this->auth->login($user);

        return new RedirectResponse('/profile');
    }
}