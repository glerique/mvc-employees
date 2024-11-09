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

            foreach ($parameters as $key => $value) {
                if (!str_starts_with($key, '_')) {
                    $request->attributes->set($key, $value);
                }
            }

            $controllerName = $parameters['_controller'];
            $action = $parameters['_action'];

            $response = $this->handleRequest($controllerName, $action, $request);

        } catch (\Exception $e) {
            $this->handleException($e);
        }

        $response->send();
    }

        private function getUri(Request $request): string
    {

        return $request->getPathInfo();
    }

    private function handleRequest(string $controllerName, string $action, $request): Response
    {
        $controller = $this->controllerProvider->get($controllerName);

        return $controller->$action($request);
    }

    private function handleException(\Exception $e): void
    {
        echo '<p>Une erreur s\'est produite : ' . htmlspecialchars($e->getMessage()) . '</p>';
        exit();
    }
}

