<?php

namespace App\Controller;

use App\Lib\Renderer;
use App\Lib\Redirector;
use App\Lib\SessionManager;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    public function __construct(
        protected readonly SessionManager $sessionManager,
        protected readonly Redirector $redirector,
        protected readonly Renderer $renderer,
    ) {
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

