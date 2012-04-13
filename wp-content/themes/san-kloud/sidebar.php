<?php
/**
 * @package San Kloud
 */
?>
<div class="grid-3">
	<div class="sidebar">
		<div class="sidebar-top"></div>
		<div class="sidebar-middle">
			<div class="sidebar-content" >
				<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
					<?php
					$san_kloud_sidebar_args = array( 'before_widget' => '<div class="default-widget">',
													'after_widget' => '</div>',
													'before_title' => '<h3>',
													'after_title' => '</h3>' )
					?>
					<?php the_widget( 'WP_Widget_Search', array(), $san_kloud_sidebar_args ); ?>
				<?php endif; ?>
				</div>
			</div>
			<div class="sidebar-bottom"></div>
		</div>
	</div>
	<br class="clear" />
</div>