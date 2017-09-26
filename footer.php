<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sshop
 */

?>

	</div><!-- #content -->

<?php if ( is_active_sidebar( 'sidebar-footer' ) ) { ?>
<div class="footer-widgets">
    <div class="container-fluid">
        <div class="row">
            <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
    </div>
</div>
<?php } ?>


<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container-fluid">
            <div class="site-info">
                <span class="copy"><?php printf( esc_html__( 'Copyright %1$s %2$s. All Rights Reserved. ', 'sshop' ), '&copy; '.date_i18n( 'Y' ), get_bloginfo('name' ) ); ?></span>
                <span class="credit"><?php printf( esc_html__( 'Theme by %1$s', 'sshop' ), '<a href="http://sshopwp.com/">SShopWP</a>' ) ?></span>
            </div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
