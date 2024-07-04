<?php

namespace App\Lib;

use App\Factory\ControllerFactory;
use App\Lib\Session;
use App\Lib\Http;

class Application
{
    private $controllerFactory;

    const DEFAULT_CONTROLLER = 'Employee';
    const DEFAULT_ACTION = 'index';

    public function __construct(ControllerFactory $controllerFactory)
    {
        $this->controllerFactory = $controllerFactory;
    }

    public function start()
    {
        session_start();
        try {
            $uri = $this->getUri();
            $params = $this->parseUri($uri);

            $controllerName = !empty($params[0]) ? ucfirst($params[0]) : self::DEFAULT_CONTROLLER;
            $action = !empty($params[1]) ? $params[1] : self::DEFAULT_ACTION;
            $id = !empty($params[2]) ? (int) filter_var($params[2], FILTER_VALIDATE_INT) : null;

            $this->dispatch($controllerName, $action, $id);
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function getUri()
    {
        $uri = $_SERVER['REQUEST_URI'];        
        $uri = rtrim($uri, '/') ?: '/';
        return $uri;
    }

    private function parseUri($uri)
    {
        $trimmedUri = trim($uri, '/');
        $params = explode('/', $trimmedUri);
        return array_slice($params, 1); 
    }

    private function dispatch($controllerName, $action, $id)
    {
        $controller = $this->controllerFactory->createController($controllerName);

        if (!method_exists($controller, $action)) {
            throw new \Exception("L'action que vous avez demandée n'existe pas !");
        }

        if ($id !== null) {
            $_GET['id'] = $id;
        }

        $controller->$action();
    }

    private function handleException(\Exception $e)
    {
        Session::addFlash('error', $e->getMessage());
        Http::redirect("/mvc-employees/");
    }
}