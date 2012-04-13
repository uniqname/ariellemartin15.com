<?php
/**
 * Sidebar Template
 *
 * Displays widgets for the sidebar if any have been added by the user.
 * Otherwise, nothing is displayed.
 *
 * @package Retro-fitted
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<div id="sidebar-primary" class="sidebar">
	<?php do_action( 'before_sidebar' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	</div><!-- #sidebar-primary .aside -->

<?php endif; ?>