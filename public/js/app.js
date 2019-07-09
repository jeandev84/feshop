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


/**
 * Show cart
 *
 * @param cart
 */
function showCart(cart)
{
     if($.trim(cart) == '<h3>Корзина пуста</h3>')
     {
          $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'none');

     }else{
          $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'inline-block');
     }

     // show modal and append template app/views/Cart/cart_modal.php
     $('#cart .modal-body').html(cart);
     $('#cart').modal();

     // Update mini cart , when we add product
     if($('.cart-sum').text())
     {
          $('.simpleCart_total').html($('#cart .cart-sum').text());

     }else{

          $('.simpleCart_total').text('Empty Cart');

     }
}


/**
 * Get Cart
 */
function getCart() {
     $.ajax({
          url: '/cart/show',
          type: 'GET',
          success: function(res){
               showCart(res);
          },
          error: function(){
               alert('Ошибка! Попробуйте позже');
          }
     });
}


/**
 * Delete Concret Ordered Product from Cart
 */
$('#cart .modal-body').on('click', '.del-item', function(){
     var id = $(this).data('id');
     $.ajax({
          url: '/cart/delete',
          data: {id: id},
          type: 'GET',
          success: function(res)
          {
               showCart(res);
          },
          error: function(){
               alert('Error!');
          }
     });
});


/**
 * Clear Cart
 */
function clearCart() {
     $.ajax({
          url: '/cart/clear',
          type: 'GET',
          success: function(res){
               showCart(res);
          },
          error: function(){
               alert('Ошибка! Попробуйте позже');
          }
     });
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