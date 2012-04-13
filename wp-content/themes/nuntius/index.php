<?php
/**
 * This is the default template. It is used when a more specific template can't be found to display posts.
 *
 * @package Nuntius
 * @since Nuntius 1.0
 */

get_header(); ?>

	<div id="content">
		<div class="hfeed">

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						?>

				<?php endwhile; ?>
			<?php endif; ?>
		</div><!-- .hfeed -->

		<?php nuntius_content_nav( 'nav-below' ); ?>

	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>