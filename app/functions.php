<?php

function app_get_navigation($parent_id = 0, $parent_href = '/', $categories_public = false) 
{
    global $db;

    $html = '';

    if ($categories_public) {
        $sql = "
            SELECT * 
            FROM (
                (SELECT id, type, title, slug, sort 
                FROM pages 
                WHERE type = 'page' AND public = 1 AND parent_id = $parent_id)
                UNION
                (SELECT id, 'category', name, slug, sort
                FROM categories)
            ) AS pages_categories
            ORDER BY sort ASC
        ";

        $result = $db->query($sql);
        $result = $result->fetchAll();
    } else {
        $result = \App\DB::query(
            'pages', 
            'id, title, slug', 
            "type = 'page' AND public = 1 AND parent_id = $parent_id", 
            ["sort", "ASC"]
        );
    }

    foreach($result as $link) {
        // $href = '/';
        // if ($link['slug'] != 'home') $href = '/' . $link['slug'] . '/';

        $href = '/';

        if ($link['slug'] != 'home') $href = $link['slug'] . '/';
        else $href = '';

        if ($parent_href != '/') $href = $parent_href . $href;

        if (!empty($link['type']) && $link['type'] == 'category') $href = 'category/' . $href;

        $html .= '<li>
            <a href="/' . $href . '">' . $link['title'] . '</a>
            ' . app_get_navigation($link['id'], $href) . '
        </li>';
    }

    if (empty($html)) return '';
    return '<ul>' . $html . '</ul>';
}

function getStore($product_id) 
{    
    require_once './config.php';

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
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

function unique_multidim_array($array, $key) 
{ 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 


function counter_products() 
{
    $url = explode('?', $_SERVER['REQUEST_URI']);   
    $result = $url[0];
    $session_count = ($_SESSION['q']) ?? 0;

    $pr = preg_match("#/catalog/([\d])+/#i",$result);

    if ($result == '/catalog' || $result == '/catalog/' || (!empty($pr))) {  
        $counter = '<span id="quantity1" class="quantity">в корзине <span id="quantity">' . $session_count . '</span></span>';
    }

    return $counter;
}