<?php

declare(strict_types=1);

namespace Src\Database;

use PDO;

class Database
{
    private PDO $pdo;


    public function __construct(array $config)

    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO(
                $this->generateDsn($config),
                $config['username'],
                $config['password'],
                $config['options'] ?? $defaultOptions
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(),
                (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }


    private function generateDsn(array $config): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s',
            $config['driver'], $config['host'], $config['database']);
    }
}