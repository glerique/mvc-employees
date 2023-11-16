<?php

namespace App\Lib;

class Renderer
{

    public static function render(string $path, array $var = []): void
    {
        extract($var);

        ob_start();
        require('src/View/' . $path . '.view.php');
        $pageContent = ob_get_clean();

        require('src/layout.php');
    }
}
