<?php

require_once '../config.php';

try {
    $link = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    die($e->getMessage());
}

if (isset($_POST["submit"])) {

    if (isset($_GET['red_id'])) {
        $link->query("UPDATE `base` SET `url` = '{$_POST['base']}' WHERE `ID`={$_GET['red_id']}");
    } 
}

if (isset($_GET['red_id']) || isset($_POST["submit2"])) {

$sql = $link->query("SELECT `url` FROM `base` WHERE `id`={$_GET['red_id']}");
$bas = $sql->fetch(PDO::FETCH_COLUMN);
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

    $data_store = getStore0($bas);

    $data_store = addslashes(serialize($data_store));

    $link->query("UPDATE `base` SET `base` = '{$data_store}'  WHERE `id`={$_GET['red_id']}");
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
        <td class="table-p"><input type="text" name="base" value="<?php echo isset($_GET['red_id']) ? $bas : ''; ?>"></td>
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
    $sql = $link->prepare('SELECT * FROM `base`');
    $sql->execute();
    $res = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach($res as $result) {
    echo "<tr class='text-center'><th class='table-n th-color'>URL адрес:</th><td>{$result['url']}</td><th class='table-n th-color'>Команда:</th><td><a class='text-white hover' href='?red_id={$result['id']}'>Изменить</a></td></tr>";
    }
?>
</table>

</body>
</html>