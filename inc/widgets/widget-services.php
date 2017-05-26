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

        $instance = wp_parse_args( $instance, $this->default_data() );

        $html = '';
        $n = 0;
        for ( $i = 0; $i< 6; $i ++ ) {
            $id_title = 'service_' . $i . '_title';
            $id_tagline = 'service_' . $i . '_tagline';
            $id_icon = 'service_' . $i . '_icon';
            $id_link = 'service_' . $i . '_link';

            if (!isset($instance[$id_title])) {
                $instance[$id_title] = '';
            }
            if (!isset($instance[$id_tagline])) {
                $instance[$id_tagline] = '';
            }
            if (!isset($instance[$id_icon])) {
                $instance[$id_icon] = '';
            }
            if (!isset($instance[$id_link])) {
                $instance[$id_link] = '';
            }

            if ( $instance[$id_title] ) {
                $n ++ ;
                $html.= '<div class="eq-col service-item">';

                    $instance[$id_icon] = trim( $instance[$id_icon] );
                    // Check if icon
                    if (  $instance[$id_icon] ) {
                        $html .= '<div class="icon">';
                        if (strpos($instance[$id_icon], '<') === 0) { // if icon is html
                            $html .= wp_kses_post( $instance[$id_icon] );
                        } else {
                            $html .= '<span class="' . esc_attr($instance[$id_icon]) . '"></span>';
                        }
                        $html.= '</div>';
                    }

                    $html .= '<div class="info">';
                        $html .= '<h3 class="service-title"><a href="'.esc_url( $instance[$id_link] ? $instance[$id_link] : '#' ).'">'.wp_kses_post( $instance[$id_title] ).'</a></h3>';
                        $html .= '<span>'.wp_kses_post( $instance[$id_tagline] ).'</span>';
                    $html.= '</div>';


                $html.= '</div>'; // end eq-col
            }
        }
        ?>
        <div class="services-wrapper">
            <div class="services">
                <div class="eq-row-col-<?php echo esc_attr( $n ); ?>">
                    <?php
                     echo $html;
                    ?>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    function default_data(){
        return array(

            'service_0_title' => esc_html__( '24/7 support', 'sshop' ),
            'service_0_tagline' => esc_html__( 'Online consultations', 'sshop' ),
            'service_0_icon' => 'fa fa-life-ring',
            'service_0_link' => '',

            'service_1_title' => esc_html__( '30-day return', 'sshop' ),
            'service_1_tagline' => esc_html__( ' Moneyback guarantee', 'sshop' ),
            'service_1_icon' => 'fa fa-clock-o',
            'service_1_link' => '',

            'service_2_title' => esc_html__( 'Free Shipping', 'sshop' ),
            'service_2_tagline' => esc_html__( 'On order over $200', 'sshop' ),
            'service_2_icon' => 'fa fa-truck',
            'service_2_link' => '',

            'service_3_title' => esc_html__( 'Safe Shopping', 'sshop' ),
            'service_3_tagline' => esc_html__( ' Safe Shopping Guarantee', 'sshop' ),
            'service_3_icon' => 'fa fa-shield',
            'service_3_link' => '',
        );
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {

        $instance = wp_parse_args( $instance,  $this->default_data() );

        for ( $i = 0; $i< 6; $i ++ ) {
            $id_title = 'service_'.$i.'_title';
            $id_tagline = 'service_'.$i.'_tagline';
            $id_icon = 'service_'.$i.'_icon';
            $id_link = 'service_'.$i.'_link';

            if ( ! isset( $instance[ $id_title ] ) ) {
                $instance[ $id_title ] = '';
            }
            if ( ! isset( $instance[ $id_tagline ] ) ) {
                $instance[ $id_tagline ] = '';
            }
            if ( ! isset( $instance[ $id_icon ] ) ) {
                $instance[ $id_icon ] = '';
            }
            if ( ! isset( $instance[ $id_link ] ) ) {
                $instance[ $id_link ] = '';
            }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( $id_title ); ?>"><?php echo sprintf( esc_html__( 'Service %s title', 'sshop'), ( $i+1 ) ); ?></label><br/>
                <input class="widefat" type="text" value="<?php echo esc_attr( $instance[$id_title] ); ?>" id="<?php echo $this->get_field_id( $id_title ); ?>" name="<?php echo $this->get_field_name( $id_title ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( $id_tagline ); ?>"><?php echo sprintf( esc_html__( 'Service %s subtitle', 'sshop'), ( $i+1 ) ); ?></label><br/>
                <input class="widefat" type="text" value="<?php echo esc_attr( $instance[$id_tagline] ); ?>" id="<?php echo $this->get_field_id( $id_tagline ); ?>" name="<?php echo $this->get_field_name( $id_tagline ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( $id_icon ); ?>"><?php echo sprintf( esc_html__( 'Service %s icon', 'sshop'), ( $i+1 ) ); ?></label><br/>
                <input class="widefat" type="text" value="<?php echo esc_attr( $instance[$id_icon] ); ?>" id="<?php echo $this->get_field_id( $id_icon ); ?>" name="<?php echo $this->get_field_name( $id_icon ); ?>">
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( $id_link ); ?>"><?php echo sprintf( esc_html__( 'Service %s URL', 'sshop'), ( $i+1 ) ); ?></label><br/>
                <input class="widefat" type="text" value="<?php echo esc_attr( $instance[$id_link] ); ?>" id="<?php echo $this->get_field_id( $id_link ); ?>" name="<?php echo $this->get_field_name( $id_link ); ?>">
            </p>
            <hr/>
            <?php
        }
        ?>
        <p class="description">
            <?php esc_html_e( 'You can paste icon class name or HTML code for icon field', 'sshop' ); ?>
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved

        for ( $i = 0; $i< 6; $i ++ ) {
            $id_title = 'service_' . $i . '_title';
            $id_tagline = 'service_' . $i . '_tagline';
            $id_icon = 'service_' . $i . '_icon';
            $id_link = 'service_' . $i . '_link';

            $new_instance[$id_title]    = wp_kses_post( $new_instance[ $id_title ] );
            $new_instance[$id_tagline]  = wp_kses_post( $new_instance[ $id_tagline ] );
            $new_instance[$id_icon]     = wp_kses_post( $new_instance[ $id_icon ] );
            $new_instance[$id_link]     = esc_url( $new_instance[ $id_link ] );

        }

        return $new_instance;
    }
}
