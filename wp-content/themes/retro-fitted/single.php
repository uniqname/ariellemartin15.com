<?php
/**
 * Index Template
 *
 * This is the default template.  It is used when a more specific template can't be found to display
 * posts.  It is unlikely that this template will ever be used, but there may be rare cases.
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

						<div class="byline">
							<?php printf( __( 'By %1$s on %2$s', 'retro-fitted' ),
								'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span>',
								'<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" title="' . esc_attr( sprintf( __( 'Posted at %1$s', 'retro-fitted' ), get_the_time( get_option( 'time_format' ) ) ) ) . '" pubdate>' . sprintf( get_the_time( get_option( 'date_format' ) ) ) . '</time>'
							); ?>
							<?php edit_post_link( __( 'Edit', 'retro-fitted' ), '<span class="edit-link"> | ', '</span>' ); ?>
						</div>

						<div class="entry-content">

							<?php the_content(); ?>

							<?php wp_link_pages( array(
								'after'       => '</p>',
								'before'      => '<p class="entry-navigation">' . __( 'Pages:', 'retro-fitted' ),
								'link_after'  => '</span>',
								'link_before' => '<span>',
							) ); ?>

						</div><!-- .entry-content -->

						<div class="entry-meta">
							<?php
								/* translators: %1$s is a comma-separated list of categories. */
								printf( __( 'Posted in: %1$s', 'retro-fitted' ), get_the_category_list( __( ', ', 'retro-fitted' ) ) );
							?>
							<?php
								/* translators: Both strings end with a space. */
								the_tags( __( '| Tagged: ', 'retro-fitted' ), __( ', ', 'retro-fitted' ) );
							?>
						</div>

					</div><!-- .hentry -->

					<nav id="post-nav" class="paged-navigation">
						<h1 class="assistive-text"><?php _e( 'Post navigation', 'retro-fitted' ); ?></h1>
						<?php previous_post_link( '<div class="nav-older">%link</div>', __( '&larr; Older', 'retro-fitted' ) ); ?>
						<?php next_post_link( '<div class="nav-newer">%link</div>', __( 'Newer &rarr;', 'retro-fitted' ) ); ?>
					</nav>

					<?php comments_template(); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>