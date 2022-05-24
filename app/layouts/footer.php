<div class="footer">
    <div class="footer-item">
        <p class="color-bez">АДРЕС 1</p>
        <p>ул. Либкнехта 500<br />
        г. Минск<br />
        Беларусь<br />
        +375 29 500 00 00
        </p>
    </div>
    
    <div class="footer-item">
        <p class="color-bez">АДРЕС 2</p>
        <p>ул. Немига 900<br />
        г. Минск<br />
        Беларусь<br />
        +375 29 900 00 00
        </p>
    </div>

    <div class="footer-item">
        <p class="color-bez">ПОЧТА</p>
        <p>Генеральный директор<br />
        brand@mail.com   
        </p>
    </div>
</div>

<p class="copy">&copy; 2022 website by</p>
<?php 
$url = explode('?', $_SERVER['REQUEST_URI']);
$result = $url[0];
if ($result == '/catalog' || $result == '/catalog/') { ?> 
<span id='quantity1' class="quantity">в<br /><br />к<br />о<br />р<br />з<br />и<br />н<br />е<br /><br /><span id='quantity'><?php echo ($_SESSION['q'])??0; ?></span></span>
<?php } ?>
</body>
</html>