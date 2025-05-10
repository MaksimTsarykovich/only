<?php

namespace App\Services;

use App\Models\User;
use Config\App;
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

        $userId =(int) $this->db->lastInsertId();

        return $userId;
    }
    
}