<?php

namespace App\Model;

use PDO;

class Bdd

{
    private static $db;

    public static function dbConnect()
    {


        $params = [
            'host' => 'localhost',
            'dbname' => 'employees',
            'username' => 'admin',
            'password' => 'test'
        ];

        if (self::$db === null) {

            $dsn = "mysql:host={$params['host']}; dbname={$params['dbname']}";

            $db = new PDO($dsn, $params['username'], $params['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
}
