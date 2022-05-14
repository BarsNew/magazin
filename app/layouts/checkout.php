<?php

require_once './app/functions.php';
require_once './app/cart.php';

if (isset($_GET['cart']) || isset($_SESSION['cart'])) {

    $basket = $_SESSION['cart'];

    $fullcart = [];

    foreach($basket as $number) {
        $fullcart[] = getStore($number);
    
    }

    $sum = 0;
    $quantity = 0;
    $fullcart2 = [];
    $inf = [];
    foreach($fullcart as &$summa) {
        $summa['volume'] = '0';
        $sum += $summa['price'];
        $quantity++;
        $fullcart2[] = $summa;
        for ($i = 0; $i < count($fullcart); $i++) {
                if ($fullcart2[$i]['id'] == $summa['id']) {
                    ++$fullcart2[$i]['volume'];
                    
                }
        }
    }

    unset($summa);

    $fullcart3 = unique_multidim_array($fullcart2, 'id');

    $_SESSION['summa'] = $sum;
    $_SESSION['q'] = $quantity;

        if ($_GET['cart'] == 'del')  {

            $type = gettype($id);     
     
                $newCart2 = [];

                $x = 0;
                foreach( $_SESSION['cart'] as $ttt) {
                    if ($_GET['id'] == $ttt) {
                        ++$x;
                        if ($x == 1) continue;
                        $newCart2 [] = $ttt;

                    } else {
                        $newCart2 [] = $ttt;
                    }
            }
                $_SESSION['cart'] = $newCart2;

                header('Location: /checkout');
                exit;
        }

if (!empty($_GET['un'])) {

    $_SESSION['cart'] = []; 
    header('Location: /checkout');
                exit;   
}
 
    $checkout = '';

    foreach($fullcart3 as $product) {
        $checkout .= '
        <div class="catalog__product">
            <form action="/checkout" method="get">
                <input type="hidden" name="form_cart_product_id" value="' . $product['id'] . '">
                <img style="width: 100px;" src="' . $product['image'] . '" alt="' . $product['title'] . '">              
                <span class="checkout_product_price">$' . $product['price'] . '</span>
                <h3><a href="/catalog/' . $product['id'] . '/">' . $product['title'] . '</a></h3>
            
                <a href="/checkout' . '?cart=add&id=' . $product['id'] . '"  data-id="' . $product['id'].'">Добавить</a>

                <p>Количество: ' . $product['volume'] . '</p> 
                
                <a href="/checkout' . '?cart=del&id=' . $product['id'] . '"  data-id="' . $product['id'].'">Удалить</a>

            </form>
        </div>
        ';
    }
}

?>

<main class="main">
    <div class="container">
        <?php if ($path != 'home') echo '<h1 class="main-h1">' . $data['header'] . '</h1>'; ?>   
        
        <?php if (!empty($_SESSION['cart'])) { ?>

            <div class="checkout"> 

                <div class="checkout-item-1">
                <?php echo $checkout; ?> 
                </div>

                <div class="checkout-item-2">
                    <div class="sticky-form">
                <form name="form" action="/app/form.php" method="POST">        
                    <p class="checkout_summary">ОБЩАЯ СУММА: -- <?php echo $_SESSION['summa']; ?> $ --</p>
                    <p class="checkout_summary">ОБЩЕЕ КОЛИЧЕСТВО: -- <?php echo $_SESSION['q']; ?> --</p> 
                         
                <input type="hidden" name="page" value="checkout">
                <div class="form-div">
                <p>Имя: *</p>
                    <input required type="text" name="name" minlength="2" maxlength="20" placeholder="Иван" />
                </div>
                <div class="form-div">
                <p>Пол:</p>
                    <input type="radio" name="gender" value="man" /> Мужской <br />
                    <input type="radio" name="gender" value="female" /> Женский
                </div>
                <div class="form-div">
                <p>Телефон: *</p>
                    <input required type="tel" name="phone" minlength="9" maxlength="17" placeholder="+375 00 000 00 00" />
                </div>
                <div class="form-div">
                <p>Электронная почта:</p>
                <input type="email" name="email" placeholder="adress@mail.com" />
                </div>
                
                <div class="form-div">
                <p>Город проживания, в случае доставки:</p>
                <select name="city">
                    <option>&nbsp;</option>
                    <option>Минск</option>
                    <option>Брест</option>
                    <option>Витебск</option>
                    <option>Гродно</option>
                    <option>Гомель</option>
                    <option>Могилев</option>
                    <option>Другой</option>
                </select>
                </div>
                <div class="form-div">
                <input class="checkbox" required type="checkbox" name="agree" /> Согласен на обработку данных *
                </div>
                <div class="form-div">
                    <button class="form-but-red" type="reset">Очистить</button>
                    <button name="button-checkout" value="ok">Отправить</button>
                </div>
            </form>                      
                </div> 
            </div>

        </div>

        <form class="cart-clear" action="/checkout" method="get">
                <a href="/checkout?un=ok" >Очистить корзину</a>
        </form>
            
        <?php } else { ?>
            <p class="cart-none"><a href="/catalog">Cмотрите товар в нашем каталоге</a><br />Корзина пуста</p>
        <?php } ?>
</main>