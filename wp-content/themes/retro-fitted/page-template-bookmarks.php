<?php
/**
 * Template Name: Bookmarks
 *
 * A custom page template for displaying the site's bookmarks/links.
 *
 * @package Retro-fitted
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

	<div id="content">

		<div class="hfeed">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'retro-fitted' ) ); ?>

							<?php wp_list_bookmarks( array(
								'title_li'         => false,
								'title_before'     => '<h2>',
								'title_after'      => '</h2>',
								'category_before'  => false,
								'category_after'   => false,
								'categorize'       => true,
								'show_description' => true,
								'between'          => '<br />',
								'show_images'      => false,
								'show_rating'      => false,
							) ); ?>

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