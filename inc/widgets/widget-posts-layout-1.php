<?php
/**
 * News list Layout 1.
 */
class SShop_Widget_Products_List1 extends SShop_Tabs_Content {

    public $layout = 1;
    public $tax = 'product_cat';
    public $post_type = 'product';

    public function __construct() {
        parent::__construct(
            'sshop_products_list_1',
            esc_html__( 'Product Tabs', 'sshop' ),
            array(
                'description'   => esc_html__( 'Posts display layout 1 for recently published post', 'sshop' )
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
                'type' =>'list_cat',
                'name' => 'category',
                'label' => esc_html__( 'Categories', 'sshop' ),
            ),

            array(
                'type' =>'text',
                'name' => 'no_of_posts',
                'label' => esc_html__( 'No. of Posts', 'sshop' ),
            ),

            array(
                'type' =>'orderby',
                'name' => 'orderby',
                'label' => esc_html__( 'Orderby', 'sshop' ),
            ),

            array(
                'type' =>'order',
                'name' => 'order',
                'label' => esc_html__( 'Order', 'sshop' ),
            ),

        );


        $fields[] = array(
            'type' =>'checkbox',
            'name' => 'show_all',
            'default' => 'on',
            'label' => esc_html__( 'Show All Filter', 'sshop' ),
        );

        $fields[] =  array(
            'type' =>'checkbox',
            'name' => 'show_paging',
            'label' => esc_html__( 'Show Ajax Paging', 'sshop' ),
            'default' => 'on'
        );


        return $fields;

    }


}