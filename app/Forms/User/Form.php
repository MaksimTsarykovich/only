<?php

namespace App\Forms\User;

use App\Forms\Validation\ValidatorForm;
use App\Services\UserService;

class Form
{
    protected ?string $name;

    protected string $email;

    protected string $phone;

    protected string $password;

    protected string $passwordConfirmation;

    protected ValidatorForm $validator;

    public function __construct(
        protected UserService $userService
    )
    {
        $this->validator = new ValidatorForm($this->userService);
    }


    public function setFields(string $email, string $phone, string $password, ?string $passwordConfirmation = null, ?string $name = null): void
    {
        $this->validator->setValidationErrors([]);

        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;

        $this->getErrors();
    }

    public function getErrors(): array
    {
        return $this->validator
            ->getValidationErrors(
                $this->name,
                $this->email,
                $this->phone,
                $this->password,
                $this->passwordConfirmation
            );
    }

    public function hasValidationErrors(): bool
    {
        return $this->validator->hasValidationErrors();
    }
}