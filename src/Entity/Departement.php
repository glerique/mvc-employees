<?php

namespace App\Entity;
use App\Entity\Entity;

class Departement extends Entity
{    
    private $name;    

    /**
     * Getters
     */
    
    public function getName()
    {
        return $this->name;
    }


    /**
     * Setters
     */    

    public function setName($name)
    {
        $this->name = $name;
        return $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
