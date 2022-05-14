<?php

namespace App\Controllers;

use \App\Models\Category as Category_Models;
use \App\Views\Main as Main_Views;

class Category 
{
    function __construct($path, $name)
    {
        if (!empty($path)) $this->path = $path;
        if (!empty($name)) $this->name = $name;
        
        $this->init();
    }

    function init() 
    {
        $data = Category_Models::get($this->path, $this->name);
        Main_Views::render($data, $this->path);
    }
}