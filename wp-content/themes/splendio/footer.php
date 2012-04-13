<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=container div and all content after
 *
 * @package Splendio
 */
?>
		<div class="container-bottom"></div>
	</div><!-- #container -->

	<footer id="colophon" role="contentinfo">

		<?php /* A sidebar in the footer? Yep. */
			get_sidebar( 'footer' );
		?>
		<div class="site-info">
			<?php do_action( 'splendio_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'splendio' ) ); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'splendio' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'splendio' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'splendio' ), 'Splendio', '<a href="http://designdisease.com" rel="designer">DesignDisease</a>' ); ?>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>