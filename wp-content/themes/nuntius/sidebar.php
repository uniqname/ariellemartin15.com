<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */
?>

		<div id="sidebar-primary" class="sidebar aside" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

				<div id="search" class="widget widget_search">
					<?php get_search_form(); ?>
				</div>

				<div id="archives" class="widget">
					<h1 class="widget-title"><?php _e( 'Archives', 'nuntius' ); ?></h1>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</div>

			<?php endif; // end sidebar widget area ?>
		</div><!-- #sidebar-primary .sidebar .aside -->