<?php

add_action( 'cmb2_admin_init', 'sshop_register_post_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function sshop_register_post_metabox() {

    $metabox = new_cmb2_box( array(
        'id'            => '_sshop_page_settings',
        'title'         => esc_html__( 'Page Settings', 'sshop' ),
        'object_types'  => array( 'page' ), // Post type
        'priority'      => 'low',
        'context'       => 'side',
        'cmb_styles'    => false,
    ) );

    $metabox->add_field( array(
        'name'    => esc_html__( 'Show page title', 'sshop' ),
        'id'      => '_sshop_page_title',
        'type'    => 'select',
        'column'    => false,
        'options' => array(
            'default' => esc_html__( 'Default', 'sshop' ),
            'hide' => esc_html__( 'Hide', 'sshop' ),
            'show' => esc_html__( 'Show', 'sshop' ),
        ),
    ) );

}
