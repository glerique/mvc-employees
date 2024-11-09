<?php

namespace App\Lib;

use Twig\Environment;
use App\Lib\TwigRouterConfigurator;
use Symfony\Component\HttpFoundation\Response;

class Renderer
{
    public function __construct(
        private readonly Environment $twig,
        private readonly TwigRouterConfigurator $twigRouterConfigurator,
    ) {
    }

    public function render(string $template, array $data = []): Response
    {
        $pageContent = $this->twig->render($template . '.twig', $data);

        return new Response($pageContent);
    }
}

