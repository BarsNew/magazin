<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Редактирование cтраниц</title>
    <meta name="description" content="Простой файловый менеджер, редактирование страниц" /> 
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="media.css">
    <link rel="stylesheet" href="font-awesome.min.css">
</head>
<body class="text-white">
    <?php

        require_once '../config.php';

        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); // Соединяемся с базой

        // Ругаемся, если соединение установить не удалось
        if (!$link) {
        echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
        }

        if (isset($_GET['del_id'])) { //проверяем, есть ли переменная
            //удаляем строку из таблицы
            $sql = mysqli_query($link, "DELETE FROM `pages` WHERE `ID` = {$_GET['del_id']}");
            if ($sql) {
            echo "<p>Страница удалена.</p>";
            } else {
            echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
            }
        }

        if (isset($_POST["submit"])) {
            //Если это запрос на обновление, то обновляем
            if (isset($_GET['red_id'])) {
                $sql = mysqli_query($link, "UPDATE `pages` SET `type` = '{$_POST['type']}', `parent_id` = '{$_POST['parent_id']}', `title` = '{$_POST['title']}', `header` = '{$_POST['header']}', `slug` = '{$_POST['slug']}', `sort` = '{$_POST['sort']}', `public` = '{$_POST['public']}', `picture` = '{$_POST['picture']}'  WHERE `ID`={$_GET['red_id']}");
            } else {
                //Иначе вставляем данные, подставляя их в запрос
                $sql = mysqli_query($link, "INSERT INTO `pages` (`type`, `parent_id`, `title`, `header`, `slug`, `sort`, `public`, `picture`) VALUES ('{$_POST['type']}', '{$_POST['parent_id']}', '{$_POST['title']}', '{$_POST['header']}', '{$_POST['slug']}', '{$_POST['sort']}', '{$_POST['public']}', '{$_POST['picture']}')");
            }
    
            //Если вставка прошла успешно
            if ($sql) {
            echo '<p>Успешно!</p>';
            } else {
            echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
            }
        }

    //Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
        if (isset($_GET['red_id'])) {
        $sql = mysqli_query($link, "SELECT * FROM `pages` WHERE `id`={$_GET['red_id']}");
        $page = mysqli_fetch_array($sql);
        }
    ?>

    <button><a class="ab-btn asphalt" href='/admin'>Вернуться на главную</a></button>

    <form action="" method="post">
        <table class="table-pages">
        <tr>
            <td class='td1'>ID страницы:</td>
            <td class="table-p"><input disabled type="text" name="id" value="<?php echo isset($_GET['red_id']) ? $page['id'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Тип страницы:</td>
            <td><input type="text" name="type" value="<?php echo isset($_GET['red_id']) ? $page['type'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>ID родителя:</td>
            <td><input type="text" name="parent_id" value="<?php echo isset($_GET['red_id']) ? $page['parent_id'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Title:</td>
            <td><input type="text" name="title" value="<?php echo isset($_GET['red_id']) ? $page['title'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Заголовок:</td>
            <td><input type="text" name="header" value="<?php echo isset($_GET['red_id']) ? $page['header'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Адрес страницы:</td>
            <td><input type="text" name="slug" value="<?php echo isset($_GET['red_id']) ? $page['slug'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Сортировка:</td>
            <td><input type="text" name="sort" value="<?php echo isset($_GET['red_id']) ? $page['sort'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Публичность:</td>
            <td><input type="text" name="public" value="<?php echo isset($_GET['red_id']) ? $page['public'] : ''; ?>"></td>
        </tr>

        <tr>
            <td class='td1'>URL картинки:</td>
            <td><input type="text" name="picture" value="<?php echo isset($_GET['red_id']) ? $page['picture'] : ''; ?>"></td>
        </tr>

        </table>

        <a class="ab-btn asphalt text-white" href='pages_list.php'>Стереть</a>

        <button class="ab-btn asphalt" type="submit" name="submit" value="OK">Создать/Обновить</button>

    </form>

    <table class="table-pages2" >
    <tr class="table-b">
        <th>ID страницы</th>
        <th>Тип страницы</th>
        <th>ID родителя</th>
        <th>Title</th>
        <th>Заголовок</th>
        <th>Адрес страницы</th>
        <th>Сортировка</th>
        <th>Публичность</th>
        <th>Команда 1</th>
        <th>Команда 2</th>
        <th>Команда 3</th>
    </tr>
    <?php
        $sql = mysqli_query($link, 'SELECT * FROM `pages`');
        while ($result = mysqli_fetch_array($sql)) {
        echo "<tr class='text-center'><th class='table-n th-color'>ID страницы:</th><td>{$result['id']}</td><th class='table-n'>Тип страницы:</th><td>{$result['type']}</td><th class='table-n'>ID родителя:</th><td>{$result['parent_id']}</td><th class='table-n'>Title:</th><td>{$result['title']}</td><th class='table-n'>Заголовок:</th><td>{$result['header']}</td><th class='table-n'>Адрес страницы:</th><td>{$result['slug']}</td><th class='table-n'>Сортировка:</th><td>{$result['sort']}</td><th class='table-n'>Публичность:</th><td>{$result['public']}</td><th class='table-n'>Команда 1:</th><td><a class='text-white hover' href='?del_id={$result['id']}'>Удалить</a></td><th class='table-n'>Команда 2:</th><td><a class='text-white hover' href='?red_id={$result['id']}'>Изменить</a></td><th class='table-n'>Команда 3:</th><td><a class='text-white hover' href='/admin/editorlist.php?red_id={$result['id']}'>Редактировать контент</a></td></tr>";
        }
    ?>
    </table>
  

</body>
</html>