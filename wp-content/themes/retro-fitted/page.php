<?php
/**
 * Page Template
 *
 * This is the default page template.  It is used when a more specific template can't be found to display
 * singular views of pages.
 *
 * @package Retro-fitted
 * @subpackage Template
 */
?>

<?php get_header(); ?>

	<div id="content">

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						<div class="entry-content">

							<?php the_content(); ?>

							<?php wp_link_pages( array(
								'after'       => '</p>',
								'before'      => '<p class="entry-navigation">' . __( 'Pages:', 'retro-fitted' ),
								'link_after'  => '</span>',
								'link_before' => '<span>',
							) ); ?>

						</div><!-- .entry-content -->

						<?php edit_post_link( __( 'Edit this page', 'retro-fitted' ), '<div class="entry-meta"><span class="edit-link">', '</span></div>' ); ?>

					</div><!-- .hentry -->

					<?php comments_template(); ?>

				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>