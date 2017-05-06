<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sshop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'sshop' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

        <div class="navigation-wrapper">

            <div class="site-branding">
                <?php
                if ( function_exists( 'the_custom_logo' ) ) {
                    the_custom_logo();
                }
                if ( is_front_page() && is_home() ) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                endif;

                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                    <?php
                endif; ?>
            </div><!-- .site-branding -->



            <div class="shop-by-departments">
                <a href="#" class="shop-by-button">Departments <span class="icon fa fa-angle-down"></span></a>
                <ul class="list-departments">
                    <?php wp_list_categories( array(
                        'hide_empty'          => false,
                        'hide_title_if_empty' => false,
                        'hierarchical'        => true,
                        'order'               => 'ASC',
                        'orderby'             => 'name',
                        'show_count'          => 0,
                        'show_option_all'     => '',
                        'show_option_none'    => false,
                        'style'               => 'list',
                        'taxonomy'            => 'product_cat',
                        'title_li'            => null,
                        'use_desc_for_title'  => 1,
                    ) ); ?>
                </ul>
            </div>
            <nav id="site-navigation" class="main-navigation" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'sshop' ); ?></button>
                <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
            </nav><!-- #site-navigation -->
            <nav id="site-navigation-right" class="right-navigation" role="navigation">

                <form class="top-search-form" style="display: none;" >
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Seach..." aria-describedby="basic-addon2">
                        <span class="input-group-addon" id="basic-addon2"><?php esc_html_e( 'Search' ,'sshop' ); ?></span>
                    </div>
                </form>

                <div class="header-shop__icon">
                    <a href="#">
                        <span class="shop__icon fa fa-search"></span>
                    </a>
                </div>

                <?php if ( function_exists( 'yith_wcwl_count_all_products' ) ) { ?>
                <div class="header-shop__icon">
                    <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>">
                        <span class="shop__number wishlist-number"><?php echo yith_wcwl_count_all_products(); ?></span>
                        <span class="shop__icon fa fa-heart-o"></span>
                    </a>
                </div>
                <?php } ?>
                <?php if ( function_exists( 'wc_get_checkout_url' ) ) { ?>
                <div class="header-shop__icon">
                    <div class="widget_shopping_cart_content"></div>
                    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
                        <span class="shop__number cart-number-items">0</span>
                        <span class="shop__icon fa fa-shopping-cart"></span>
                    </a>
                </div>
                <?php } ?>
                <?php if ( function_exists( 'wc_get_page_permalink' ) ) { ?>
                <div class="header-shop__icon">
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
                        <span class="shop__icon fa fa-user-circle-o"></span>
                    </a>
                </div>
                <?php } ?>
            </nav><!-- #site-navigation -->



        </div>


	</header><!-- #masthead -->

	<div id="content" class="site-content">
