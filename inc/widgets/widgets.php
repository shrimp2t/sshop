<?php

/**
 * Enqueue Admin Scripts
 */
function sshop_media_scripts( $hook ) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    // Color picker Style
    wp_enqueue_style( 'wp-color-picker' );

    // Update CSS within in Admin
    wp_enqueue_style( 'sshop-widgets', get_template_directory_uri() . '/inc/widgets/widgets.css' );

    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'sshop-media-upload-js', get_template_directory_uri() . '/inc/widgets/widgets.js', array( 'jquery' ), '', true );

}
add_action( 'admin_enqueue_scripts', 'sshop_media_scripts' );




// Register widgets
function sshop_register_widgets() {

    register_widget( 'SShop_Widget_Product_Tabs' );
    register_widget( 'SShop_Widget_Brand_Products' );
    register_widget( 'SShop_Widget_Services' );

}
add_action( 'widgets_init', 'sshop_register_widgets' );
