<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Redirector
{
    public function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }
}

