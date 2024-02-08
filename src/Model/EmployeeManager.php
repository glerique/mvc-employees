<?php

namespace App\Model;

use PDO;
use App\Model\Model;
use App\Lib\Database;
use App\Entity\Employee;
use App\Model\DepartementManager;



class EmployeeManager extends Model
{
        
        protected $table = "employee";
        protected $class  = 'App\Entity\Employee';
        protected $objet = 'new Employee()';
        


        public function findAll()
        {
                $req = $this->db->prepare("SELECT * FROM $this->table");
                $req->execute();
                $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
                $employees =  $req->fetchAll();
                foreach ($employees as $employee) {
                        $db = new Database;
                        $departementManager = new DepartementManager($db);                        
                        $employee->setDepartement($departementManager->findById($employee->getDepartementId()));
                }
                return $employees;
        }

        public function PaginateFindAll($currentPage, $perPage)
        {
                $first = ($currentPage * $perPage) - $perPage;
                $req = $this->db->prepare("SELECT * FROM $this->table ORDER BY id DESC LIMIT :premier, :perpage");
                $req->bindValue(':premier', $first, PDO::PARAM_INT);
                $req->bindValue(':perpage', $perPage, PDO::PARAM_INT);
                $req->execute();
                $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
                $employees =  $req->fetchAll();
                foreach ($employees as $employee) {
                        $db = new Database;
                        $departementManager = new DepartementManager($db);                        
                        $employee->setDepartement($departementManager->findById($employee->getDepartementId()));
                }
                return $employees;
        }

        public function findById($id)
        {

                $req = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
                $req->bindValue(':id', (int)$id);
                $req->execute();
                $req->setFetchMode(PDO::FETCH_CLASS, $this->class);
                $employee =  $req->fetch();
                if (!empty($employee)) {
                        $db = new Database;
                        $departementManager = new DepartementManager($db);
                        $employee->setDepartement($departementManager->findById($employee->getDepartementId()));
                }
                return $employee;                
        }

        public function add(Employee $employee)
        {
                $req = $this->db->prepare("INSERT INTO $this->table (lastName, firstName, birthDate, hireDate, salary, departementId) 
                VALUES (:lastName, :firstName, :birthDate, :hireDate, :salary, :departementId)");
                $req->bindvalue(':lastName', $employee->getLastName());
                $req->bindvalue(':firstName', $employee->getFirstName());
                $req->bindvalue(':birthDate', $employee->getBirthDate()->format('Y-m-d'));
                $req->bindvalue(':hireDate', $employee->getHiredate()->format('Y-m-d'));
                $req->bindvalue(':salary', $employee->getSalary());
                $req->bindvalue(':departementId', $employee->getDepartementId());
                $req->execute();
        }

        public function update(Employee $employee)
        {
                
                
                $req = $this->db->prepare("UPDATE $this->table SET lastName = :lastName, firstName = :firstName, birthDate = :birthDate,   
                                                 hireDate = :hireDate, salary = :salary, departementId = :departementId WHERE id = :id");
                $req->bindvalue(':lastName', $employee->getLastName());
                $req->bindvalue(':firstName', $employee->getFirstName());
                $req->bindvalue(':birthDate', $employee->getBirthDate()->format('Y-m-d'));
                $req->bindvalue(':hireDate', $employee->getHiredate()->format('Y-m-d'));
                $req->bindvalue(':salary', $employee->getSalary());
                $req->bindvalue(':departementId', $employee->getDepartementId());
                $req->bindvalue(':id', $employee->getId());
                $req->execute();
        }
}
