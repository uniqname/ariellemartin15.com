<?php
/**
 * @package San Kloud
 */

get_header();
?>
<div class="container-12 content">
	<div class="grid-9" id="entry-content">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; ?>
		<?php else: ?>

			<p><?php _e( 'No posts were found matching your criteria. Please try a different search.', 'san-kloud' ); ?></p>

		<?php endif; ?>
		<div class="navigation">
			<div class="left"><?php next_posts_link( __( '&larr; Older Posts', 'san-kloud' ) ); ?></div>
			<div class="right"><?php previous_posts_link( __( 'Newer Posts &rarr;', 'san-kloud' ) ); ?></div>
		</div>
	</div>
<?php get_sidebar();?>
<?php get_footer();?>