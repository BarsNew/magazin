<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Редактирование категорий</title>
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
            $sql = mysqli_query($link, "DELETE FROM `categories` WHERE `ID` = {$_GET['del_id']}");
            if ($sql) {
            echo "<p>Категория удалена.</p>";
            } else {
            echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
            }
        }

        if (isset($_POST["submit"])) {
            //Если это запрос на обновление, то обновляем
            if (isset($_GET['red_id'])) {
                $sql = mysqli_query($link, "UPDATE `categories` SET `name` = '{$_POST['name']}', `slug` = '{$_POST['slug']}', `sort` = '{$_POST['sort']}' WHERE `ID`={$_GET['red_id']}");
            } else {
                //Иначе вставляем данные, подставляя их в запрос
                $sql = mysqli_query($link, "INSERT INTO `categories` (`name`, `slug`, `sort`) VALUES ('{$_POST['name']}', '{$_POST['slug']}', '{$_POST['sort']}')");
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
        $sql = mysqli_query($link, "SELECT * FROM `categories` WHERE `id`={$_GET['red_id']}");
        $page = mysqli_fetch_array($sql);
        }
    ?>

    <button><a class="ab-btn asphalt" href='/admin'>Вернуться на главную</a></button>

    <form action="" method="post">
        <table class="table-pages">
        <tr>
            <td class='td1'>ID категории:</td>
            <td class="table-p"><input disabled type="text" name="id" value="<?php echo isset($_GET['red_id']) ? $page['id'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Названия категории:</td>
            <td><input type="text" name="name" value="<?php echo isset($_GET['red_id']) ? $page['name'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Адрес страницы:</td>
            <td><input type="text" name="slug" value="<?php echo isset($_GET['red_id']) ? $page['slug'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Сортировка:</td>
            <td><input type="text" name="sort" value="<?php echo isset($_GET['red_id']) ? $page['sort'] : ''; ?>"></td>
        </tr>
        </table>
        <a class="ab-btn asphalt text-white" href='categories_list.php'>Стереть</a>
        <button class="ab-btn asphalt" type="submit" name="submit" value="OK">Создать/Обновить</button>
    </form>

    <table class="table-pages2">
    <tr class="table-b">
        <th>ID категории</th>
        <th>Названия категории</th>
        <th>Адрес страницы</th>
        <th>Сортировка</th>
        <th>Команда 1</th>
        <th>Команда 2</th>
    </tr>
    <?php
        $sql = mysqli_query($link, 'SELECT * FROM `categories`');
        while ($result = mysqli_fetch_array($sql)) {
        echo "<tr class='text-center'><th class='table-n th-color'>ID категории</th><td>{$result['id']}</td><th class='table-n'>Названия категории</th><td>{$result['name']}</td><th class='table-n'>Адрес страницы</th><td>{$result['slug']}</td><th class='table-n'>Сортировка</th><td>{$result['sort']}</td><th class='table-n'>Команда 1</th><td><a class='text-white hover' href='?del_id={$result['id']}'>Удалить</a></td><th class='table-n'>Команда 2</th><td><a class='text-white hover' href='?red_id={$result['id']}'>Изменить</a></td></tr>";
        }
    ?>
    </table>
  
</body>
</html>