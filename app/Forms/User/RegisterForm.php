<?php

declare(strict_types=1);

namespace App\Forms\User;


use App\Models\User;
use App\Services\UserService;

class RegisterForm
{

    private ?string $name;

    private string $email;

    private string $phone;

    private string $password;

    private string $passwordConfirmation;

    private array $validationErrors ;

    public function __construct(
        private UserService $userService
    )
    {
    }


    public function setFields(string $email, string $phone, string $password, string $passwordConfirmation, ?string $name = null): void
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;

        $this->validationErrors = [];
    }

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

    public function getValidationErrors(): array
    {
        // Валидация имени
        $this->isValidName();
        $this->isValidEmail();
        $this->isValidPhone();
        $this->isValidPassword();

        return $this->validationErrors;
    }

    private function isFieldAvailable(string $fieldName, string $value): bool
    {
        $stmt = $this->userService
            ->getDatabaseConnection()
            ->prepare("SELECT COUNT(*) FROM users WHERE {$fieldName} = :value");

        $stmt->execute([":value" => $value]);

        return $stmt->fetchColumn() == 0;
    }

    private function isValidEmail(): void
    {
        if (empty($this->email)) {
            $this->validationErrors[] =  'Email обязателен для заполнения';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors[] =  'Неверный формат электронной почты';
        } elseif (!$this->isFieldAvailable('email', $this->email)) {
            $this->validationErrors[] =  'Пользователь с таким email уже существует';
        }
    }

    private function isValidPhone(): void
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);

        if (empty($this->phone)) {
            $this->validationErrors[] =  'Номер телефона обязателен для заполнения';
        } elseif (!strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 15) {
            $this->validationErrors[] =  'Неверный формат номера телефона';
        } elseif (!$this->isFieldAvailable('phone', $this->phone)) {
            $this->validationErrors[] =  'Пользователь с таким номером телефона уже существует';
        }

    }

    private function isValidPassword(): void
    {
        if (empty($this->password)) {
            $this->validationErrors[] =  'Пароль обязателен для заполнения';
        } elseif (strlen($this->password) < 8) {
            $this->validationErrors[] =  'Минимальная длина пароля 8 символов';
        } elseif (!preg_match('/[A-Za-z]/', $this->password) || !preg_match('/[0-9]/', $this->password)) {
            $this->validationErrors[] =  'Пароль должен содержать буквы и цифры';
        }

        if ($this->password !== $this->passwordConfirmation) {
            $this->validationErrors[] =  'Пароли не совпадают';
        }

    }

    private function isValidName(): void
    {
        if (!empty($this->name) && mb_strlen($this->name) > 50) {
            $this->validationErrors[] =  'Максимальная длина имени 50 символов';
        }
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->getValidationErrors());
    }


}