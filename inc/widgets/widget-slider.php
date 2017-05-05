<?php

class SShop_Widget_Slider extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget-slider',
            'description' => esc_html__( 'Display your slider, recommended for front page', 'sshop' ),
        );
        parent::__construct( 'sshop_slider', esc_html__( 'FRONT PAGE: Slider' , 'sshop' ), $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget

        echo $args['before_widget'];
        ?>
        <div class="slider-wrapper">
            <?php
            echo do_shortcode( "[slide-anything id='488']" );
            ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
    }
}
