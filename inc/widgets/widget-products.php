<?php
/**
 * Widget Product for font home page
 */
class SShop_Widget_Products extends SShop_Widget_Base {

    public $layout = 1;
    public $tax = 'product_cat';
    public $post_type = 'product';

    public function __construct() {
        parent::__construct(
            'sshop_products',
            esc_html__( 'FRONT PAGE: Products', 'sshop' ),
            array(
                'description'   => esc_html__( 'Display products, recommended for front page', 'sshop' )
            )
        );
    }

    function get_configs( ){
        $fields = array(
            array(
                'type' =>'text',
                'name' => 'title',
                'label' => esc_html__( 'Title', 'sshop' ),
            ),

            array(
                'type' =>'text',
                'name' => 'number',
                'default' => 5,
                'label' => esc_html__( 'No. of products', 'sshop' ),
            ),

            array(
                'type' =>'text',
                'name' => 'layout',
                'default' => 5,
                'label' => esc_html__( 'Items per row', 'sshop' ),
            ),

            array(
                'type' =>'select',
                'name' => 'show',
                'options' => array(
                    'all'         => esc_html__( 'All products', 'sshop' ),
                    'featured' => esc_html__( 'Featured products', 'sshop' ),
                    'onsale'   => esc_html__( 'On-sale products', 'sshop' ),
                ),
                'label' => esc_html__( 'Show', 'sshop' ),
            ),

            array(
                'type' =>'select',
                'name' => 'order',
                'options' => array(
                    'date'   => esc_html__( 'Date', 'sshop' ),
                    'price'  => esc_html__( 'Price', 'sshop' ),
                    'rand'   => esc_html__( 'Random', 'sshop' ),
                    'sales'  => esc_html__( 'Sales', 'sshop' ),
                ),
                'label' => esc_html__( 'Order', 'sshop' ),
            ),

            array(
                'type' =>'orderby',
                'name' => 'orderby',
                'label' => esc_html__( 'Order by', 'sshop' ),
            ),


        );

        return $fields;

    }

    /**
     * Query the products and return them.
     * @param  array $args
     * @param  array $instance
     * @return WP_Query
     */
    public function get_products( $instance ) {
        $number                      = ! empty( $instance['number'] ) ? absint( $instance['number'] )           : 5;
        $show                        = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] )       : 'all';
        $orderby                     = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : 'date';
        $order                       = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] )     : 'desc';
        $product_visibility_term_ids = wc_get_product_visibility_term_ids();

        $query_args = array(
            'posts_per_page' => $number,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'no_found_rows'  => 1,
            'order'          => $order,
            'meta_query'     => array(),
            'tax_query'      => array(
                'relation' => 'AND',
            ),
        );

        if ( empty( $instance['show_hidden'] ) ) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
                'operator' => 'NOT IN',
            );
            $query_args['post_parent']  = 0;
        }

        if ( ! empty( $instance['hide_free'] ) ) {
            $query_args['meta_query'][] = array(
                'key'     => '_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'DECIMAL',
            );
        }

        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['outofstock'],
                    'operator' => 'NOT IN',
                ),
            );
        }

        switch ( $show ) {
            case 'featured' :
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['featured'],
                );
                break;
            case 'onsale' :
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
        }

        switch ( $orderby ) {
            case 'price' :
                $query_args['meta_key'] = '_price';
                $query_args['orderby']  = 'meta_value_num';
                break;
            case 'rand' :
                $query_args['orderby']  = 'rand';
                break;
            case 'sales' :
                $query_args['meta_key'] = 'total_sales';
                $query_args['orderby']  = 'meta_value_num';
                break;
            default :
                $query_args['orderby']  = 'date';
        }

        return new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
    }

    public function widget( $args, $instance )
    {

        if ( ! isset( $instance['__setup_data'] ) || ! $instance['__setup_data'] === false ){
            $instance = $this->setup_instance( $instance );
        }

        $title = $instance['title'];
        unset($instance['title']);

        echo $args['before_widget'];
        $title = apply_filters( 'widget_title', $title );

        $query = $this->get_products( $instance );

        if ( $title ) {
            echo $args['before_title'].$title.$args['after_title'];
        }

        $col = $instance['layout'];
        if ( ! $col || $col > 12 ) {
            $col = 5;
        }
        ?>
        <div class="grid-products">
            <ul class="products eq-row-col-<?php echo esc_attr( $col ); ?>">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; ?>
                <?php
                wp_reset_postdata();
                ?>
            </ul>
        </div>

        <?php
        echo $args['after_widget'];
    }


}