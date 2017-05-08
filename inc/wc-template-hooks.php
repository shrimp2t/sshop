<?php
/**
 * Change WC hooks
 */

add_filter( 'woocommerce_enqueue_styles', 'sshop_dequeue_styles' );
/**
 * Disable layout css
 *
 * @param $enqueue_styles
 * @return mixed
 */
function sshop_dequeue_styles( $enqueue_styles ) {
    //unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
    unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
    //unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
    return $enqueue_styles;
}


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


// Change number product to show
function sshop_number_products_to_show(){
    return 24;
}
add_filter( 'loop_shop_per_page','sshop_number_products_to_show', 20 );

// Do not show shop title
add_filter( 'woocommerce_show_page_title', '__return_false' );


