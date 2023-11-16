<?php

namespace App\Model;

use PDO;
use DateTime;
use App\Model\Model;
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
                        $departementManager = new DepartementManager();
                        $employee->setBirthDate(new DateTime($employee->getBirthDate()));
                        $employee->setHireDate(new DateTime($employee->getHireDate()));
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
                        $departementManager = new DepartementManager();
                        $employee->setBirthDate(new DateTime($employee->getBirthDate()));
                        $employee->setHireDate(new DateTime($employee->getHireDate()));
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
                        $departementManager = new DepartementManager();
                        $employee->setDepartement($departementManager->findById($employee->getDepartementId()));
                }
                return $employee;
        }

        public function add(Employee $employee)
        {
                $req = $this->db->prepare("INSERT INTO $this->table (last_name, first_name, birth_date, hire_date, salary, departementId) 
                VALUES (:last_name, :first_name, :birth_date, :hire_date, :salary, :departementId)");
                $req->bindvalue(':last_name', $employee->getLastName());
                $req->bindvalue(':first_name', $employee->getFirstName());
                $req->bindvalue(':birth_date', $employee->getBirthDate()->format('y-m-d'));
                $req->bindvalue(':hire_date', $employee->getHiredate()->format('y-m-d'));
                $req->bindvalue(':salary', $employee->getSalary());
                $req->bindvalue(':departementId', $employee->getDepartementId());
                $req->execute();
        }

        public function update(Employee $employee)
        {
                $req = $this->db->prepare("UPDATE $this->table SET last_name = :last_name, first_name = :first_name, birth_date = :birth_date,   
                                                 hire_date = :hire_date, salary = :salary, departementId = :departementId WHERE id = :id");
                $req->bindvalue(':last_name', $employee->getLastName());
                $req->bindvalue(':first_name', $employee->getFirstName());
                $req->bindvalue(':birth_date', $employee->getBirthDate()->format('y-m-d'));
                $req->bindvalue(':hire_date', $employee->getHiredate()->format('y-m-d'));
                $req->bindvalue(':salary', $employee->getSalary());
                $req->bindvalue(':departementId', $employee->getDepartementId());
                $req->bindvalue(':id', $employee->getId());
                $req->execute();
        }
}
