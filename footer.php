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

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
            <div class="site-info">
                <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'sshop' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'sshop' ), 'WordPress' ); ?></a>
                <span class="sep"> | </span>
                <?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'sshop' ), 'sshop', '<a href="https://automattic.com/" rel="designer">Underscores.me</a>' ); ?>
            </div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
