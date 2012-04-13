<?php
/**
 * @package Suburbia
 */
?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div class="sidebar widget-area">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- .sidebar .widget-area -->
<?php endif; ?>