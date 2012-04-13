<?php
/**
 * This is the template for displaying 404 pages (Not Found).
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

get_header(); ?>

	<div id="content">
		<div class="hfeed">

			<div id="post-0" class="post error404 not-found">
				<h2 class="entry-title"><?php _e( 'Well this is somewhat embarrassing, isn&rsquo;t it?', 'nuntius' ); ?></h2><!-- .entry-title -->

				<div class="entry-summary">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'nuntius' ); ?></p>
					<?php get_search_form(); ?>

				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		</div><!-- .hfeed -->
	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>