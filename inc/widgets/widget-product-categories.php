<?php

class SShop_Widget_Product_Categories extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget-shop-categories',
            'description' => esc_html__( 'Display your product categories', 'sshop' ),
        );
        parent::__construct( 'sshop_product_categories', esc_html__( 'Product Categories' , 'sshop' ), $widget_ops );
    }

    function maybe_list_child( $parent_id, $terms, $num_child = -1 ){
        if ( $num_child == 0 ) {
            return false;
        }

        $list = '';
        if ( $num_child < 0 ) {
            foreach ($terms as $t) {
                if ($t->parent == $parent_id) {
                    $list .= '<li><a href="' . get_term_link($t) . '">' . esc_html($t->name) . '</a></li>';
                }
            }

            if ( $list ) {
                echo "<ul class='child'>".$list.'</ul>';
            }

        } else {
            $j = 0;
            foreach ($terms as $t) {
                if ($t->parent == $parent_id) {

                    $list .= '<li><a href="' . get_term_link($t) . '">' . esc_html($t->name) . '</a></li>';
                    $j ++ ;

                    if ( $num_child == $j ) {
                        if ( $list ) {
                            echo "<ul class='child'>".$list.'</ul>';
                        }

                        return false;
                    }

                }
            }
        }

    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget

        $instance = wp_parse_args( $instance, array(
            'columns'    => 4,
            'num_child' => 0,
        ) );

        echo $args['before_widget'];
        $terms = get_terms( array( 'taxonomy' => 'product_cat', 'hierarchical' => true ) );
        ?>
        <ul class="list-shop-cats eq-row-col-<?php echo esc_attr( $instance['columns'] ); ?>">
            <?php foreach ( $terms as $t ) { ?>
                <?php if ( $t->parent == 0 ) { ?>
                <li class="eq-col top-lv-1">
                    <span class="top-p-cat">
                        <span class="cat-name"><?php echo esc_html( $t->name ); ?></span>
                        <a class="cat-link btn btn-secondary btn-sm" href="<?php echo get_term_link( $t ); ?>"><?php esc_html_e( 'Shop now', 'sshop' ); ?></a>
                    </span>
                    <?php
                    $this->maybe_list_child( $t->term_id, $terms, $instance['num_child'] );
                    ?>
                </li>
                <?php } ?>
            <?php } ?>
        </ul>
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
