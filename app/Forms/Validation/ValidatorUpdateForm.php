<?php

declare(strict_types=1);

namespace App\Forms\Validation;


class ValidatorUpdateForm extends ValidatorForm implements ValidatorInterface


{
    public function getValidationUpdateErrors(
        string  $email,
        string  $phone,
        string  $password,
        string  $passwordConfirmation,
        string     $userId ,
        ?string $name = null,
    ): array
    {
        $this->validationErrors = [];

        $this->isValidName($name);
        $this->isValidEmail($email);
        $this->isUniqueEmailExcept($email, $userId);
        $this->isValidPhone($phone);
        $this->isUniquePhoneExcept($phone, $userId);
        $this->isValidPassword($password, $passwordConfirmation);
        return $this->validationErrors;
    }

    public function getErrors()
    {
        return $this->validationErrors;
    }

    protected function isUniqueEmailExcept(string $email, string $userId): void
    {
        if (!$this->userService->isFieldUniqueExcept('email', $email, $userId)) {
            $this->validationErrors[] = 'Пользователь с таким email уже существует';
        }
    }

    protected function isUniquePhoneExcept(string $phone, string $userId): void
    {
        if (!$this->userService->isFieldUniqueExcept('phone', $phone, $userId)) {
            $this->validationErrors[] = 'Пользователь с таким номером телефона уже существует';
        }
    }

    public function hasValidationUpdateErrors(
        string $name,
        string $email,
        string $phone,
        string $password,
        string $passwordConfirmation,
        int $userId
    ): bool
    {
        return !empty($this->getValidationUpdateErrors(
            $email,
            $phone,
            $password,
            $passwordConfirmation,
            $userId,
            $name,
        ));
    }
}