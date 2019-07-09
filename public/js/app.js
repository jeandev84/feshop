/**
 * Cart [ Add to cart ]
 */

$('body').on('click', '.add-to-cart-link', function (e) {
    e.preventDefault();

    var id = $(this).data('id'),
        qty = $('.quantity input').val() ? $('.quantity input').val() : 1,
        mod = $('.available select').val(); // modification

    /* console.log(id, qty, mod); */

     // request ajax
     $.ajax({
          url: '/cart/add',
          data: {id: id, qty: qty, mod: mod},
          type: 'GET',
          success: function (res) {
               showCart(res);
          },
          error: function () {
               alert('Ошибка ! Попробуйте позже');
          }
     });
});


//
function showCart(cart)
{
   console.log(cart);
}


/** End Cart */




/**
 * Relocate target currency
 */
$('#currency').change(function () {

     window.location = 'currency/change?curr=' + $(this).val();
    /* console.log($(this).val()); */
});




/**
 * Modification for change color on product/view
 */
$('.available select').on('change', function () {

     var modId = $(this).val(),
         color = $(this).find('option').filter(':selected').data('title'),
         price = $(this).find('option').filter(':selected').data('price'),
         basePrice = $('#base-price').data('base');

     // 5 Silver 80
     // 6 Red 70
     // console.log(modId, color, price);

     if(price)
     {
         $('#base-price').text(symbol_left + price + symbol_right);

     }else{

          $('#base-price').text(symbol_left + basePrice + symbol_right);
     }

});