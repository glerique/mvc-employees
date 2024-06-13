<?php

namespace App\Lib;

use App\Factory\ControllerFactory;
use App\Lib\Session;
use App\Lib\Http;

class Application
{
    private $controllerFactory;

    public function __construct(ControllerFactory $controllerFactory)
    {
        $this->controllerFactory = $controllerFactory;
    }

    
    public function start()
    {
        session_start();
        $uri = $_SERVER['REQUEST_URI'];

        $params = explode('/', $uri);
        $controllerName = !empty($params[2]) ? ucfirst($params[2]) : "Employee";
        $action = !empty($params[3]) ? $params[3] : "index";
       
        try {
            $controller = $this->controllerFactory->createController($controllerName);

            if (!method_exists($controller, $action)) {
                throw new \Exception("L'action que vous avez demandée n'existe pas !");
            }

            $id = !empty($params[4]) ? (int)$params[4] : 1;
            $_GET['id'] = $id;
            $controller->$action();
        } catch (\Exception $e) {
            Session::addFlash('error', $e->getMessage());
            Http::redirect("/mvc-employees/");
        }
    }
}