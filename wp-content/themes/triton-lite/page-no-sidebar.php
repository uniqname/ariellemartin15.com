<?php
/**
 * Template Name: Full-width, no sidebar
 * Description: A full-width template with no sidebar
 *
 * @package Triton Lite
 */

get_header(); ?>

<div class="container">
	<div id="posts" class="single-page-post">
		<div class="post-wrap">

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post-content">
						<h2 class="postitle">
							<?php the_title(); ?>
						</h2><!-- .postitle -->

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'triton-lite' ) . '</span>', 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'triton-lite' ), '<div class="edit-link">', '</div>' ); ?>
					</div><!-- .post-content -->
				</div><!-- #post-<?php the_ID(); ?> -->

				<div class="comments-template">
					<?php comments_template( '', true ); ?>
				</div><!-- .comments-template -->

			<?php endwhile; ?>

		</div><!-- .post-wrap -->
	</div><!-- #posts -->
</div><!-- .container -->
<?php get_footer(); ?>