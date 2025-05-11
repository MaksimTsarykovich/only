<?php

namespace App\Forms\Validation;

use App\Forms\Validation\ValidatorForm;

class ValidatorUpdateForm extends ValidatorForm
{
    public function getValidationErrors(
        string $email,
        string $phone,
        string $password,
        string $passwordConfirmation,
        ?string $name= null,
    ): array
    {
        $this->validationErrors = [];

        $this->isValidName($name);
        $this->isValidEmail($email);
        $this->isUniqueEmail($email);
        $this->isValidPhone($phone);
        $this->isUniquePhone($phone);
        $this->isValidPassword($password, $passwordConfirmation);

        return $this->validationErrors;
    }
}