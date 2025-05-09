<?php

declare(strict_types=1);

namespace App\Forms\User;


use App\Models\User;

class RegisterForm
{

    private ?string $name;

    private string $email;

    private string $phone;

    private string $password;

    private string $passwordConfirmation;


    public function setFields(string $email, string $phone, string $password, string $passwordConfirmation, ?string $name = null): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    public function save(): User
    {
        $user = User::create(
            $this->email,
            $this->phone,
            password_hash($this->password, PASSWORD_DEFAULT),
            $this->name
        );

        return $user;
    }

    public function getValidationErrors(): array
    {
        $error = [];

        if (!empty($this->name) && strlen($this->name) > 50) {
            $error[] = 'Максимальная длинна имени 50 символов';
        }

        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $error[] = 'Неверный формат электронной почты';
        }

        if (empty($this->password) || strlen($this->password) < 8) {
            $error[] = 'Минимальная длинна пароля 8 символов';
        }

        if ($this->password !== $this->passwordConfirmation) {
            $error[] = 'Пароли не совпадают';
        }

        return $error;
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->getValidationErrors());
    }


}