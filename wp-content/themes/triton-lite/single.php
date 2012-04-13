<?php
/**
* @package Triton Lite
*/
get_header(); ?>

<div class="container">
	<div id="posts" class="single-page-post">
		<div class="post-wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post-content">

						<h2 class="postitle">
							<?php the_title(); ?>
						</h2><!-- .postitle -->

						<div class="single-metainfo">
							<?php triton_lite_posted_on(); ?> <?php triton_lite_posted_by(); ?>
						</div><!-- .single-metainfo -->

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'triton-lite' ) . '</span>', 'after' => '</div>' ) ); ?>

						<div class="post-foot">
							<div class="post-meta">
								<div class="post-cat">
									<?php _e( 'Category' , 'triton-lite' ); ?> : <?php the_category( ', ' ); ?>
								</div><!-- .post-cat -->

								<?php if( has_tag() ) { ?>
									<div class="post-tag">
										<?php _e( 'Tags' , 'triton-lite' ); ?> : <?php the_tags( ' ' ); ?>
									</div><!-- .post-tag -->
								<?php } ?>
							</div><!-- .post-meta -->
						</div><!-- .post-foot -->

						<?php triton_lite_content_nav( 'nav-below' ); ?>
						
						<?php edit_post_link( __( 'Edit', 'triton-lite' ), '<div class="edit-link">', '</div>' ); ?>

					</div><!-- .post-content -->
				</div><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; ?>

				<div class="comments-template">
					<?php comments_template( '', true ); ?>
				</div><!-- .comments-template -->

			<?php endif; ?>
		</div><!-- .post-wrap -->
	</div><!-- #posts -->

	<?php get_sidebar(); ?>
</div><!-- .container -->

<?php get_footer(); ?>