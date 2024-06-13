<?php

namespace App\Lib;

use PDO;

class DatabaseConnection
{
    private $pdo;

    public function __construct(DatabaseConfig $config)
    {
        $this->pdo = new PDO(
            $config->getDsn(),
            $config->getUser(),
            $config->getPassword()
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}