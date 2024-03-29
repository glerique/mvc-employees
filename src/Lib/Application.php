<?php

namespace App\Lib;

use App\Lib\Database;

class Application
{
    /** 
     * Router de l'application      
     */
    public static function start()
    {
        session_start();
        $uri = $_SERVER['REQUEST_URI'];

        $params = [];

        $params = explode('/', $uri);

        if (!empty($params[2])) {
            $controllerName = ucfirst($params[2]);
        } else {
            $controllerName = "Employee";
        }

        if (!empty($params[3])) {
            $action = $params[3];
        } else {
            $action = "index";
        }

        $path = "src/Controller/" . $controllerName . "Controller.php";
        $modelName = "App\Model\\" . $controllerName . "Model";
        $db = new Database;
        $model = new $modelName($db);
        if (!file_exists($path)) {
            // Si le controller n'existe pas, on affiche une erreur :
            Session::addFlash('error', "Le controller que vous avez demandé n'existe pas !");
            Http::redirect('/mvc-employees/');
        }

        $controllerName = "App\Controller\\" . $controllerName . "Controller";

        $controller = new $controllerName($model);

        if (!method_exists($controller, $action)) {
            // Si le controller ne connait pas de method pour cette action, on affiche une erreur
            Session::addFlash('error', "L'action que vous avez demandé n'existe pas !");
            Http::redirect("/mvc-employees/");
        }

        if (!empty($params[4])) {

            $_GET['id'] = (int)$params[4];
            $controller->$action();
        } else {
            $_GET['id'] = (int)1;
            $controller->$action();
        }
    }
}
