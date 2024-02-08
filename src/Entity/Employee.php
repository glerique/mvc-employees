<?php

namespace App\Entity;

use App\Entity\Entity;
use DateTime;

class Employee extends Entity
{    
    private $lastName;
    private $firstName;
    private $birthDate;
    private $hireDate;
    private $salary;
    private $departementId;
    private $departement;  

    
    /**
     * Getters 
     */    

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getBirthDate()
    {
        return new DateTime($this->birthDate);
        
    }

    public function getHireDate() 
    {
        return new DateTime($this->hireDate);
        
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getDepartementId()
    {
        return $this->departementId;
    }

    public function getDepartement()
        {
            return $this->departement;
        } 


    /**
     * Setters
     */    

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;        
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function setHireDate($hireDate)
    {
        $this->hireDate = $hireDate;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setDepartementId($departementId)
    {
        $this->departementId = $departementId;
    }

    public function setDepartement($departement)
    {
        $this->departement = $departement;
    }    
}
