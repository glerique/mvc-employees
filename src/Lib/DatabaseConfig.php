<?php
namespace App\Lib;

class DatabaseConfig
{
    private $host;
    private $dbname;
    private $user;
    private $password;

    public function __construct($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }

    public function getDsn()
    {
        return "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }
}