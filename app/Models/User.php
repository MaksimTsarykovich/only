<?php

declare(strict_types=1);

namespace App\Models;

use Src\Model\AbstractModel;

class User extends AbstractModel
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private string  $email,
        private string  $phone,
        private string  $password_hash,
    )
    {
    }

    public static function create(
        string  $email,
        string  $phone,
        string  $password_hash,
        ?string $name = null,
        ?int    $id = null,
    ): static
    {
        return new static($id, $name, $email, $phone, $password_hash);
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}