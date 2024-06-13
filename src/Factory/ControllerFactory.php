<?php
namespace App\Factory;

use App\Lib\DatabaseConfig;
use App\Lib\DatabaseConnection;
use App\Lib\QueryBuilder;
use App\Model\DepartementModel;

class ControllerFactory
{    
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;   
    }

    public function createController(string $controllerName)
    {
        $modelName = "App\\Model\\" . $controllerName . "Model";
        if (!class_exists($modelName)) {
            throw new \Exception("Le modèle $modelName n'existe pas !");
        }

        $model = new $modelName($this->queryBuilder);
        $relation = new DepartementModel($this->queryBuilder);
        $controllerClass = "App\\Controller\\" . $controllerName . "Controller";

        if (!class_exists($controllerClass)) {
            throw new \Exception("Le contrôleur $controllerClass n'existe pas !");
        }

        return new $controllerClass($model, $relation);        
    }
}