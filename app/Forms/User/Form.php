<?php

namespace App\Forms\User;

use App\Forms\Validation\ValidatorForm;
use App\Forms\Validation\ValidatorInterface;
use App\Services\UserService;

class Form
{
    protected ?int $userId;

    protected ?string $name;



    protected string $email;

    protected string $phone;

    protected string $password;

    protected string $passwordConfirmation;




    public function __construct(
        protected UserService $userService,
        protected ValidatorInterface $validator,
    )
    {

    }


    public function setFields(string $email, string $phone, string $password, string $passwordConfirmation, ?string $name = null, ?int $userId = null): void
    {
        $this->validator->setValidationErrors([]);

        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->userId = $userId;
    }

    public function getErrors(): array
    {
        return $this->validator
            ->getValidationErrors(
                $this->email,
                $this->phone,
                $this->password,
                $this->passwordConfirmation,
                $this->name
            );
    }

    public function hasValidationErrors(): bool
    {
        return $this->validator->hasValidationErrors($this->name,
            $this->email,
            $this->phone,
            $this->password,
            $this->passwordConfirmation);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}