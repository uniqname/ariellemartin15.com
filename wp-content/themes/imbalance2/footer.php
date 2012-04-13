<?php
/**
 * @package Imbalance 2
 */
?>
	</div><!-- #main -->

	<div id="footer" class="clear-fix">
		<div id="site-info">
			<a href="http://wordpress.org/" rel="generator">Proudly powered by WordPress</a><span class="sep"> | </span><?php printf( __( 'Theme: %1$s by %2$s.', 'imbalance2' ), 'Imbalance 2', '<a href="http://wpshower.com/" rel="designer">WPShower</a>' ); ?>
		</div><!-- #site-info -->
		<div id="footer-right">
		<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
		</div>
		<div id="footer-left">
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
		</div>
	</div><!-- #footer -->

</div><!-- #wrapper -->
<?php
	$options = imbalance2_get_theme_options();
	$color = $options['color'];
?>
<script type="text/javascript">
/* <![CDATA[ */
( function( $ ) {
	// fluid grid
<?php if ( 'yes' == $options['fluid'] ) : ?>
	function wrapperWidth() {
		var wrapper_width = $( 'body' ).width() - 20;
		wrapper_width = Math.floor( wrapper_width / 250 ) * 250 - 40;
		if (wrapper_width < 1000 ) wrapper_width = 1000;
		$( '#wrapper' ).css( 'width', wrapper_width );
	}
	wrapperWidth();

	$( window ).resize( function() {
		wrapperWidth();
	} );
<?php endif ?>

	// grid
	var $container = $( '#boxes' );
	$container.imagesLoaded( function() {
		$container.masonry( {
			itemSelector: '.box',
			columnWidth: 210,
		<?php if ( 'rtl' == get_option( 'text_direction' ) ) : ?>
			isRTL: true,
		<?php endif; ?>
			gutterWidth: 40
		} );
	} );

	var $featured_container = $( '#featured-posts' );
	$featured_container.imagesLoaded( function() {
		$featured_container.masonry( {
			itemSelector: '.box',
			columnWidth: 210,
		<?php if ( 'rtl' == get_option( 'text_direction' ) ) : ?>
			isRTL: true,
		<?php endif; ?>
			gutterWidth: 40
		} );
	} );
})( jQuery );
/* ]]> */
</script>
<?php wp_footer(); ?>
</body>
</html>