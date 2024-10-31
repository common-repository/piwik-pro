<?php defined( 'ABSPATH' ) or exit; ; ?>
window._paq = window._paq || [];
window._paq.push( ['ecommerceProductDetailView', [{
    sku: '<?php echo $sku; ?>',
    name: '<?php echo $name; ?>',
    category: <?php echo json_encode( $category ); ?>,
    price: '<?php echo $price; ?>',
    quantity: $( 'input.qty' ).val() ? $( 'input.qty' ).val() : 1
}]]);