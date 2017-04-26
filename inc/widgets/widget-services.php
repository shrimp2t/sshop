<?php

class SShop_Widget_Services extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget-services',
            'description' => esc_html__( 'Display your services', 'sshop' ),
        );
        parent::__construct( 'sshop_services', esc_html__( 'Services' , 'sshop' ), $widget_ops );
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
            <div class="services ">
                <div class="row">
                    <div class="col-xs-12 com-sm-6 col-md-3 service-item">
                        <div class="icon">
                            <img src="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s31.png" class="attachment-40x40 size-40x40 wp-post-image" alt="" srcset="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s31.png 38w, http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s31-20x20.png 20w" sizes="(max-width: 38px) 100vw, 38px" width="38" height="40">                            </div>

                        <div class="info">
                            <a href="http://kutethemes.net/wordpress/kuteshop/option1/service/247-support/"><h3>24/7 support</h3></a>
                            <span>Online consultations</span>
                        </div>
                    </div>
                    <div class="col-xs-12 com-sm-6 col-md-3 service-item">
                        <div class="icon">
                            <img src="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s21.png" class="attachment-40x40 size-40x40 wp-post-image" alt="" srcset="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s21.png 40w, http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s21-20x20.png 20w" sizes="(max-width: 40px) 100vw, 40px" width="40" height="40">                            </div>

                        <div class="info">
                            <a href="http://kutethemes.net/wordpress/kuteshop/option1/service/30-day-return/"><h3>30-day return</h3></a>
                            <span>Moneyback guarantee</span>
                        </div>
                    </div>
                    <div class="col-xs-12 com-sm-6 col-md-3 service-item">
                        <div class="icon">
                            <img src="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s11.png" class="attachment-40x40 size-40x40 wp-post-image" alt="" srcset="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s11.png 37w, http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s11-20x20.png 20w" sizes="(max-width: 37px) 100vw, 37px" width="37" height="37">                            </div>

                        <div class="info">
                            <a href="http://kutethemes.net/wordpress/kuteshop/option1/service/free-shipping/"><h3>Free Shipping</h3></a>
                            <span>On order over $200</span>
                        </div>
                    </div>
                    <div class="col-xs-12 com-sm-6 col-md-3 service-item">
                        <div class="icon">
                            <img src="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/s41.png" class="attachment-40x40 size-40x40 wp-post-image" alt="" width="37" height="40">                            </div>

                        <div class="info">
                            <a href="http://kutethemes.net/wordpress/kuteshop/option1/service/safe-shopping/"><h3>Safe Shopping</h3></a>
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
