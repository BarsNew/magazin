<?php

namespace App\Models;

abstract class Category 
{
    static function get($path, $name) {
        global $db;

        if (empty($name)) return [];

        $sql = "SELECT id, name FROM categories WHERE slug = '$name'";

        $resultCategory = $db->query($sql);
        $resultCategory = $resultCategory->fetchAll();

        $catId = $resultCategory[0]["id"];
        $catName = $resultCategory[0]["name"];


if (isset($_GET['page']))
{
    $page = $_GET['page'];
} 
else $page = 1;

$kol = 8;
    
$start = ($page * $kol) - $kol;



        $sql = "
        SELECT title, slug, picture
        FROM posts 
        JOIN pages
        ON pages.id = page_id 
        AND category_id = $catId
        LIMIT $start,$kol
        ";



        $result = $db->query($sql);
        
        if (empty($result)) {
            header('Location: http://magazin/404');
            exit;
        }  
        else {
            $result = $result->fetchAll();
        }
        

        //if (empty($result)) return [];

        

        $html = '';


        $type = '';
        switch ($catId) {
            case 1: 
                $type = 'news';
            break;
            case 2: 
                $type = 'articles';
            break;
        }

        $sql1 = "SELECT count(*) FROM pages WHERE type = '$type'";

        $count = current($db->query($sql1)->fetch());

        $str_pag = ceil($count / $kol);

        function veiw_pagination ($str_pag)
        {
            $n = '';
            $cat = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $cat = preg_replace("#/$#", "", $cat);
            for ($i = 1; $i <= $str_pag; $i++)
            {
                $n .= '<a href="' . $cat . '?page='. $i . '">' . $i . ' </a>' . "&nbsp;";
            
            }
            return '<span class="pagination">Страницы:</span> ' . $n;
            
        }
 //       

        foreach ($result as $link) {

            if (!empty($link['picture'])) {
                $img = '<a href="/' . $link['slug'] . '/">' . '<img class="category-img" src="/images/' . $link['picture'] . '" alt="' . $link['title'] . '">' . '</a>';
            }

            $html .= '<li>' . $img . '<a href="/' . $link['slug'] . '/">' . $link['title'] . '</a></li>';
        }

        if (!empty($html)) $html = '<ul class="category-ul">' . $html . '<div style="text-align: center;">' . veiw_pagination($str_pag) . '</div>' . '</ul>';

        $data = [
            'title' => $catName,
            'header' => $catName,
            'content' => $html
        ];

        return $data;
    }
}