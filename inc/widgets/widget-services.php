<?php

class SShop_Widget_Services extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget-services',
            'description' => esc_html__( 'Display your services, recommended for front page', 'sshop' ),
        );
        parent::__construct( 'sshop_services', esc_html__( 'FRONT PAGE: Services' , 'sshop' ), $widget_ops );
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
        <div class="services-wrapper">
            <div class="services">
                <div class="eq-row-col-4">
                    <div class="eq-col service-item">
                        <div class="icon">
                            <span class="fa fa-life-ring"></span>
                        </div>

                        <div class="info">
                            <h3 class="service-title"><a href="#">24/7 support</a></h3>
                            <span>Online consultations</span>
                        </div>
                    </div>
                    <div class="eq-col service-item">
                        <div class="icon">
                            <span class="fa fa-clock-o"></span>
                        </div>

                        <div class="info">
                            <h3 class="service-title"><a href="#">30-day return</a></h3>
                            <span>Moneyback guarantee</span>
                        </div>
                    </div>
                    <div class="eq-col service-item">
                        <div class="icon">
                            <span class="fa fa-truck"></span>
                        </div>

                        <div class="info">
                            <h3  class="service-title"><a href="#">Free Shipping</a></h3>
                            <span>On order over $200</span>
                        </div>
                    </div>
                    <div class="eq-col service-item">
                        <div class="icon">
                            <span class="fa fa-shield"></span>
                        </div>
                        <div class="info">
                            <h3  class="service-title"><a href="#">Safe Shopping</a></h3>
                            <span>Safe Shopping Guarantee</span>
                        </div>
                    </div>
                </div>
            </div>
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
