<?php
/**
 * Change WC hooks
 */


// Remove star on loop product
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );


// Remove deafault btn
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
/**
 * Add wishlist button
 */
function sshop_add_wishlist_btn(){
    if ( defined( 'YITH_WCWL' ) ) {
        echo do_shortcode('[yith_wcwl_add_to_wishlist]');
    }
}

// New button position
add_action( 'woocommerce_shop_loop_item_btn', 'sshop_add_wishlist_btn', 30 );
add_action( 'woocommerce_shop_loop_item_btn', 'woocommerce_template_loop_add_to_cart', 10 );


