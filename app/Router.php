<?php

namespace App;

class Router 
{
    function __construct()
    {
        $path = 'home';
        $path_array = [];

        if (!empty($_REQUEST['path'])) $path_array = array_filter(explode('/', $_REQUEST['path']));
        if (count($path_array) > 0) {
            if ($path_array[0] == 'category' || $path_array[0] == 'catalog') $path = $path_array[0];
            else $path = array_pop($path_array);
        }

        $class_name = 'App\\Controllers\\' . $path;
        if (!class_exists($class_name)) $class_name = 'App\\Controllers\\Main';

        if ($path == 'category' || $path == 'catalog') {
            if (count($path_array) > 1) new $class_name($path, array_pop($path_array));
            else new $class_name($path);
            
            return;
        }
        
        new $class_name($path);
    }
}