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
                alert(res.answer);
            },
            error: function () {
                alert("Произошла ошибка");
            }
        });
    });

});

      
function newImg()
{
let obj_div=document.getElementById("hom-img");
obj_div.innerHTML='<img src="/images/odejda.jpg" alt="" />';
}

function newImg1()
{
let obj_div1=document.getElementById("hom-img"); 
obj_div1.innerHTML='<img src="/images/obuv.jpg" alt="" />';
}

function newImg2()
{
let obj_div2=document.getElementById("hom-img"); 
obj_div2.innerHTML='<img src="/images/chasy.jpg" alt="" />';
}

function newImg3()
{
let obj_div3=document.getElementById("hom-img"); 
obj_div3.innerHTML='<img src="/images/sumka.jpg" alt="" />';
}

function newImg4()
{
let obj_div4=document.getElementById("hom-img"); 
obj_div4.innerHTML='<img src="/images/duhi.jpg" alt="" />';
}

function newImg5()
{
let obj_div5=document.getElementById("hom-img"); 
obj_div5.innerHTML='<img src="/images/kolca.jpg" alt="" />';
}

function backImg()
{
obj_div=document.getElementById("hom-img");
obj_div.innerHTML='<img src="/images/Sea_Sunrises.jpg" alt="" />';
}
 
