<?php
/**
 * @package Suburbia
 */
?>
<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div id="single">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'suburbia' ), 'after' => '</div>' ) ); ?>
			<?php if ( get_the_author_meta( 'description' ) && ( is_multi_author() ) ) : ?>
			<div id="author-info" class="clear">
				<h3><?php echo esc_html( sprintf( __( 'About %s', 'suburbia' ), get_the_author() ) ); ?></h3>
				<div id="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'suburbia_author_bio_avatar_size', 55 ) ); ?>
				</div><!-- #author-avatar -->
				<div id="author-description">
					<?php the_author_meta( 'description' ); ?>
					<div id="author-link">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'suburbia' ), get_the_author() ); ?>
						</a>
					</div><!-- #author-link	-->
				</div><!-- #author-description -->
			</div><!-- #entry-author-info -->
			<?php endif; ?>
			<?php
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
			?>
		</div><!-- #single -->
	</div><!-- #post-<?php the_ID(); ?> -->

	<div class="meta">
		<div class="meta-information">
			<h3><?php _e( 'Information', 'suburbia' ); ?></h3>
			<?php
				$category_list = get_the_category_list( __( ', ', 'suburbia' ) );
				$tag_list = get_the_tag_list( '', ', ' );

				if ( ! suburbia_categorized_blog() ) {
					if ( '' != $tag_list ) {
						$meta_text = __( 'This entry was posted on %1$s by <a href="%2$s" title="%3$s" rel="author">%4$s</a> and tagged %6$s.', 'suburbia' );
					} else {
						$meta_text = __( 'This entry was posted on %1$s by <a href="%2$s" title="%3$s" rel="author">%4$s</a>.', 'suburbia' );
					}
				} else {
					if ( '' != $tag_list ) {
						$meta_text = __( 'This entry was posted on %1$s by <a href="%2$s" title="%3$s" rel="author">%4$s</a> in %5$s and tagged %6$s.', 'suburbia' );
					} else {
						$meta_text = __( 'This entry was posted on %1$s by <a href="%2$s" title="%3$s" rel="author">%4$s</a> in %5$s.', 'suburbia' );
					}
				}
				printf(
					$meta_text,
					esc_html( get_the_date() ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'suburbia' ), get_the_author_meta( 'display_name' ) ) ),
					esc_attr( get_the_author_meta( 'display_name' ) ),
					$category_list,
					$tag_list
				);
			?>
		</div><!-- .meta-information -->

		<div class="meta-shortlink">
			<h3><?php _e( 'Shortlink', 'suburbia' ); ?></h3>
			<a href="<?php echo wp_get_shortlink(); ?>" class="stiff"><?php echo wp_get_shortlink(); ?></a>
		</div><!-- .meta-shortlink -->

		<div class="meta-navigation">
			<h3><?php _e( 'Navigation', 'suburbia' ); ?></h3>
			<div class="nav-previous"><?php previous_post_link( '%link', __( 'Previous post', 'suburbia' ) ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', __( 'Next post', 'suburbia' ) ); ?></div>
		</div><!-- .meta-navigation -->

		<?php edit_post_link( __( 'Edit this entry', 'suburbia' ), '<h3 class="edit-link">', '</h3>' ); ?>
	</div><!-- .meta -->

<?php endwhile; ?>

<?php get_template_part( 'sidebar' ); ?>

<div id="bottom-wrapper" class="clear">
	<?php get_template_part( 'sidebar-bottom' ); ?>
</div>

<?php get_footer(); ?>