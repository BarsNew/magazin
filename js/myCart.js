function addToCart(id) {
    console.log('add ' + id);
    $.ajax({
        async: false,
        type: "POST",
        url: "/app/cart.php",
        dataType: "text",
        data: 'action=add&id=' + id,
        error: function () {
            alert("Произошла ошибка");
        }   
    });
}