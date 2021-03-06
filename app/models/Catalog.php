<?php

namespace App\Models;

use \App\Models\Main as Main_Models;

abstract class Catalog extends Main_Models
{
    static function getStore($product_id = '') {

        $host = 'magazin';  // Хост, у нас все локально
        $user = 'root';    // Имя созданного вами пользователя
        $pass = ''; // Установленный вами пароль пользователю
        $db_name = 'mysite';   // Имя базы данных
        $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой
        
        // Ругаемся, если соединение установить не удалось
        if (!$link) {
        echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
        }

        $data = mysqli_query($link, "SELECT * FROM base");
        $data = mysqli_fetch_array($data);
        $data = unserialize($data['base']);

        if (!empty($product_id)) {
            $d = [];
            foreach($data as $prod) {
                if ($prod['id'] != $product_id ) continue;
                $d['id'] = $prod['id'];
                $d['title'] = $prod['title'];
                $d['price'] = $prod['price'];
                $d['description'] = $prod['description'];
                $d['image'] = $prod['image'];
            }
            $data = $d;     
        }

        if (!empty($data)) return $data;
        return [];
    }

    static function get($path, $product_id = '') {
 
        $prov = preg_match('/^[0-9]+$/i', $product_id);
      
        if (($product_id != '') && ($prov == 0)) {
            header('Location: http://magazin/404');
            exit;
        }

        $data = parent::get($path);
        
        if (empty($product_id)) $data_store = self::getStore();
        else $data_store = self::getStore($product_id);

        if (empty($data_store)) {
            header('Location: http://magazin/404');
            exit;
        }


        if (!empty($data_store) && empty($product_id)):

            $data_store_html = '';

            foreach($data_store as $product) {
                if (!empty($_GET['n']) && $_GET['n'] == 'clothing' && $product['id'] != 2 && $product['id'] != 3 && $product['id'] != 4 && $product['id'] != 15 && $product['id'] != 16 && $product['id'] != 17 && $product['id'] != 18 && $product['id'] != 19 && $product['id'] != 20) { 
                    continue;
                } elseif (!empty($_GET['n']) && $_GET['n'] == 'bags' && $product['id'] != 1) {
                    continue;
                } elseif (!empty($_GET['n']) && $_GET['n'] == 'rings' && $product['id'] != 5 && $product['id'] != 6 && $product['id'] != 7 && $product['id'] != 8) {
                    continue;
                } elseif (!empty($_GET['n']) && ($_GET['n'] == 'clock' || $_GET['n'] == 'shoes' || $_GET['n'] == 'perfume')) {
                    $data_store_html = "Приход товара август-сентябрь";
                } else {
                $data_store_html .= '
                <div class="catalog__product">
                    <h3><a href="/catalog/' . $product['id'] . '/">' . $product['title'] . '</a></h3>
                    <a href="/catalog/' . $product['id'] . '/"><img src="' . $product['image'] . '" alt="' . $product['title'] . '"></a>
                    <div class="catalog__product_price">$' . $product['price'] . '</div>
                    <form action="/app/cart.php" method="get">
                        <input type="hidden" name="form_cart_product_id" value="' . $product['id'] . '">
                        <a href="/checkout' . '?cart=add&id=' . $product['id'] . '" class="add-to-cart" data-id="' . $product['id'].'">Купить</a>
                       
                    </form>
                </div>
                '; 
            }}

            if (!empty($data_store_html)) {
                $data_store_html = '<div class="catalog__list">' . $data_store_html . '</div>';
                
                $data['store'] = $data_store_html;
            }



        endif;

        if (!empty($data_store) && !empty($product_id)):
            $data_store_html = '
            <div class="prod">
                <h1 class="main-h1">'. $data_store['title'] . '</h1>
                <div class="prod-item1"><img src="' . $data_store['image'] . '" alt="' . $data_store['title'] . '">
                <div>' . $data_store['description'] . '<div class="prod-price">$' . $data_store['price'] . '</div></div>
                
                </div>
                <div class="prod-item2">
                
                <a href="/checkout' . '?cart=add&id=' . $data_store['id'] . '" class="add-to-cart" data-id="' . $data_store['id'].'">Купить</a>
                </div>
            </div>
            ';

            $data['product'] = $data_store_html;
        endif;

        return $data;
    }
}