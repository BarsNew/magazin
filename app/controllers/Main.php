<?php

namespace App\Controllers;

use \App\Models\Main as Main_Models;
use \App\Views\Main as Main_Views;

class Main 
{
    function __construct($path)
    {
        if (!empty($path)) $this->path = $path;
        $this->init();
    }

    function init() 
    {
        $data = Main_Models::get($this->path);
        Main_Views::render($data, $this->path);
    }
}