<?php

namespace App\Model;

use PDO;
use App\Lib\Database;

class Model
{

    protected $db;
    protected $table;
    protected $class;
    protected $objet;
       

    public function __construct($db)
    {        
        $this->db = $db->getPdo(); 
    }

    public function count()
    {        
        $query = $this->db->prepare("SELECT COUNT(*) FROM $this->table");
        $query->execute();
        return $query->fetchColumn();
    }

    public function findAll()
    {
        $req = $this->db->prepare("SELECT * FROM $this->table");
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
        return $req->fetchAll();
    }

    public function findById($id)
    {

        $req = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
        $req->bindValue(':id', (int)$id);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
        return $req->fetch();
    }


    public function deleteById(Object $object)
    {
        $req = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
        $req->bindvalue(':id', $object->getId());
        $req->execute();
    }
}
