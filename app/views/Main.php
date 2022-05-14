<?php

namespace App\Views;

abstract class Main
{
    static public function render($data, $path)
    {
        if (empty($data)) {
            $data = [
                'title' => '',
                'header' => '',
                'content' => ''
            ];
        }

        $path_layouts = $_SERVER['DOCUMENT_ROOT'] . '/app/layouts/';

        ob_start();
        require_once $path_layouts . 'header.php';

        if (file_exists($path_layouts . $path . '.php')) {
            if (!empty($data['product'])) require_once $path_layouts . 'product.php';
            else if (!empty($data['store'])) require_once $path_layouts . 'catalog.php';
            else require_once $path_layouts . $path . '.php';
        } else {
            require_once $path_layouts . 'main.php';
        }
        
        require_once $path_layouts . 'footer.php';
        $html = ob_get_clean();

        echo $html;
    }
}