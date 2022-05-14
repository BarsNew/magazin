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
                    $numb2 .= 'Id товара: ' . $y . ', количество: ' . $i . '. '; 
                }

                $query = $numb2 .
                'Общее количество: ' . $_SESSION['q'] .
                '. Вся сумма ' . $_SESSION['summa'] 
                ;
            }
        } else if (!empty($_POST['button'])) {
            $query = htmlspecialchars($_POST['query']) ?? false;
            $query = stripslashes($query);
        }

        $sqlquery = "INSERT INTO `clients`
        (`id`, `page`, `name`, `gender`, `phone`, `email`, `query`, `city`, `date`)
        VALUES (NULL, '$page', '$name', '$gender', '$phone', '$email', '$query', '$city', UNIX_TIMESTAMP())";


        $sqlform = mysqli_query($link, $sqlquery);  

        if (!empty($sqlform) && !empty($_POST['button'])) {
            echo "<p>Форма отправлена</p><p>С вами свяжутся через некоторое время наши менеджеры</p><p>Переход на страницу контакты будет через 10 секунд</p>";
            header( 'Refresh: 10; URL=/contacts' );
            exit;
        } else if (!empty($sqlform) && !empty($_POST['button-checkout'])) {
            echo "<p>Форма отправлена</p><p>С вами свяжутся через некоторое время наши менеджеры</p><p>Переход на страницу каталог будет через 10 секунд</p>";
            $_SESSION['cart'] = [];
            header( 'Refresh: 10; URL=/catalog' );
            exit;
        } else {
            echo '<p>Произошла ошибка, просим связаться с менеджерами по телефонам"</p><p>Переход на страницу контакты будет через 10 секунд</p>';
            header( 'Refresh: 10; URL=/contacts' );
        }
}
?>

</body>