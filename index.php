<?php
require_once './app/autoloader.php';
require_once './config.php';

$db = App\DB::connect();

require_once './app/functions.php';

new App\Router();

if (!empty($_POST['form_cart_product_id'])) add_cart($_POST['form_cart_product_id']);

// var_dump($_COOKIE);