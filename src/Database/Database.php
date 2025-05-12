<?php

declare(strict_types=1);

namespace Src\Database;

use Config\Config;
use PDO;
use PDOException;

class Database
{
    private PDO $pdo;


    public function __construct()

    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO(
                $this->generateDsn(),
                Config::DB_USERNAME,
                Config::DB_PASSWORD,
                 $defaultOptions
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


    private function generateDsn(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s',
            Config::DB_DRIVER, Config::DB_HOST, Config::DB_DATABASE);
    }
}