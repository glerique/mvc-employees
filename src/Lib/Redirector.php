<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\RedirectResponse;

class Redirector
{
    public function redirect(string $url): void
    {
        $response = new RedirectResponse($url);
        $response->send();
        exit;
    }
}

