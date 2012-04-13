<?php
/**
 * @package Triton Lite
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) return; ?>

<div id="sidebar">
	<div class="widgets">
		<ul>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</ul>
	</div><!-- .widgets -->
</div><!-- #sidebar -->