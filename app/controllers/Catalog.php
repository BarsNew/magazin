<?php

namespace App\Controllers;

use \App\Models\Catalog as Catalog_Models;
use \App\Views\Main as Main_Views;

class Catalog
{
    function __construct($path, $product_id = '')
    {
        if (!empty($path)) $this->path = $path;
        if (!empty($product_id)) $this->product_id = $product_id;
        $this->init();
    }

    function init() 
    {
        if (empty($this->product_id)) $data = Catalog_Models::get($this->path);
        else $data = Catalog_Models::get($this->path, $this->product_id);

        Main_Views::render($data, $this->path);
    }
}