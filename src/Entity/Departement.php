<?php

namespace App\Entity;


class Departement
{

    private $id;
    private $name;



    /**
     * Getters
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }


    /**
     * Setters
     */
    public function setId($id)
    {
        $this->id = $id;
        return $id;
    }

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
