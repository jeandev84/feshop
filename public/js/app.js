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