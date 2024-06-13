<?php

namespace App\Model;

use App\Lib\QueryBuilder;
use PDO;

abstract class Model implements ModelInterface
{
    protected $table;
    protected $class;
    protected $relationManager;
    protected $relationEntity;
    protected $relationProperty;
    protected $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {        
        $this->queryBuilder = $queryBuilder;
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) FROM $this->table";
        $query = $this->queryBuilder->executeQuery($sql);
        return $query->fetchColumn();
    }

    public function findAll()
    {
        $sql = "SELECT * FROM $this->table";
        $entities = $this->queryBuilder->executeFetchAll($sql, [], $this->class);
        $this->injectRelationFields($entities);
        return $entities;
    }

    public function paginateFindAll($currentPage, $perPage)
    {
        $first = ($currentPage * $perPage) - $perPage;
        $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT :first, :perPage";
        $entities = $this->queryBuilder->executeFetchAll($sql, [':first' => $first, ':perPage' => $perPage], $this->class);
        $this->injectRelationFields($entities);
        return $entities;
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $entity = $this->queryBuilder->executeFetch($sql, ['id' => $id], $this->class);
        $this->injectRelationField($entity);
        return $entity;
    }

    protected function injectRelationFields($entities)
    {
        foreach ($entities as $entity) {
            $this->injectRelationField($entity);
        }
    }

    protected function injectRelationField($entity)
    {
        if (property_exists($this->class, $this->relationProperty)) {
            $model = new $this->relationManager($this->queryBuilder);
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
        $this->queryBuilder->executeQuery($sql, $data);
    }

    public function update($entity)
    {
        $data = $this->getEntityData($entity);
        $fields = implode(',', array_map(fn($column) => "$column = :$column", array_keys($data)));

        $sql = "UPDATE $this->table SET $fields WHERE id = :id";
        $this->queryBuilder->executeQuery($sql, $data);
    }

    abstract protected function getEntityData($entity): array;

    public function deleteById($entity)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $this->queryBuilder->executeQuery($sql, ['id' => $entity->getId()]);
    }
}