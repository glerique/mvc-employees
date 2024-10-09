<?php

namespace App\Lib;

use App\Lib\Http;
use App\Lib\Redirector;
use App\Lib\SessionManager;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Application
{
    const DEFAULT_CONTROLLER = 'employee';
    const DEFAULT_ACTION = 'index';

    public function __construct(
        private readonly ServiceProviderInterface $controllerProvider,
        private readonly SessionManager $sessionManager,
        private readonly Redirector $redirector,
    ) {

    }

    public function start(): void
    {
        try {
            $request = Request::createFromGlobals();
            $uri = $this->getUri($request);
            $params = $this->parseUri($uri);

            $controllerName = $this->getControllerName($params);
            $action = $this->getAction($params);
            $id = $this->getId($params);

            $response = $this->handleRequest($controllerName, $action, $id);

            $response->send();

        } catch (\Exception $e) {
            $response = $this->handleException($e);

            $response->send();
        }
    }

    private function getUri(Request $request): string
    {
        $uri = $request->getPathInfo();
        $uri = parse_url($uri, PHP_URL_PATH);
        return rtrim($uri, '/') ?: '/';
    }

    private function parseUri(string $uri): array
    {
        $trimmedUri = trim($uri, '/');
        $params = explode('/', $trimmedUri);
        return array_slice($params, 1);
    }

    private function handleRequest(string $controllerName, string $action, ?int $id): Response
    {
        if (!$this->controllerProvider->has($controllerName)) {
            throw new \Exception("Le contrôleur $controllerName n'existe pas !");
        }

        $controller = $this->controllerProvider->get($controllerName);

        if (!method_exists($controller, $action) || !is_callable([$controller, $action])) {
            throw new \Exception("L'action $action n'existe pas !");
        }

        if ($id !== null) {
            $_GET['id'] = $id;
        }

        return $controller->$action();
    }

    private function getControllerName(array $params): string
    {
        return  !empty($params[0]) ? $params[0] : self::DEFAULT_CONTROLLER;
    }

    private function getAction(array $params): string
    {
        return !empty($params[1]) ? $params[1] : self::DEFAULT_ACTION;
    }

    private function getId(array $params): ?int
    {
        return !empty($params[2]) ? (int) filter_var($params[2], FILTER_VALIDATE_INT) : null;
    }

    private function handleException(\Exception $e): Response
    {
        $this->sessionManager->addFlash('error', $e->getMessage());
        return $this->redirector->redirect("/mvc-employees/");
    }
}

