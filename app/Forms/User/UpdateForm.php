<?php

declare(strict_types=1);

namespace App\Forms\User;

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