<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionManager
{
    public function __construct(
        private readonly SessionInterface $session,
    ) {
    }

    public function addFlash(string $type, string $message): void
    {
        $this->session->getFlashBag()->add($type, $message);
    }

    public function getFlashes(string $type): array
    {
        return $this->session->getFlashBag()->get($type, []);
    }

    public function showFlashes(string $type): bool
    {
        return $this->session->getFlashBag()->has($type);
    }
}

