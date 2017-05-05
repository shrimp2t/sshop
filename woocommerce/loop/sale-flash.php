<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
if ( $product->is_on_sale() ) {
    ?>
    <div class="onsale">
    <?php
    if ( $product->get_type() == 'variable') {

        $available_variations = $product->get_available_variations();
        $max = 0;
        $min = 0;
        foreach( $available_variations as $vr ) {
            if ( $vr['regular_price'] > 0 && $vr['sale_price'] > 0 ) {
                $percentage = round(((($vr['regular_price'] - $vr['sale_price']) / $vr['regular_price']) * 100), 1);
                if ($min > $percentage) {
                    $min = $percentage;
                }
                if ( $max < $percentage) {
                    $max = $percentage;
                }
            }
        }
        printf( esc_html_x( '-%s%%', 'price save value', 'sshop' ), $max );
    } elseif ( $product->get_type() == 'simple' ) {
        $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
        printf( esc_html_x( '-%s%%', 'price save value', 'sshop' ), $percentage );
    }
    ?>
    </div>
    <?php

}