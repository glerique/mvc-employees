<?php

namespace App\Model;

use App\Model\Model;
use App\Entity\Departement;



class DepartementManager extends Model
{
        protected $table = 'departement';
        protected $class  = 'App\Entity\Departement';
        protected $objet = 'new Departement()';




        public function add(Departement $departement)
        {
                $req = $this->db->prepare("INSERT INTO $this->table (name) 
                VALUES (:name)");
                $req->bindvalue(':name', $departement->getName());
                $req->execute();
        }

        public function update(Departement $departement)
        {
                $req = $this->db->prepare("UPDATE $this->table SET  name = :name WHERE id = :id");
                $req->bindvalue(':name', $departement->getName());
                $req->bindvalue(':id', $departement->getId());
                $req->execute();
        }
}
