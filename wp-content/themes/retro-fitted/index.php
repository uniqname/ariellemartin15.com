<?php
/**
 * Home Template
 *
 * This is the home template.  Technically, it is the "posts page" template.  It is used when a visitor is on the
 * page assigned to show a site's latest blog posts.
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

						<?php the_title( '<h1 class="entry-title"><a href="' . esc_attr( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => 0 ) ) . '" rel="bookmark">', '</a></h1>' ); ?>

						<div class="byline">
							<?php printf( __( 'By %1$s on %2$s', 'retro-fitted' ),
								'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author_meta( 'display_name' ) . '</a></span>',
								'<a href="' . esc_url( get_permalink() ) . '"><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" title="' . esc_attr( sprintf( __( 'Posted at %1$s', 'retro-fitted' ), get_the_time( get_option( 'time_format' ) ) ) ) . '" pubdate>' . sprintf( get_the_time( get_option( 'date_format' ) ) ) . '</time></a>'
							); ?>

							<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
								| <?php comments_popup_link(
									__( 'Leave a Comment', 'retro-fitted' ),
									__( '1 Comment',       'retro-fitted' ),
									__( '% Comments',      'retro-fitted' )
								); ?>
							<?php endif; ?>

							<?php edit_post_link( __( 'Edit', 'retro-fitted' ), '<span class="edit-link"> | ', '</span>' ); ?>


						</div>

						<div class="entry-summary">

							<?php the_content( __( 'Continue reading &rarr;', 'retro-fitted' ) ); ?>

							<?php wp_link_pages( array(
								'after'       => '</p>',
								'before'      => '<p class="entry-navigation">' . __( 'Pages:', 'retro-fitted' ),
								'link_after'  => '</span>',
								'link_before' => '<span>',
							) ); ?>

						</div><!-- .entry-summary -->

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

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-error' ); ?>

			<?php endif; ?>

		</div><!-- .hfeed -->

		<?php get_template_part( 'nav-posts' ); ?>

	</div><!-- #content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>