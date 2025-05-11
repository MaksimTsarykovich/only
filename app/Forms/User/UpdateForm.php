<?php

namespace App\Forms\User;

use App\Forms\Validation\ValidatorForm;
use App\Forms\Validation\ValidatorUpdateForm;
use App\Models\User;
use App\Services\UserService;

class UpdateForm extends Form
{

    public function getUpdateErrors()
    {
        return $this->validator
            ->getErrors();
    }

    public function hasUpdateErrors(): bool
    {
        return $this->validator->hasValidationUpdateErrors(
            $this->name,
            $this->email,
            $this->phone,
            $this->password,
            $this->passwordConfirmation,
            $this->userId
        );
    }

    public function update()
    {
        return $this->userService->update(
            $this->userId,
            $this->name,
            $this->email,
            $this->phone,
            $this->password,
        );
    }
}