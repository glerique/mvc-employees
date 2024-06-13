<?php

namespace App\Model;

interface ModelInterface
{
    public function findAll();
    public function findById($id);
    public function add($entity);
    public function update($entity);
    public function deleteById(Object $entity);
    public function count();
    public function paginateFindAll($currentPage, $perPage);
}