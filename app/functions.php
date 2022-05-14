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

function getStore($product_id) {

    $ch = curl_init();

    curl_setopt($ch, 
        CURLOPT_URL, 
        "https://fakestoreapi.com/products/" . (!empty($product_id) ? $product_id : '')
    );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = json_decode(curl_exec($ch), true);

    if (!empty($data)) return $data;
    return [];
}

function unique_multidim_array($array, $key) { 
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