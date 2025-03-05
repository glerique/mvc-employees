<?php

namespace App\Controller;

use App\Lib\Renderer;
use App\Lib\Redirector;
use App\Lib\SessionManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

abstract class BaseController
{
    protected const DEFAULT_PAGE = 1;
    protected const DEFAULT_ROUTE = '';

    public function __construct(
        protected readonly SessionManager $sessionManager,
        protected readonly Redirector $redirector,
        protected readonly Renderer $renderer,
        protected readonly RouterInterface $router
    ) {
    }

    protected function getIndexRoute(?int $nb = self::DEFAULT_PAGE): string
    {
        $params = [];
        if ($nb !== null) {
            $params['nb'] = $nb;
        }
        return $this->router->generate(static::DEFAULT_ROUTE, $params);
    }

    protected function redirectWithError(string $url, string $message): Response
    {
        $this->sessionManager->addFlash('error', $message);
        return $this->redirector->redirect($url);
    }

    protected function redirectWithSuccess(string $url, string $message): Response
    {
        $this->sessionManager->addFlash('success', $message);
        return $this->redirector->redirect($url);
    }

    protected function redirect(string $url): Response
    {
        return $this->redirector->redirect($url);
    }
}

