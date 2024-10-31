<?php defined( 'ABSPATH' ) or exit; ?>
$( '.single_add_to_cart_button' ).on( 'click', function() {
    window._paq = window._paq || [];

    var sku = '<?php echo $sku; ?>';
    var name = '<?php echo $name; ?>';
    var price = <?php echo $price; ?>;

    if( $( 'input[name="variation_id"]' ).val() ) {
        var variant = $( 'input[name="variation_id"]' ).val();
        $.each( $( '.variations_form' ).data( 'product_variations' ), function( index, product ) {
            if( product.variation_id == $( 'input[name="variation_id"]' ).val() ) {
                if( product.hasOwnProperty( 'sku' ) ) { sku = product.sku; }
                if( product.hasOwnProperty( 'display_price' ) ) { price = product.display_price; }

                if( product.hasOwnProperty( 'attributes' ) ) {
                    name += ' - ';
                    var i = 0;
                    var length = Object.keys(product.attributes).length;
                    $.each( product.attributes, function( index, attribute ) {
                        name += attribute;
                        if( length !== ++i ) { name += ', '; }
                    });
                }
        }});
    }

    window._paq.push( ['ecommerceAddToCart', [{
        sku: '' + sku,
        name: name,
        category: <?php echo json_encode( $category ); ?>,
        price: price,
        quantity: $('input.qty').val() ? $('input.qty').val() : 1
    }]]);
});