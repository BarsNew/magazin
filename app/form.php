<?php session_start(); ?>

<body style="text-align: center; font-size: 40px; margin: 90px 0; background-color: #000; color: #fff;">

<?php 
if (!empty($_POST['button']) || !empty($_POST['button-checkout'])) {

        require_once '../config.php';

        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);  
        
        if (!$link) {
            echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
            exit;
        }

        $page = htmlspecialchars($_POST['page']) ?? false;
        $name = htmlspecialchars($_POST['name']) ?? false;
        $gender = htmlspecialchars($_POST['gender']) ?? false;
        $phone = htmlspecialchars($_POST['phone']) ?? false;
        $email = htmlspecialchars($_POST['email']) ?? false;
        $city = htmlspecialchars($_POST['city']) ?? false;

        $page = stripslashes($page);
        $name = stripslashes($name);
        $gender = stripslashes($gender);
        $phone = stripslashes($phone);
        $email = stripslashes($email);
        $city = stripslashes($city);

        if (!empty($_POST['button-checkout'])) {
            if (!empty($_SESSION['cart'])) {
                
                $numb = array_count_values($_SESSION['cart']);
                $numb2 = '';
                foreach($numb as $y => $i) {
                    $numb2 .= ' --- ID товара: ' . $y . ', количество: ' . $i; 
                }

                $query = $numb2 .
                '. ОБЩЕЕ КОЛИЧЕСТВО: ' . $_SESSION['q'] .
                '. ВСЯ СУММА: ' . $_SESSION['summa'] . '.' 
                ;
            }
        } else if (!empty($_POST['button'])) {
            $query = htmlspecialchars($_POST['query']) ?? false;
            $query = stripslashes($query);
        }

        $sqlquery = "INSERT INTO `clients`
        (`id`, `page`, `name`, `gender`, `phone`, `email`, `query`, `city`, `date`)
        VALUES (NULL, '$page', '$name', '$gender', '$phone', '$email', '$query', '$city', UNIX_TIMESTAMP())";

        $zakaz = time();

        $sqlform = mysqli_query($link, $sqlquery);  

        // Отправка на почту админа
        
        if (!empty($email)) $email2 = $email;
        else $email2 = false;
        $email3 = (!empty($email)) ? $email : 'не указана';

        $to = "Bars11021988@mail.ru";
        $subject = 'Заказ ' . $zakaz . ' от ' . date('Y-m-d H:i:s');
        $message = 'Клиент ' . $name . ' с страницы ' . $page . ', телефон ' . $phone . ', почта ' . $email3 . '. Сообщение/заказ: ' . $query;

        $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
        if (!empty($email2)) {
        $headers .= "From: $email2 <$email2>\r\n"; 
        $headers .= "Reply-To: $email2\r\n"; 
        }
        $mailadmin = mail($to, $subject, $message, $headers); 
        
        //Отправка клиенту

        if (!empty($mailadmin) && !empty($email2)) {
            $t = $email2;
            $subjec = 'Заказ в магазине BRAND';
            $messag = "Номер заказа $zakaz от " . date('Y-m-d H:i:s') . '.' . ' Ваша заявка принята. Наш менеджер свяжется с вами в ближайшее время.' ;

            $header  = "Content-type: text/html; charset=utf-8 \r\n"; 
            $header .= "From: $to <$to>\r\n"; 
            $header .= "Reply-To: $to\r\n"; 

            mail($t, $subjec, $messag, $header); 
        }

        if (!empty($sqlform) && !empty($_POST['button']) && !empty($mailadmin)) {
            echo "<p>Форма отправлена</p><p>С вами свяжутся через некоторое время наши менеджеры</p><p>Переход на страницу контакты будет через 5 секунд</p>";
            header( 'Refresh: 5; URL=/contacts' );
            exit;
        } else if (!empty($sqlform) && !empty($_POST['button-checkout']) && !empty($mailadmin)) {
            echo "<p>Форма отправлена</p><p>С вами свяжутся через некоторое время наши менеджеры</p><p>Переход на страницу каталог будет через 5 секунд</p>";
            $_SESSION['cart'] = [];
            $_SESSION['q'] = 0;
            header( 'Refresh: 5; URL=/catalog' );
            exit;
        } else {
            echo '<p>Произошла ошибка, просим связаться с менеджерами по телефонам"</p><p>Переход на страницу контакты будет через 5 секунд</p>';
            header( 'Refresh: 5; URL=/contacts' );
        }
}
?>

</body>