<?php

namespace App\Lib;

use PDO;
use PDOException;

class Database
{
    private $pdo;   

    public function __construct()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                    
		    $this->pdo->exec("SET NAMES utf8");
        } catch (PDOException $e) {            
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}