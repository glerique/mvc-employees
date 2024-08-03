<?php

namespace App\Controller;

use App\Lib\Redirector;
use App\Lib\SessionManager;

abstract class BaseController
{
    public function __construct(
        protected readonly SessionManager $sessionManager,
        protected readonly Redirector $redirector,
    ) {
    }

    protected function redirectWithError(string $url, string $message)
    {
        $this->sessionManager->addFlash('error', $message);
        $this->redirector->redirect($url);
    }

    protected function redirectWithSuccess(string $url, string $message)
    {
        $this->sessionManager->addFlash('success', $message);
        $this->redirector->redirect($url);
    }

    protected function redirect(string $url)
    {
        $this->redirector->redirect($url);
    }
}

