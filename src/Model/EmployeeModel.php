<?php

namespace App\Model;

use App\Model\Model;

class EmployeeModel extends Model
{
        protected $table = 'employee';
        protected $class  = 'App\Entity\Employee';
        protected $relationManager = 'App\Model\DepartementModel';
        protected $relationEntity = 'Departement';
        protected $relationProperty = "departementId";


        public function getEntityData($employee): array
        {
                return [
                        'id' => $employee->getId(),
                        'lastName' => $employee->getLastName(),
                        'firstName' => $employee->getFirstName(),
                        'birthDate' => $employee->getBirthDate()->format('Y-m-d'),
                        'hireDate' => $employee->getHiredate()->format('Y-m-d'),
                        'salary' => $employee->getSalary(),
                        'departementId' => $employee->getDepartementId(),
                ];
        }
}
