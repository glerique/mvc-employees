<?php

namespace App\Lib;

use Error;


class Application
{
    /** 
     * Router de l'application      
     */
    public static function start()
    {
        session_start();

        $params = [];
        if (empty($_GET['p'])) {
            $params = explode('/', $_GET['p']);

            if (!empty($params[0])) {
                $controllerName = ucfirst($params[0]);
            } else {
                $controllerName = "Employee";
            }

            if (!empty($params[1])) {
                $action = $params[1];
            } else {
                $action = "index";
            }

            $path = "src/Controller/" . $controllerName . "Controller.php";

            if (!file_exists($path)) {
                // Si le controller n'existe pas, on affiche une erreur :
                Session::addFlash('error', "Le controller que vous avez demandé n'existe pas !");
                Http::redirect('/mvc-employees/');
            }

            $controllerName = "App\Controller\\" . $controllerName . "Controller";

            $controller = new $controllerName();

            if (!method_exists($controller, $action)) {
                // Si le controller ne connait pas de method pour cette action, on affiche une erreur
                Session::addFlash('error', "L'action que vous avez demandé n'existe pas !");
                Http::redirect("/mvc-employees/");
            }

            if (!empty($params[2])) {
                //try{$controller->$action($params[2]);}  catch (Error $e){echo 'marche pas';}     
                $_GET['id'] = (int)$params[2];
                $controller->$action();
            } else {
                $_GET['id'] = (int)1;
                $controller->$action();
            }
        }
    }
}
