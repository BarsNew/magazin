


$(function() {

    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        console.log(id);

        $.ajax({
            url: '/app/cart.php',
            type: 'GET',
            dataType: 'json',
            data: {cart: 'add', id: id},

            success: function (res) {
                if (res.code == 'ok') {
                    alert('OK');

                   // console.log(res);
                } else {
                    alert(res.answer);
                }
            },
            error: function () {
                alert("Произошла ошибка");
            }

        });

    });







    $('.del-to-cart').on('click', function (e) {
        e.preventDefault();
        let id = $(this).data('id');

        console.log(id);

        $.ajax({
            url: '/app/cart.php',
            type: 'GET',
            dataType: 'json',
            data: {cart: 'del', id: id},

            success: function (res) {
                if (res.code == 'ok') {
                    alert('Товар удален');

                    console.log(res);
                } else {
                    alert(res.answer);
                }
            },
            error: function () {
                alert("Произошла ошибка");
            }

        });

    });










    

});

