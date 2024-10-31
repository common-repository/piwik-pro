<?php defined( 'ABSPATH' ) or exit; ?>
$( '.add_to_cart_button:not(.product_type_variable, .product_type_grouped)' ).on( 'click', function() {
    window._paq = window._paq || [];
    window._paq.push( ['ecommerceAddToCart', [{
        sku: ( $(this).data('product_sku') ) ? ( '' + $(this).data('product_sku') ) : ( '#' + $(this).data( 'product_id' ) ),
        quantity: $(this).data( 'quantity' )
    }]]);
});