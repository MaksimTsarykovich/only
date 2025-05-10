<?php

namespace App\Forms\Validation;

use App\Services\UserService;

class ValidatorForm
{
    private array $validationErrors ;

    public function __construct(
        private UserService $userService
    )
    {
    }

    public function getValidationErrors(
        string $email,
        string $phone,
        string $password,
        ?string $name= null,
        ?string $passwordConfirmation = null
    ): array
    {
        $this->isValidName($name);
        $this->isValidEmail($email);
        $this->isValidPhone($phone);
        $this->isValidPassword($password, $passwordConfirmation);

        return $this->validationErrors;
    }

    private function isValidName($name): void
    {
        if (!empty($name) && mb_strlen($name) > 50) {
            $this->validationErrors[] = 'Максимальная длина имени 50 символов';
        }
    }

    private function isValidEmail($email): void
    {
        if (empty($email)) {
            $this->validationErrors[] = 'Email обязателен для заполнения';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors[] = 'Неверный формат электронной почты';
        } elseif (!$this->userService->isFieldExist('email', $email)) {
            $this->validationErrors[] = 'Пользователь с таким email уже существует';
        }
    }

    private function isValidPhone($phone): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        if (empty($phone)) {
            $this->validationErrors[] = 'Номер телефона обязателен для заполнения';
        } elseif (!strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 15) {
            $this->validationErrors[] = 'Неверный формат номера телефона';
        } elseif (!$this->userService->isFieldExist('phone', $phone)) {
            $this->validationErrors[] = 'Пользователь с таким номером телефона уже существует';
        }

    }

    private function isValidPassword($password, $passwordConfirmation): void
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

    public function hasValidationErrors(): bool
    {
        return !empty($this->validationErrors);
    }

    public function setValidationErrors(array $validationErrors): void
    {
        $this->validationErrors = $validationErrors;
    }
}