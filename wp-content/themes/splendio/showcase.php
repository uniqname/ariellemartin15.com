<?php
/**
 * Template Name: Showcase
 *
 * @package Splendio
 */

get_header(); ?>

<?php
	// Access global variable directly to set content_width
	if ( isset( $GLOBALS['content_width'] ) )
		$GLOBALS['content_width'] = 380;
?>

		<div id="primary">

			<?php get_template_part( 'featured-slider' ); ?>

			<div id="content" role="main">

				<span class="latest-title"><strong><?php _e( 'Latest Post', 'splendio' ); ?></strong></span>

				<?php
					// Display the latest post, ignoring Sticky posts.
					$latest_args = array(
						'posts_per_page' => 1,
						'post__not_in' => get_option( 'sticky_posts' ),
					);
					$showcase_query = new WP_Query( $latest_args );

					while ( $showcase_query->have_posts() ) : $showcase_query->the_post(); ?>

						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						?>

				<?php endwhile; ?>

			</div><!-- #content -->

			<?php get_template_part( 'post-list' ); ?>

		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>