<?php
/**
 * sshop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sshop
 */


define('WOOCOMMERCE_USE_CSS', true );

if ( ! function_exists( 'sshop_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sshop_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on sshop, use a find and replace
	 * to change 'sshop' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'sshop', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'sshop_big', 9999, 560, 1 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'sshop' ),
		'menu-2' => esc_html__( 'Right Menu', 'sshop' ),
	) );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sshop_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


    $defaults = array(
        'height'      => 50,
        'width'       => 150,
        'flex-height' => false,
        'flex-width'  => true,
        'header-text' => array( 'site-title' ),
    );
    add_theme_support( 'custom-logo', $defaults );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );


    add_theme_support( 'woocommerce' );
    // Add support for WooCommerce.
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

}
endif;
add_action( 'after_setup_theme', 'sshop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sshop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sshop_content_width', 640 );
}
add_action( 'after_setup_theme', 'sshop_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sshop_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'sshop' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'sshop' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

    register_sidebar( array(
        'name'          => esc_html__( 'FRONT PAGE: Content', 'sshop' ),
        'id'            => 'sidebar-home',
        'description'   => esc_html__( 'Display widgets on front page, recommended widgets: FRONT PAGE: Slider, FRONT PAGE: Product tabs, FRONT PAGE: Product Brands, FRONT PAGE: Product Categories, FRONT PAGE: Services.', 'sshop' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer', 'sshop' ),
        'id'            => 'sidebar-footer',
        'description'   => esc_html__( 'Add widgets for footer. Each widget is a column, you can custom column width by add bootstrap column class name, e.g: col-md-4', 'sshop' ),
        'before_widget' => '<section id="%1$s" class="col widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'sshop_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sshop_scripts() {

    wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css?family=Product+Sans:400,400i,700,700i' );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/css/font-awesome.css');
    wp_enqueue_style( 'sshop-style', get_stylesheet_uri()  );

	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'sshop-navigation', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' , 'slick' ), '20151215', true );
    wp_enqueue_script( 'sshop-woocommerce', get_template_directory_uri() . '/assets/js/wc.js', array( 'jquery' ), '20151215', true );
	wp_enqueue_script( 'sshop-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

    wp_dequeue_style( 'owl_theme_css');
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_style( 'woocommerce-general' );
    wp_enqueue_style( 'woocommerce-layout' );
    wp_enqueue_style( 'woocommerce-smallscreen' );


}
add_action( 'wp_enqueue_scripts', 'sshop_scripts' );

function sshop_dequeue_style_footer(){
    wp_dequeue_style( 'owl_theme_css');
}

add_action( 'wp_footer', 'sshop_dequeue_style_footer' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


require get_template_directory() . '/inc/woocommerce-functions.php';
require get_template_directory() . '/inc/woocommerce-template-functions.php';
require get_template_directory() . '/inc/woocommerce-template-hooks.php';
require get_template_directory() . '/inc/plugins-hooks.php';

/**
 * 3rd Party
 */
require get_template_directory() . '/inc/3rd-party/yith-wishlist.php';


/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets/widgets.php';
require get_template_directory() . '/inc/widgets/widget-base.php';
require get_template_directory() . '/inc/widgets/widget-services.php';
require get_template_directory() . '/inc/widgets/widget-slider.php';
require get_template_directory() . '/inc/widgets/widget-product-tabs.php';
require get_template_directory() . '/inc/widgets/widget-brand-products.php';
require get_template_directory() . '/inc/widgets/widget-product-categories.php';


require get_template_directory() . '/inc/admin.php';

require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/config/plugins.php';



add_action( 'cmb2_admin_init', 'yourprefix_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function yourprefix_register_taxonomy_metabox() {
    $prefix = '_term_';
    /**
     * Metabox to add fields to categories and tags
     */
    $cmb_term = new_cmb2_box( array(
        'id'               => $prefix . 'edit',
        'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
        'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
        'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
        // 'new_term_section' => true, // Will display in the "Add New Category" section
    ) );
    $cmb_term->add_field( array(
        'name'     => esc_html__( 'Extra Info', 'cmb2' ),
        'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
        'id'       => $prefix . 'extra_info',
        'type'     => 'title',
        'on_front' => false,
    ) );
    $cmb_term->add_field( array(
        'name' => esc_html__( 'Term Image', 'cmb2' ),
        'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'avatar',
        'type' => 'file',
    ) );
    $cmb_term->add_field( array(
        'name' => esc_html__( 'Arbitrary Term Field', 'cmb2' ),
        'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'term_text_field',
        'type' => 'text',
    ) );
}

