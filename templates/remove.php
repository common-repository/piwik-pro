<?php defined( 'ABSPATH' ) or exit; ; ?>
$(document.body).off('click', '.remove').on('click', '.remove', function() {
    window._paq = window._paq || [];
    window._paq.push( ['ecommerceRemoveFromCart', [{
        sku: ( $(this).data('product_sku') ) ? ( '' + $(this).data( 'product_sku' ) ) : ( '#' + $(this).data( 'product_id' ) ),
        name: $(this).parent().parent().find('.product-name').text().trim() || '',
        price: $(this).parent().parent().find('.product-price').text().trim().replace(/[^0-9.]/g, '') || '',
        quantity: $(this).parent().parent().find( '.qty' ).val() ? $(this).parent().parent().find( '.qty' ).val() : '1'
    }]]);
});