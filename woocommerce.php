<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sshop
 */

get_header();

$has_sidebar = is_active_sidebar( 'sidebar-woocommerce' );

?>
	<div id="primary" class="content-area <?php echo  ( $has_sidebar ) ? 'has-sidebar' : 'no-sidebar'; ?>">
		<main id="main" class="site-main" role="main">
			<?php
            woocommerce_content();
			?>
		</main><!-- #main -->
        <?php get_sidebar( 'woocommerce'); ?>
	</div><!-- #primary -->

<?php

get_footer();
