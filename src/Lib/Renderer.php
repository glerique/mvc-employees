<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Renderer
{
    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public function render(string $template, array $data = []): Response
    {
        $pageContent = $this->twig->render($template . '.twig', $data);

        return new Response($pageContent);
    }
}

