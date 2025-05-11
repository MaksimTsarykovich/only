<?php

namespace App\Forms\Validation;

use App\Services\UserService;

class ValidatorForm
{
    protected array $validationErrors ;

    public function __construct(
        protected UserService $userService
    )
    {
    }

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

    protected function isValidName($name): void
    {
        if (!empty($name) && mb_strlen($name) > 50) {
            $this->validationErrors[] = 'Максимальная длина имени 50 символов';
        }
    }

    protected function isValidEmail(string $email): void
    {
        if (empty($email)) {
            $this->validationErrors[] = 'Email обязателен для заполнения';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors[] = 'Неверный формат электронной почты';
        } elseif (!$this->userService->isFieldExist('email', $email)) {
            $this->validationErrors[] = 'Пользователь с таким email уже существует';
        }
    }



    protected function isValidPhone(string $phone): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        if (empty($phone)) {
            $this->validationErrors[] = 'Номер телефона обязателен для заполнения';
        } elseif (!strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 15) {
            $this->validationErrors[] = 'Неверный формат номера телефона';
        }
    }

    protected function isValidPassword(string $password, string $passwordConfirmation): void
    {
        if (empty($password)) {
            $this->validationErrors[] = 'Пароль обязателен для заполнения';
        } elseif (strlen($password) < 8) {
            $this->validationErrors[] = 'Минимальная длина пароля 8 символов';
        } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $this->validationErrors[] = 'Пароль должен содержать буквы и цифры';
        }

        if ($password !== $passwordConfirmation && $passwordConfirmation !== null) {
            $this->validationErrors[] = 'Пароли не совпадают';
        }

    }

    protected function isUniquePhone(string $phone): void
    {
        if (!$this->userService->isFieldExist('phone', $phone)) {
            $this->validationErrors[] = 'Пользователь с таким номером телефона уже существует';
        }
    }

    protected function isUniqueEmail(string $email): void
    {
        if (!$this->userService->isFieldExist('phone', $email)) {
            $this->validationErrors[] = 'Пользователь с таким email уже существует';
        }
    }

    public function hasValidationErrors(string $name,
                string $email,
                string $phone,
                string $password,
                string $passwordConfirmation): bool
    {
        return !empty($this->getValidationErrors(
            $email,
            $phone,
            $password,
            $passwordConfirmation,
            $name));
    }

    public function setValidationErrors(array $validationErrors): void
    {
        $this->validationErrors = $validationErrors;
    }

}