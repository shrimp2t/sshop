<?php
/**
 * Just overwrite woocommerce functions
 *
 * @file wp-content/plugins/woocommerce/includes/wc-template-functions.php
 */


/**
 * Change woocommerce get thumbnail html code
 *
 * @see woocommerce_get_product_thumbnail
 */
function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ){
    global $post;
    $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
    $html = '';
    if ( has_post_thumbnail() ) {
        $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
        $html = get_the_post_thumbnail( $post->ID, $image_size, array(
            'title'	 => $props['title'],
            'alt'    => $props['alt'],
        ) );
    } elseif ( wc_placeholder_img_src() ) {
        $html = wc_placeholder_img( $image_size );
    }

    return '<div class="product-thumbnail">'.$html.'</div>';
}



