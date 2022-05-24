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
            $sql = mysqli_query($link, "DELETE FROM `clients` WHERE `ID` = {$_GET['del_id']}");
            if ($sql) {
            echo "<p>Категория удалена.</p>";
            } else {
            echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
            }
        }

        if (isset($_POST["submit"])) {
            //Если это запрос на обновление, то обновляем
            if (isset($_GET['red_id'])) {
                $sql = mysqli_query($link, "UPDATE `clients` SET `name` = '{$_POST['name']}', `gender` = '{$_POST['gender']}', `phone` = '{$_POST['phone']}', `email` = '{$_POST['email']}', `query` = '{$_POST['query']}', `city` = '{$_POST['city']}', `date` = UNIX_TIMESTAMP()  WHERE `id`={$_GET['red_id']}");
            } else {
                //Иначе вставляем данные, подставляя их в запрос
                $sql = mysqli_query($link, "INSERT INTO `clients` (`page`, `name`, `gender`, `phone`, `email`, `query`, `city`, `date`) VALUES (' - ', '{$_POST['name']}', '{$_POST['gender']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['query']}', '{$_POST['city']}', UNIX_TIMESTAMP())");
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
        $sql = mysqli_query($link, "SELECT * FROM `clients` WHERE `id`={$_GET['red_id']}");
        $page = mysqli_fetch_array($sql);
        }
    ?>

    <button><a class="ab-btn asphalt" href='/admin'>Вернуться на главную</a></button>

    <form action="" method="post">
        <table class="table-pages">
        <tr>
            <td class='td1'>ID покупателя:</td>
            <td class="table-p"><input disabled type="text" name="id" value="<?php echo isset($_GET['red_id']) ? $page['id'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Страница:</td>
            <td><input disabled type="text" name="page" value="<?php echo isset($_GET['red_id']) ? $page['page'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Имя:</td>
            <td><input type="text" name="name" value="<?php echo isset($_GET['red_id']) ? $page['name'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Пол:</td>
            <td><input type="text" name="gender" value="<?php echo isset($_GET['red_id']) ? $page['gender'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Телефон:</td>
            <td><input type="text" name="phone" value="<?php echo isset($_GET['red_id']) ? $page['phone'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Почта:</td>
            <td><input type="text" name="email" value="<?php echo isset($_GET['red_id']) ? $page['email'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Товар(ы):</td>
            <td><textarea style="padding: 5px 20px; color: #000; width:100%" type="text" name="query" ><?php echo isset($_GET['red_id']) ? $page['query'] : ''; ?></textarea></td>
        </tr>
        <tr>
            <td class='td1'>Город:</td>
            <td><input type="text" name="city" value="<?php echo isset($_GET['red_id']) ? $page['city'] : ''; ?>"></td>
        </tr>
        <tr>
            <td class='td1'>Дата:</td>
            <td><input disabled type="text" name="date" value="<?php echo isset($_GET['red_id']) ? date('Y-m-d H:i:s', $page['date']) : ''; ?>"></td>
        </tr>
         </table>

        <a class="ab-btn asphalt text-white" href='clients_list.php'>Стереть</a>
    
        <button class="ab-btn asphalt" type="submit" name="submit" value="OK">Создать/Обновить</button>

    </form>

    <table class="table-pages2">
    <tr class="table-b">
        <th>ID покупателя</th>
        <th>Страница</th>
        <th>Имя</th>
        <th>Пол</th>
        <th>Телефон</th>
        <th>Почта</th>
        <th>Товар(ы)</th>
        <th>Город</th>
        <th>Дата</th>
        <th>Команда 1</th>
        <th>Команда 2</th>
    </tr>
    <?php
        $sql = mysqli_query($link, 'SELECT * FROM `clients`');
        while ($result = mysqli_fetch_array($sql)) {
        echo "<tr class='text-center'><th class='table-n th-color'>ID покупателя</th><td>{$result['id']}</td><th class='table-n'>Страница</th><td>{$result['page']}</td><th class='table-n'>Имя покупателя</th><td>{$result['name']}</td><th class='table-n'>Пол</th><td>{$result['gender']}</td><th class='table-n'>Телефон</th><td>{$result['phone']}</td><th class='table-n'>Почта</th><td>{$result['email']}</td><th class='table-n'>Товар(ы)</th><td>{$result['query']}</td><th class='table-n'>Город</th><td>{$result['city']}</td><th class='table-n'>Дата</th><td>" . date('Y-m-d H:i:s', $result["date"]) . "</td><th class='table-n'>Команда 1</th><td><a class='text-white hover' href='?del_id={$result['id']}'>Удалить</a></td><th class='table-n'>Команда 2</th><td><a class='text-white hover' href='?red_id={$result['id']}'>Изменить</a></td></tr>";
        }
    ?>
    </table>
</body>
</html>