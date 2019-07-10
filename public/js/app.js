/**----------------------------------------------------------
 * Filters
 -----------------------------------------------------------*/
$('body').on('change', '.w_sidebar input', function(){
     var checked = $('.w_sidebar input:checked'),
         data = '';

     // console.log(checked);

     checked.each(function () {
          data += this.value + ',';
     });

     // console.log(data);
     if(data)
     {
          $.ajax({
               url: location.href,
               data: {filter: data},
               type: 'GET',
               beforeSend: function()
               {
                    $('.preloader').fadeIn(300, function(){
                         $('.product-one').hide();
                    });
               },
               success: function(res)
               {
                    $('.preloader').delay(500).fadeOut('slow', function(){
                         $('.product-one').html(res).fadeIn();

                         // Без пезагрузки страницы
                         // и все что было в адрессный строке сохранилось, запомнялось и учитивалось
                         // сохранение будет в history [ читать про history JS ]
                         // history позволяет менять соддержимое браузера
                         // http://eshop.loc/category/elektronnye?filter=1,6,

                         var url = location.search.replace(/filter(.+?)(&|$)/g, ''); //$2
                         var newURL = location.pathname + url + (location.search ? "&" : "?") + "filter=" + data;
                         newURL = newURL.replace('&&', '&');
                         newURL = newURL.replace('?&', '?');
                         history.pushState({}, '', newURL);
                    });
               },
               error: function () {
                    alert('Ошибка!');
               }
          });
     }else{
          // перепросить страничку
          window.location = location.pathname;
     }
});


/**----------------------------------------------------------
 * Search Bar [ Using Plugin typeahead ]
 -----------------------------------------------------------*/

var products = new Bloodhound({
     datumTokenizer: Bloodhound.tokenizers.whitespace,
     queryTokenizer: Bloodhound.tokenizers.whitespace,
     remote: {
          wildcard: '%QUERY', // marker will be replaced by query %QUERY
          url: path + '/search/typeahead?query=%QUERY'
     }
});

products.initialize();

$("#typeahead").typeahead({
     // hint: false,
     highlight: true
},{
     name: 'products',
     display: 'title',
     limit: 10,
     source: products
});

$('#typeahead').bind('typeahead:select', function(ev, suggestion) {
     // console.log(suggestion);
     window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});


/**----------------------------------------------
 * Cart Product [ Корзина Товара ]
 ------------------------------------------**/

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



/**--------------------------------------------------------
 * Relocate target currency
 ----------------------------------------------------------*/
$('#currency').change(function () {

     window.location = 'currency/change?curr=' + $(this).val();
    /* console.log($(this).val()); */
});




/** --------------------------------------------------------
 * Modification for change color on product/view
 -----------------------------------------------------------*/
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


