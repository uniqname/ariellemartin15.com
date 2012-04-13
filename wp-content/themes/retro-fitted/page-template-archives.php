<?php
/**
 * Template Name: Archives
 *
 * A custom page template for displaying blog archives.
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

							<h2><?php _e( 'Archives by category', 'retro-fitted' ); ?></h2>

							<ul class="xoxo category-archives">
								<?php wp_list_categories( array( 'feed' => __( 'RSS', 'retro-fitted' ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
							</ul><!-- .xoxo .category-archives -->

							<h2><?php _e( 'Archives by month', 'retro-fitted' ); ?></h2>

							<ul class="xoxo monthly-archives">
								<?php wp_get_archives( array( 'show_post_count' => true, 'type' => 'monthly' ) ); ?>
							</ul><!-- .xoxo .monthly-archives -->

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