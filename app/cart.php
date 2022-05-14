<?php
session_start();

if (isset($_GET['cart']) ) {

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $cart = $_SESSION['cart'];
  
    if ($_GET['cart'] == 'add' )  {

            $type = gettype($id);     
                   
            if (empty($cart)) {               
                $_SESSION['cart'][] = $id;
            } else {
                array_push($cart, $id);
                $_SESSION['cart'] = $cart;     
            }                      
            
        if ($_SERVER['REQUEST_URI'] != '/checkout?cart=add&id=' . $_GET['id'] ) { 

            echo  json_encode(['answer' => "Товар артикул № " . $id . " добавлен в корзину"]);

        }
    }  
}


