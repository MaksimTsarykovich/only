<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Forms\User\RegisterForm;
use Src\Controller\AbstractController;
use Src\Http\Response;

class RegisterController extends AbstractController
{

    public function form()
    {
        return $this->render(VIEWS_PATH . '/form/register.php');
    }

    public function register(): Response
    {
        $form = new RegisterForm();
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('phone'),
            $this->request->input('password'),
            $this->request->input('passwordConfirm'),
            $this->request->input('name')
        );
        $user = $form->save();

        dd($user);

        return $this->render(VIEWS_PATH . '/form/register.php');
    }
}