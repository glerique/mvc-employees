<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Employee;
use App\Entity\Departement;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Employee
 * @covers \App\Entity\Departement
 */
class EmployeeTest extends TestCase
{

    public function testGetId()
    {
        $employee = new Employee();
        $this->assertEquals(null, $employee->getId());
    }

    public function testGetSetLastName()
    {
        $employee = new Employee;
        $employee->setLastName('Test lastname');
        $this->assertEquals('Test lastname', $employee->getLastName());
    }

    public function testGetSetFirstName()
    {
        $employee = new Employee();
        $employee->setFirstName('Test firstname');
        $this->assertEquals('Test firstname', $employee->getFirstName());
    }

    public function testGetSetBirthDate()
    {
        $employee = new Employee;
        $employee->setBirthDate(new DateTime);
        $this->assertInstanceOf(DateTime::class, $employee->getBirthDate());
    }

    public function testGetSetHireDate()
    {
        $employee = new Employee;
        $employee->setHireDate(new DateTime);
        $this->assertInstanceOf(DateTime::class, $employee->getHireDate());
    }

    public function testGetSetSalary()
    {
        $employee = new Employee;
        $employee->setSalary('1000');
        $this->assertEquals('1000', $employee->getSalary());
    }

    public function testGetSetDepartement()
    {

        $employee = new Employee;
        $employee->setDepartement(new Departement);
        $this->assertInstanceOf(Departement::class, $employee->getDepartement());
    }
}
