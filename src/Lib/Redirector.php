<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Redirector
{
    public function redirect(string $url): Response
    {
        $response = new RedirectResponse($url);
        $response->send();
        exit;
    }
}

