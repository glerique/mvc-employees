<?php

namespace App\Lib;

use PDO;
class QueryBuilder
{
    protected $pdo;

    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->pdo = $dbConnection->getPdo();
    }

    public function executeQuery($sql, $params = [])
    {
        $query = $this->pdo->prepare($sql);
        $this->bindParams($query, $params);
        $query->execute();
        return $query;
    }

    public function bindParams($query, $params)
    {
        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $query->bindValue($key, $value, $paramType);
        }
    }

    public function executeFetch($sql, $params = [], $class = null)
    {
        $query = $this->executeQuery($sql, $params);
        if ($class) {
            $query->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        return $query->fetch();
    }

    public function executeFetchAll($sql, $params = [], $class = null)
    {
        $query = $this->executeQuery($sql, $params);
        if ($class) {
            $query->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        return $query->fetchAll();
    }
}
