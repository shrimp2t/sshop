<?php
/**
 * Change WC hooks
 */


// Remove star on loop product
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );


