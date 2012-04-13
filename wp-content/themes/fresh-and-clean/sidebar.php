<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Fresh & Clean
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="sidebar" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #sidebar .widget-area -->
<?php endif; // end sidebar widget area ?>