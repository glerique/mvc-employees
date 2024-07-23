<?php

namespace App\Lib;

use App\Lib\Http;
use App\Lib\Session;
use App\Controller\BaseController;
use Symfony\Contracts\Service\ServiceProviderInterface;

class Application
{
    private $controllerFactory;

    const DEFAULT_CONTROLLER = 'Employee';
    const DEFAULT_ACTION = 'index';

    public function __construct(ServiceProviderInterface $controllerProvider)
    {
        $this->controllerProvider = $controllerProvider;
    }

    public function start(): void
    {
        session_start();
        try {
            $uri = $this->getUri();
            $params = $this->parseUri($uri);

            $controllerName = !empty($params[0]) ? ucfirst($params[0]) : self::DEFAULT_CONTROLLER;
            $action = !empty($params[1]) ? $params[1] : self::DEFAULT_ACTION;
            $id = !empty($params[2]) ? (int) filter_var($params[2], FILTER_VALIDATE_INT) : null;

            $this->handleRequest($controllerName, $action, $id);
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);
        return  rtrim($uri, '/') ?: '/';
    }

    private function parseUri(string $uri): array
    {
        $trimmedUri = trim($uri, '/');
        $params = explode('/', $trimmedUri);
        return array_slice($params, 1);
    }

    private function handleRequest(string $controllerName, string $action, ?int $id): BaseController
    {

        if (!$this->controllerProvider->has($controllerName)) {
            throw new \Exception("Le contrôleur $controllerName n'existe pas !");
        }

        $controller = $this->controllerProvider->get($controllerName);

        if (!method_exists($controller, $action) || !is_callable([$controller, $action])) {
            throw new \Exception("L'action que vous avez demandée n'existe pas !");
        }

        if ($id !== null) {
            $_GET['id'] = $id;
        }

        $controller->$action();

        return $controller;
    }

    private function handleException(\Exception $e): void
    {
        Session::addFlash('error', $e->getMessage());
        Http::redirect("/mvc-employees/");
    }
}
