<?php

namespace App\Tests\Entity;

use ReflectionClass;
use App\Entity\Departement;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Entity
 * @covers \App\Entity\Departement
 */
class DepartementTest extends TestCase

{
   
    public function testGetId()
    {
        $departement = new Departement();
        $this->assertEquals(null, $departement->getId());
    }

   
    public function testGetSetTitle()
    {
        $departement = new Departement();
        $departement->setName('Test departement');
        $this->assertEquals('Test departement', $departement->getName());
    }

    public function testToString()
    {
        $departement = new Departement();
        $departement->setName('Test Department');

        $this->assertEquals('Test Department', (string)$departement);
    }
}
