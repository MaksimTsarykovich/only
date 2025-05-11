<?php

namespace App\Forms\User;

use App\Forms\Validation\ValidatorForm;
use App\Models\User;
use App\Services\UserService;

class UpdateForm extends Form
{


    public function getUpdatableFields(User $user)
    {
        $updatableFields = [];

        if ($this->name !== $user->getName()) {
            $updatableFields [] = $this->name;
        }
        if ($this->email !== $user->getEmail()) {
            $updatableFields [] = $this->email;
        }
        if ($this->phone !== $user->getPhone()) {
            $updatableFields [] = $this->phone;
        }
        if (!empty($this->password)) {
            $updatableFields [] = $this->password;
        }

        return $updatableFields;
    }


    public function update(User $user): bool
    {
        $this->getUpdatableFields($user);
        return $this->userService->update(
            $userId,
            $this->name,
            $this->email,
            $this->phone,
            $this->password);

    }

    public function getUpdateErrors()
    {
        $this->validator->getUpdateValidationErrors();

    }


}