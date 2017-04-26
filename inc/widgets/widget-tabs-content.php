<?php
/**
 * Easemag tabs content
 */
class SShop_Tabs_Content extends WP_Widget {

    public $layout;
    public $tax;
    public $post_type;
    public $layout_class;


    public function __construct( $id_base = '', $name = '', $widget_options = array(), $control_options = array() ) {
        parent::__construct( $id_base, $name, $widget_options, $control_options );
    }

    function query( $instance = array() ){
        $instance = wp_parse_args( $instance, array() );
        $viewing = isset( $instance['viewing'] ) ?  $instance['viewing'] : '';

        $viewing = explode( ',', $viewing);
        $viewing = array_map( 'absint', $viewing );
        $viewing = array_filter( $viewing );

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            $this->layout = isset($instance['_layout']) ? absint( $instance['_layout'] ) : 1;
        }

        if ( is_string( $instance['category'] ) ) {
            $instance['category'] = explode( ',', $instance['category'] );
            $instance['category'] = array_map( 'absint', $instance['category'] );
        }

        if ( ! $instance['category'] || empty( $instance['category'] ) ) {
            $instance['category'] = array();
        }

        $instance['category'] = array_filter( $instance['category'] );

        if ( ! $viewing || empty( $viewing ) ) {

            if ( isset( $instance['show_all'] ) && $instance['show_all'] == 'on' ) {
                $viewing = $instance['category'] ;
            } else {
                $viewing = current( $instance['category'] );
            }

        }

        $no_of_posts = isset( $instance['no_of_posts'] ) ? absint( $instance['no_of_posts'] ) : false;
        if ( ! $no_of_posts ) {
            if ( isset( $instance['posts_per_page'] ) ) {
                $no_of_posts = absint( $instance['posts_per_page'] );
            }
        }

        $max_posts =  apply_filters( 'sshop_tabs_content_max_posts', 30 );

        if ( $no_of_posts > $max_posts ) {
            $no_of_posts = $max_posts;
        }

        if ( ! $no_of_posts ) {
            $no_of_posts = get_option( 'posts_per_page' );
        }

        $paged = 0;

        if ( isset( $instance['paged'] ) ) {
            $paged = absint( $instance['paged'] );
        }

        $args = array(
            'post_type'         => 'product', // post
            //'category__in'      => $viewing,
            'posts_per_page'    => $no_of_posts,
            'ignore_sticky_posts' => 1,
            'paged' => $paged,
        );

