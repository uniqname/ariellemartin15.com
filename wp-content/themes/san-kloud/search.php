<?php
/**
 * @package San Kloud
 */

get_header(); ?>
<div class="container-12 content">
	<div class="grid-1"></div>
	<div class="grid-8">
		<h2 class="archive-title">
			<?php printf( __( 'Search Results for: %s', 'san-kloud' ), '<span>' . get_search_query() . '</span>' ); ?>
		</h2>
		<p><?php get_search_form(); ?></p>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-content">
						<div class="page-title">
							<h2>
								<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>
						</div>
						<?php the_excerpt(); ?>
						<br class="clear">
						<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
						<div class="comment-count">
							<?php comments_popup_link( "<span class='leave-reply'>" . __( 'Reply', 'san-kloud' ) . "</span>", __( '1 comment', 'san-kloud' ), __( '% comments', 'san-kloud' ) ); ?>
						</div>
						<?php endif; ?>
						<br class="clear">
					</div>
					<div class="page-bottom">
					</div>
				</div>

			<?php endwhile; // end of the loop. ?>
		<?php else : ?>
			<div id="page" class="page">
				<div class="page-content">
					<h4>
						<?php _e( 'No posts were found matching your criteria. Please try a different search.', 'san-kloud' ); ?>
					</h4>
					<p><?php get_search_form(); ?></p>
					<br class="clear">
				</div>
				<div class="page-bottom">
				</div>
			</div>
		<?php endif; ?>
		<div class="navigation">
			<div class="left"><?php next_posts_link( __( '&larr; Older Posts', 'san-kloud' ) ); ?></div>
			<div class="right"><?php previous_posts_link( __( 'Newer Posts &rarr;', 'san-kloud' ) ); ?></div>
		</div>
	</div>

<?php get_sidebar();?>
<?php get_footer();?>