<?php

namespace App\Views;

abstract class About
{
    static public function render($data)
    {
        $path_layouts = $_SERVER['DOCUMENT_ROOT'] . '/app/layouts/';

        ob_start();
        require_once $path_layouts . 'header.php';
        require_once $path_layouts . 'main.php';
        require_once $path_layouts . 'footer.php';
        $html = ob_get_clean();

        echo $html;
    }
}