        if ( ! $this->tax || $this->tax == 'category' ) {
            $args['category__in'] = $viewing;
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $this->tax,
                    'field'    => 'term_id',
                    'terms'    => $viewing,
                ),
            );
        }

        $can_orderby = array( 'date', 'title', 'rand', 'comment_count' );

        if ( isset( $instance['orderby'] ) &&  $instance['orderby'] && in_array(  $instance['orderby'], $can_orderby ) ) {
            $args['orderby'] = $instance['orderby'];
        }

        if ( isset( $instance['order'] ) &&  $instance['order'] && in_array(  $instance['order'], array( 'asc', 'desc' ) ) ) {
            $args['order'] = $instance['order'];
        }

        $args = apply_filters( 'sshop_widget_content_args', $args, $instance, $this );



        $query = new WP_Query( $args );

        if (!isset($instance['show_paging'])) {
            $instance['show_paging'] = false;
        }

        // Get current class
        $instance['wid'] = get_class( $this );
        $query->_instance = $instance;


        return $query;
    }


    function setup_instance( $instance ){
        $r = array();
        foreach ( $this->get_configs() as $f ) {
            if ( isset( $f['name'] ) ) {
                if ( isset( $instance[ $f['name'] ] ) ) {
                    $r[ $f['name' ] ] = $instance[ $f['name'] ];
                } else if ( isset( $f['default'] ) && empty( $instance ) ) {
                    $r[ $f['name' ] ] = $f['default'];
                }
            }
        }

        return $r;
    }

    public function widget( $args, $instance )
    {

        if ( ! isset( $instance['__setup_data'] ) || ! $instance['__setup_data'] === false ){
            $instance = $this->setup_instance( $instance );
        }

        $title = $instance['title'];
        unset($instance['title']);

        $category = $instance['category'];
        $show_all = ( isset( $instance['show_all'] ) ) ? $instance['show_all'] : '';

        if ( ! is_array( $category ) ) {
            $category = ( array ) $category;
        }

        $query = $this->query( $instance );
        $instance['_layout'] = $this->layout;
        $instance['wid'] = get_class( $this );

        $classes = array( 'widget-tabs', 'widget-tabs-list-' . $this->layout );

        if ( $this->layout_class ) {
            $classes[] = $this->layout_class;
        }

        echo $args['before_widget'];

        ?>
        <div class="<?php echo esc_attr( join( ' ', $classes ) ); ?>">
            <div class="layout-tabs tabs-layout-wrap" data-ajax="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-instance="<?php echo esc_attr(json_encode($instance)); ?>">
                <?php if ( ! empty( $title ) ) { ?>
                <div class="widget-title filter-inside">
                    <h2 class="heading-label"><?php echo esc_html($title) ?></h2>

                    <?php if ( count( $category ) > 1 ){ ?>
                    <ul class="nav-tabs-filter">
                        <?php if ( $show_all == 'on') { ?>
                            <li class="show-all"><a data-term-id="<?php echo esc_attr(join($category, ',')); ?>" href="#"><?php esc_html_e('All', 'sshop'); ?></a></li>
                        <?php } ?>
                        <?php foreach ($category as $t) {
                            $term = get_term($t, $this->tax );
                            ?>
                            <li><a data-term-id="<?php echo esc_attr($term->term_id); ?>" href="<?php echo get_term_link($term) ?>"><?php echo esc_html($term->name); ?></a></li>
                            <?php
                        } ?>
                        <li class="subfilter-more"><a href="#"><?php esc_html_e('More', 'sshop'); ?><i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="sub-filters"></ul>
                        </li>
                    </ul>
                    <?php } ?>

                    <div class="tab-item-actions">
                        <span class="slider-prev ti-arrow-left"></span>
                        <span class="slider-next ti-arrow-right"></span>
                    </div>

                </div>
                <?php } ?>
                <div class="tabs-layout-contents">
                    <div class="tabs-intro">
                        <img src="http://kutethemes.net/wordpress/kuteshop/option1/wp-content/uploads/2015/08/f2.jpg" alt="">
                    </div>
                    <?php
                    echo '<div class="tabs-layout-content animate tabs-layout'.$this->layout.'">';
                        echo '<div class="tabs-content-items-wrapper">';
                                if ( $query->have_posts() ) {
                                    if (method_exists($this, 'layout_' . $this->layout)) {
                                        $this->{'layout_' . $this->layout}($query);
                                    } else {
                                        $this->layout_content($query);
                                    }
                                } else {
                                    $this->not_found();
                                }

                        echo '</div>';
                    echo '</div>';

                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }


    function layout_content( $query ){

        ?>
        <div class="tabs-content-items">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="tabs-item-inside">
                <?php wc_get_template_part( 'content', 'product' ); ?>
            </div>
        <?php endwhile; ?>
        </div>
        <?php
        $this->end_layout($query);

    }
    function not_found(){
        ?>
        <p class="posts-not-found"><?php _e( 'Sorry, no posts found in selected category.', 'sshop' ); ?></p>
        <?php
    }

    function end_layout( $query ){

        if ( $query->_instance['show_paging'] ) {
            $paged = $query->query_vars['paged'];
            if (!$paged) {
                $paged = 1;
            }
            $next_page = intval($paged) + 1;

            if ($next_page > $query->max_num_pages) {
                $next_page = 0;
            }
            $prev_page = $paged - 1;

            if ($prev_page || $next_page) {
                ?>
                <div class="tab-paging-wrap">
                    <a href="#" data-paged="<?php echo esc_attr($prev_page); ?>" class="tab-paging back-page <?php echo ($prev_page > 1) ? 'active' : 'disable'; ?>"><i
                            class="fa fa-angle-left"></i></a>
                    <a href="#" data-paged="<?php echo esc_attr($next_page); ?>" class="tab-paging next-page <?php echo ($next_page) ? 'active' : 'disable'; ?>"><i
                            class="fa fa-angle-right"></i></a>
                </div>
                <?php
            }
        }

        wp_reset_postdata();
    }


    function field( $field = array() ){

        if ( is_array( $field['value'] ) ) {
            $field['value'] = array_filter( $field['value'] );
        }

        switch ( $field['type'] ) {
            case 'select_category':
                ?>
                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( $field['name'] ); ?>"><strong><?php echo $field['label']; ?></strong></label>
                    <?php
                    wp_dropdown_categories(
                        array(
                            'show_option_all'   =>  esc_html__( '-- Select a category --', 'sshop' ),
                            'show_option_none'  => '',
                            'orderby'           => 'id',
                            'order'             => 'ASC',
                            'show_count'        => 0,
                            'hide_empty'        => true,
                            'child_of'          => 0,
                            'selected'          => $field['value'],
                            'hierarchical'      => 1,
                            'name'              => $field['name'],
                            'id'                => '',
                            'taxonomy'          => $this->tax,
                            'option_none_value' => -1,
                            'value_field'       => 'term_id',
                        )
                    );
                    ?>
                </div><!-- .dt-admin-input-wrap -->
                <?php
                break;
            case 'checkbox':
                ?>
                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( $field['name'] ); ?>"><strong><?php echo $field['label']; ?></strong></label>
                    <input type="checkbox" <?php checked( $field[ 'value' ], 'on' ); ?> id="<?php echo $this->get_field_id( $field['name'] ); ?>" name="<?php echo $this->get_field_name( $field['name'] ); ?>" />
                </div><!-- .dt-admin-input-wrap -->
                <?php
                break;
            case 'orderby':
            ?>
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( $field['name'] ); ?>"><strong><?php echo $field['label']; ?></strong></label>
                <select id="<?php echo $this->get_field_id( $field['name'] ); ?>" name="<?php echo $this->get_field_name( $field['name'] ); ?>">
                    <option value=""><?php esc_html_e( 'Default', 'sshop' ); ?></option>
                    <option <?php selected( $field[ 'value' ], 'date' ); ?> value="date"><?php esc_html_e( 'Date', 'sshop' ); ?></option>
                    <option <?php selected( $field[ 'value' ], 'title' ); ?> value="title"><?php esc_html_e( 'Title', 'sshop' ); ?></option>
                    <option <?php selected( $field[ 'value' ], 'rand' ); ?> value="rand"><?php esc_html_e( 'Random order', 'sshop' ); ?></option>
                    <option <?php selected( $field[ 'value' ], 'comment_count' ); ?> value="comment_count"><?php esc_html_e( 'Number of comments', 'sshop' ); ?></option>
                </select>
            </div><!-- .dt-admin-input-wrap -->
            <?php
            break;

            case 'order':
                ?>
                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( $field['name'] ); ?>"><strong><?php echo $field['label']; ?></strong></label>
                    <select id="<?php echo $this->get_field_id( $field['name'] ); ?>" name="<?php echo $this->get_field_name( $field['name'] ); ?>">
                        <option value=""><?php esc_html_e( 'Default', 'sshop' ); ?></option>
                        <option <?php selected( $field[ 'value' ], 'desc' ); ?> value="desc"><?php esc_html_e( 'Desc', 'sshop' ); ?></option>
                        <option <?php selected( $field[ 'value' ], 'asc' ); ?> value="asc"><?php esc_html_e( 'Asc', 'sshop' ); ?></option>
                    </select>
                </div><!-- .dt-admin-input-wrap -->
                <?php
                break;

            case 'list_cat':

                    $field['name'] = $field['name'].'[]';
                    if ( ! is_array( $field['value'] ) ) {
                        $field['value'] = ( array ) $field['value'];
                    }


                    $field['value'] = array_filter( $field['value'] );
                    ?>
                    <div class="dt-repeatable">
                        <label for="<?php echo $this->get_field_id( $field['name']); ?>"><strong><?php echo $field['label']; ?></strong></label>

                        <div class="list-filters list-filters-sortable">
                            <?php foreach ( $field['value'] as $k => $t ){

                                $term = get_term( $t, $this->tax );
                                if ( $term ) {
                                    ?>
                                    <div class="list-item">
                                        <input type="hidden" value="<?php echo esc_attr( $term->term_id ); ?>" name="<?php echo $this->get_field_name( $field['name'] ); ?>">
                                        <span class="list-item-title"><?php echo esc_html( $term->name ); ?></span>
                                        <a href="#" class="remove"></a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="input-add">
                            <?php
                            wp_dropdown_categories(
                                array(
                                    'show_option_all'   =>  esc_html__( '-- Select a category to add --', 'sshop' ),
                                    'show_option_none'  => '',
                                    'orderby'           => 'id',
                                    'order'             => 'ASC',
                                    'show_count'        => 0,
                                    'hide_empty'        => true,
                                    'child_of'          => 0,
                                    'selected'          => 0,
                                    'hierarchical'      => 1,
                                    'name'              => $this->get_field_name( 'cate' ),
                                    'id'                => '',
                                    'taxonomy'          => $this->tax,
                                    'option_none_value' => -1,
                                    'value_field'       => 'term_id',
                                )
                            );
                            ?>
                            <a href="#" class="add"
                               data-name="<?php echo $this->get_field_name( $field['name'] ); ?>"><?php esc_html_e( 'Add', 'sshop' ); ?></a>
                        </div><!-- .dt-admin-input-wrap -->

                    </div>
                    <?php

                break;
            default:
                ?>
                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id($field['name']); ?>"><strong><?php echo $field['label']; ?></strong></label>
                    <input type="text" id="<?php echo $this->get_field_id($field['name']); ?>" name="<?php echo $this->get_field_name($field['name']); ?>"
                           value="<?php echo esc_attr($field['value']); ?>">
                </div><!-- .dt-admin-input-wrap -->
                <?php
                break;
        }
    }

    function get_configs( ){
        $fields = array(
            array(
                'type' =>'text',
                'name' => 'title',
                'label' => esc_html__( 'Title', 'sshop' ),
            ),
            array(
                'type' =>'repeatable',
                'name' => 'category',
                'label' => esc_html__( 'Categories', 'sshop' ),
            ),
            array(
                'type' =>'checkbox',
                'name' => 'show_all',
                'label' => esc_html__( 'Show All Filter', 'sshop' ),
            ),

            array(
                'type' =>'text',
                'name' => 'no_of_posts',
                'label' => esc_html__( 'Show All Filter', 'sshop' ),
            ),
        );

        return $fields;

    }

    function render_fields( $instance = array() ){
        $fields = $this->get_configs();
        foreach ( $fields as $field ) {
            $field = wp_parse_args( $field, array(
                'type'      => 'text',
                'name'      => '',
                'label'     => '',
                'value'     => '',
                'default'   => '',
            ) );

            if ( isset( $instance[ $field['name'] ] ) ) {
                $field['value'] = $instance[ $field['name'] ];
            } else {
                $field['value'] = $field['default'];
            }

            $this->field( $field );

        }
    }


    public function form( $instance ) {

        ?>
        <div class="dt-news-list-1">
            <?php
            $this->render_fields( $instance );
            ?>
        </div><!-- .dt-news-list-1 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        foreach ( $this->get_configs() as $field ) {
            $field = wp_parse_args( $field, array(
                'name'      => '',
            ) );

            if (  $field['name'] ) {
                if (isset($new_instance[$field['name']])) {
                    $instance[$field['name']] = $new_instance[$field['name']];
                } else {
                    $instance[$field['name']] = '';
                }
            }
        }

        return $instance;
    }
}



    function sshop_tabs_content_ajax()
    {
        $w = null;
        if ( isset( $_REQUEST['wid'] ) && $_REQUEST['wid'] ) {
            if ( class_exists( $_REQUEST['wid'] ) ) {
                $w = new $_REQUEST['wid'];
                if ( ! is_subclass_of( $w, 'SShop_Tabs_Content')) {
                    $w = null;
                }
            }
        }

        if ( ! $w ) {
            $w = new SShop_Tabs_Content();
        }

        $query = $w->query($_REQUEST);

        if ($query->have_posts()) {
            if ( method_exists($w, 'layout_' . $w->layout) ) {
                $w->{'layout_' . $w->layout}($query);
            } else {
                $w->layout_content($query);
            }

        } else {
            $w->not_found();
        }

        die();
    }

    add_action('wp_ajax_sshop_tabs_content_ajax', 'sshop_tabs_content_ajax');
    add_action('wp_ajax_nopriv_sshop_tabs_content_ajax', 'sshop_tabs_content_ajax');
