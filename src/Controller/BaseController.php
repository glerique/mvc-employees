<?php

namespace App\Controller;

use App\Lib\Http;
use App\Lib\SessionManager;

abstract class BaseController
{
    public function __construct(
        protected readonly SessionManager $sessionManager,
    ) {
    }

    protected function redirectWithError(string $url, string $message)
    {
        $this->sessionManager->addFlash('error', $message);
        Http::redirect($url);
    }

    protected function redirectWithSuccess(string $url, string $message)
    {
        $this->sessionManager->addFlash('success', $message);
        Http::redirect($url);
    }

    protected function redirect(string $url)
    {
        Http::redirect($url);
    }
}

