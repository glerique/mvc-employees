<?php

namespace App\Model;

use PDO;

class Model
{
    protected $db;
    protected $pdo;
    protected $table;
    protected $class;
    protected $relationManager;
    protected $relationEntity;
    protected $relationProperty;

    public function __construct($db)
    {
        $this->db = $db;
        $this->pdo = $this->db->getPdo();
    }

    protected function executeQuery($sql, $params = [])
    {
        $query = $this->pdo->prepare($sql);
        $this->bindParams($query, $params);
        $query->execute();
        return $query;
    }

    protected function bindParams($query, $params)
    {
        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $query->bindValue($key, $value, $paramType);
        }
    }

    protected function executeFetch($sql, $params = [])
    {
        $query = $this->executeQuery($sql, $params);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        return $query->fetch();
    }

    protected function executeFetchAll($sql, $params = [])
    {
        $query = $this->executeQuery($sql, $params);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        return $query->fetchAll();
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) FROM $this->table";
        $query = $this->executeQuery($sql);
        return $query->fetchColumn();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM $this->table";
        $entities = $this->executeFetchAll($sql);
        $this->injectRelationFields($entities);
        return $entities;
    }

    public function PaginateFindAll($currentPage, $perPage)
    {
        $first = ($currentPage * $perPage) - $perPage;
        $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT :first, :perPage";
        $entities = $this->executeFetchAll($sql, [':first' => $first, ':perPage' => $perPage]);
        $this->injectRelationFields($entities);
        return $entities;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $entity = $this->executeFetch($sql, ['id' => $id]);
        $this->injectRelationField($entity);
        return $entity;
    }

    public function injectRelationFields($entities)
    {
        foreach ($entities as $entity) {
            $this->injectRelationField($entity);
        }
    }

    public function injectRelationField($entity)
    {
        if (property_exists($this->class, $this->relationProperty)) {
            $model = new $this->relationManager($this->db);
            $getRelationId = 'get' . ucfirst($this->relationProperty);
            $setter = 'set' . $this->relationEntity;
            $entity->$setter($model->findById($entity->$getRelationId()));
        }
    }

    public function add($entity)
    {
        $data = $this->getEntityData($entity);
        $columns = implode(',', array_keys($data));
        $values = ':' . implode(',:', array_keys($data));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
        $this->executeQuery($sql, $data);
    }

    public function update($entity)
    {
        $data = $this->getEntityData($entity);
        $fields = implode(',', array_map(fn ($column) => "$column = :$column", array_keys($data)));

        $sql = "UPDATE $this->table SET $fields WHERE id = :id";
        $this->executeQuery($sql, $data);
    }

    public function getEntityData(Object $entity): array
    {
        // Implement this method according to your entity structure
        return [];
    }

    public function deleteById(Object $entity)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $this->executeQuery($sql, ['id' => $entity->getId()]);
    }
}
