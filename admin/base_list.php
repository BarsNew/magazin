<?php

require_once '../config.php';

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$link) {
echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
exit;
}


if (isset($_POST["submit"])) {

    if (isset($_GET['red_id'])) {
        $sql = mysqli_query($link, "UPDATE `base` SET `url` = '{$_POST['base']}' WHERE `ID`={$_GET['red_id']}");
    } 

    if ($sql) {
    echo '<p>Успешно!</p>';
    } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
}

if (isset($_GET['red_id']) || isset($_POST["submit2"])) {
$sql = mysqli_query($link, "SELECT * FROM `base` WHERE `id`={$_GET['red_id']}");
$bas = mysqli_fetch_array($sql);
}


if (isset($_POST["submit2"])) {

    function getStore0($url, $product_id = '') {

        $ch = curl_init();

        curl_setopt($ch, 
            CURLOPT_URL, 
            $url . (!empty($product_id) ? $product_id : '')
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $data = json_decode(curl_exec($ch), true);

        //$data = curl_exec($ch);

        if (!empty($data)) return $data;
        return [];
    }

    $data_store = getStore0($bas["url"]);

    $data_store = addslashes(serialize($data_store));

    $sql = mysqli_query($link, "UPDATE `base` SET `base` = '{$data_store}'  WHERE `id`= 1 ");

}

?>

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

<button><a class="ab-btn asphalt" href='/admin'>Вернуться на главную</a></button>

<form action="" method="post">
    <table class="table-pages">
    <tr>
        <td class='td1'>URL адрес базы товаров:</td>
        <td class="table-p"><input type="text" name="base" value="<?php echo isset($_GET['red_id']) ? $bas['url'] : ''; ?>"></td>
    </tr>
    </table>
    <button class="ab-btn asphalt" type="submit" name="submit" value="OK">Изменить адрес</button>
    <button class="ab-btn asphalt" type="submit" name="submit2" value="OK">Обновить товар</button>
</form>

<table class="table-pages2">
<tr class="table-b">
    <th>URL адрес базы товаров</th>
    <th>Команда</th>
</tr>
<?php
    $sql = mysqli_query($link, 'SELECT * FROM `base`');
    while ($result = mysqli_fetch_array($sql)) {
    echo "<tr class='text-center'><th class='table-n th-color'>URL адрес:</th><td>{$result['url']}</td><th class='table-n th-color'>Команда:</th><td><a class='text-white hover' href='?red_id={$result['id']}'>Изменить</a></td></tr>";
    }
?>
</table>

</body>
</html>