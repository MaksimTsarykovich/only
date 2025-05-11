<?php

namespace App\Services;

use App\Models\User;
use Config\App;
use PDO;
use Src\Database\Database;
use Src\Database\EntityService;

class UserService extends EntityService
{

    public function store(User $user)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO `users` (`name`, `phone`, `email`, `password`) VALUES (:name,:phone, :email, :password)"
        );

        $stmt->execute([
            ":name" => $user->getName(),
            ":phone" => $user->getPhone(),
            ":email" => $user->getEmail(),
            ":password" => $user->getPasswordHash()
        ]);

        $userId = (int)$this->db->lastInsertId();

        return $userId;
    }

    public function update(int $userId, string $name, string $email, string $phone, ?string $password = null )
    {

        $sql = "UPDATE `users` SET 
            `name` = :name,
            `email` = :email,
            `phone` = :phone";

        $params = [
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':id' => $userId
        ];

        if ($password !== null) {
            $sql .= ", `password` = :password";
            $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE `id` = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function isFieldExist(string $fieldName, string $value) : bool
    {
        $stmt = $this->db
            ->prepare("SELECT COUNT(*) FROM `users` WHERE `{$fieldName}` = :value");

        $stmt->execute([":value" => $value]);

        return $stmt->fetchColumn()== 0;
    }

    public function isFieldUniqueExcept(string $fieldName, string $value, string $excludeId): bool
    {
        $stmt = $this->db
            ->prepare("SELECT COUNT(*) FROM `users` WHERE `{$fieldName}` = :value AND `id` != :excludeId");
         $stmt->execute([
            ":value" => $value,
            ":excludeId" => $excludeId
        ]);

        return $stmt->fetchColumn() == 0;
    }

    public function findByField(string $field, mixed $value): ?User
    {
        $stmt = $this->db
            ->prepare("SELECT * FROM `users` WHERE {$field} = :value");

        $stmt->execute([":value" => $value]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return User::create(
            email: $user['email'],
            phone: $user['phone'],
            password_hash: $user['password'],
            name: $user['name'],
            id: $user['id']
        );
    }



}