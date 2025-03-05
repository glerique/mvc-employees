<?php

namespace App\Lib;

use Twig\Environment;
use Twig\TwigFunction;
use Symfony\Component\Routing\RouterInterface;

class TwigRouterConfigurator
{
    public function __construct(
        private readonly Environment $twig,
        private readonly RouterInterface $router,
        private readonly TwigFunction $twigFunction
    ) {}

    public function configure(): void
    {
        $this->twig->addFunction($this->twigFunction);
    }
}

