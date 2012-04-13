<?php
/**
 * Header Sidebar Template
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

if ( is_active_sidebar( 'sidebar-2' ) ) : ?>

	<div id="sidebar-header" class="sidebar utility">

		<?php dynamic_sidebar( 'sidebar-2' ); ?>

	</div><!-- #sidebar-header .utility -->

<?php endif; ?>