<?php
/**
 * Change WC hooks
 */


// Remove star on loop product
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

function sshop_add_wishlist_btn(){
    echo do_shortcode('[yith_wcwl_add_to_wishlist]');
}
add_action( 'woocommerce_after_shop_loop_item_title', 'sshop_add_wishlist_btn', 30 );



