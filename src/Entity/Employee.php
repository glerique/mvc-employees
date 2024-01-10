<?php

namespace App\Entity;

use DateTime;

class Employee
{

    private $id;
    private $last_name;
    private $first_name;
    private $birth_date;
    private $hire_date;
    private $salary;
    private $departementId;
    private $departement;
    
   /* 
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set' . ucfirst($key);
            // Si le setter correspondant existe.
            if (method_exists($this, $method)) {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    // Important car sinon l'objet à sa création est vide.
    public function __construct($valeurs = [])
    {
        if (!empty($valeurs)) // Si on a spécifié des valeurs, alors on hydrate l'objet.
        {
            $this->hydrate($valeurs);
        }
    }
    */

    
    /**
     * Getters 
     */

    public function getId()
    {
        return $this->id;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getBirthDate() 
    {
        return $this->birth_date;
    }

    public function getHireDate() 
    {
        return $this->hire_date;
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

    public function setId($id)
    {
        $this->id = $id;
        return $id;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $last_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $first_name;
    }

    public function setBirthDate(DateTime $birth_date)
    {
        $this->birth_date = $birth_date;
        return $birth_date;
    }

    public function setHireDate(DateTime $hire_date)
    {
        $this->hire_date = $hire_date;
        return $hire_date;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
        return $salary;
    }

    public function setDepartementId($departementId)
    {
        $this->departementId = $departementId;
        return $departementId;
    }

    public function setDepartement($departement)
    {
        $this->departement = $departement;
        return $departement;
    }    
}
