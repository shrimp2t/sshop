<?php
/**
 * Hook in on activation
 */

/**
 * Define image sizes
 */
function sshop_woocommerce_image_dimensions() {
    global $pagenow;

    if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
        return;
    }

    $catalog = array(
        'width' 	=> '300',	// px
        'height'	=> '366',	// px
        'crop'		=> 1 		// true
    );

    $single = array(
        'width' 	=> '600',	// px
        'height'	=> '600',	// px
        'crop'		=> 1 		// true
    );

    $thumbnail = array(
        'width' 	=> '180',	// px
        'height'	=> '180',	// px
        'crop'		=> 1 		// false
    );

    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    update_option( 'shop_single_image_size', $single ); 		// Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_action( 'after_switch_theme', 'sshop_woocommerce_image_dimensions', 1 );


