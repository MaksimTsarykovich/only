<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Forms\User\UpdateForm;
use App\Forms\Validation\ValidatorUpdateForm;
use App\Services\UserService;
use Config\App;
use Src\Authentication\SessionAuthentication;
use Src\Controller\AbstractController;
use Src\Http\RedirectResponse;
use Src\Session\Session;

class UpdateController extends AbstractController
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

        $user = $this->findUserById();

        return $this->render(
            VIEWS_PATH . '/form/update.php',
            [
                'name' => $user->getName(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail(),
            ]
        );
    }

    public function update()
    {
        $form = new UpdateForm(
            $this->userService,
            new ValidatorUpdateForm($this->userService)
        );
        $userId  = (int)$this->findUserById()->getId();
        $form->setFields(
            $this->request->input('email'),
            $this->request->input('phone'),
            $this->request->input('password'),
            $this->request->input('passwordConfirm'),
            $this->request->input('name'),
            $userId
        );

        if($form->hasUpdateErrors()){
            foreach($form->getUpdateErrors() as $error){
                $this->request->getSession()->setFlash('error', $error);
            }
            return new RedirectResponse('/profile');
        }

        if ($form->update()) {
           $this->request->getSession()->setFlash('success',"Данные профиля успешно обновлены");
       }


        return $this->render(
        VIEWS_PATH . '/form/update.php',
        [
            'name' => $form->getName(),
            'phone' => $form->getPhone(),
            'email' => $form->getEmail(),
        ]
    );

    }

    private function findUserById()
    {
        return $this->userService->findByField(
            'id',
            $this->request->getSession()->get(Session::AUTH_KEY)
        );
    }

}