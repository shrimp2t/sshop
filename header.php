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

        <div id="top-bar">
            <div class="container">
                <nav class="navbar navbar-toggleable-md">
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><span class="ti-mobile"></span> 0123 456 789</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><span class="ti-email"></span> Contact us</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Login/Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Support</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="container top-bar-middle">
            <div class="site-branding">
                <?php
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


            <form class="top-search-form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Seach..."" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><span class="fa fa-search"></span></span>
                </div>
            </form>

            <div class="header-shop__icon">
                <a href="#">
                    <span class="shop__number">4</span>
                    <span class="shop__icon ti-heart"></span>
                </a>
            </div>

            <div class="header-shop__icon">
                <a href="#">
                    <span class="shop__number">3</span>
                    <span class="shop__icon ti-shopping-cart"></span>
                </a>
            </div>

        </div>


        <div class="container">
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
        </div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
