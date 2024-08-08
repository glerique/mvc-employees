<?php

namespace App\Lib;

use Symfony\Component\HttpFoundation\Response;

class Renderer
{

    public static function render(string $path, array $var = []): Response
    {
        extract($var);

        ob_start();
        require('src/View/' . $path . '.view.php');
        $pageContent = ob_get_clean();

        require('src/layout.php');

        return new Response($pageContent);
    }
}

