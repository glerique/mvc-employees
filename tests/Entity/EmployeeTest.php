<?php

namespace App\Tests\Entity;

use DateTime;
use App\Entity\Employee;
use App\Entity\Departement;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Entity\Entity
 * @covers \App\Entity\Employee
 * @covers \App\Entity\Departement
 */
class EmployeeTest extends TestCase
{
       
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

    public function testGetBirthDate()
    {        
        $employee = new Employee();        
        $employee->setBirthDate('1990-01-01');             
        $this->assertInstanceOf(DateTime::class, $employee->getBirthDate());     
    }
   
    public function testGetSetHireDate()
    {
        $employee = new Employee;
        $employee->setHireDate('1990-01-01');
        $this->assertInstanceOf(DateTime::class, $employee->getHireDate());
        
    }

    
    public function testGetSetSalary()
    {
        $employee = new Employee;
        $employee->setSalary('1000');
        $this->assertEquals('1000', $employee->getSalary());
    }

    public function testGetSetDepartementId()
    {

        $employee = new Employee;
        $employee->setDepartementId('1');
        $this->assertEquals('1', $employee->getDepartementId());
    }
   
    public function testGetSetDepartement()
    {
        $employee = new Employee;
        $employee->setDepartement(new Departement);
        $this->assertInstanceOf(Departement::class, $employee->getDepartement());
    }
}
