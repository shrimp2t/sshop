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

<?php if ( is_dynamic_sidebar( 'sidebar-footer' ) ) { ?>
<div class="footer-widgets">
    <div class="container">
        <div class="row">
            <?php dynamic_sidebar('sidebar-footer'); ?>
        </div>
    </div>
</div>
<?php } ?>


<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
            <div class="site-info">
                <span class="copy"><?php printf( esc_html__( 'Copyright %1$s SShop Theme. All Rights Reserved. ', 'sshop' ), '&copy; '.date_i18n( 'Y' ) ); ?></span>
                <span class="credit"><?php printf( esc_html__( 'WordPress SShop Theme by %1$s', 'sshop' ), '<a href="https://www.shrimp2t.com">shrimp2t</a>' ) ?></span>
            </div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
