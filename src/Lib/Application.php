<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Contracts\Service\ServiceProviderInterface;


class Application
{
    public function __construct(
        private readonly ServiceProviderInterface $controllerProvider,
        private RouteCollection $routes,
    ) {
    }

    public function start(): void
    {
        try {
            $request = Request::createFromGlobals();
            $context = new RequestContext();
            $context->fromRequest($request);

            $matcher = new UrlMatcher($this->routes, $context);

            $pathInfo = $this->getUri($request);

            $parameters = $matcher->match($pathInfo);

            $controllerName = $parameters['_controller'];
            $action = $parameters['_action'];

            $id = isset($parameters['id']) && $parameters['id'] !== '' ? (int)$parameters['id'] : 1;

            $response = $this->handleRequest($controllerName, $action, $id);

        } catch (\Exception $e) {
            $this->handleException($e);
        }
        $response->send();
    }

        private function getUri(Request $request): string
    {

        return $request->getPathInfo();
    }

    private function handleRequest(string $controllerName, string $action, ?int $id): Response
    {
        $controller = $this->controllerProvider->get($controllerName);

        if ($id !== null) {
            $_GET['id'] = $id;
        }

        return $controller->$action();
    }

    private function handleException(\Exception $e): void
    {
        echo '<p>Une erreur s\'est produite : ' . htmlspecialchars($e->getMessage()) . '</p>';
        exit();
    }
}

