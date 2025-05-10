<?php

declare(strict_types=1);

namespace App\Forms\User;


use App\Forms\Validation\ValidatorForm;
use App\Models\User;
use App\Services\UserService;

class RegisterForm extends Form
{

    public function save(): User
    {
        $user = User::create(
            $this->email,
            $this->phone,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->name
        );

        $userId = $this->userService->store($user);

        $user->setId($userId);

        return $user;
    }




}