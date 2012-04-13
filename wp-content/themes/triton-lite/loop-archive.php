<?php
/**
 * @package Triton Lite
 */
?>

<?php if ( have_posts() ) : $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

	<?php /* If this is a category archive */ if ( is_category() ) { ?>
	<h2 class="archive-title">
		<?php printf( __( 'Category Archive: <em>%s</em>' , 'triton-lite' ), single_cat_title( '', false) ); ?>
	</h2>
	<?php /* If this is a category archive */ } elseif ( is_tag() ) { ?>
	<h2 class="archive-title">
		<?php printf( __( 'Tag Archive: <em>%s</em>' , 'triton-lite' ), single_tag_title( '', false) ); ?>
	</h2>
	<?php /* If this is a monthly archive */ } elseif ( is_year() ) { ?>
	<h2 class="archive-title">
		<?php printf( __( 'Yearly Archive: <em>%s</em>', 'triton-lite' ), get_the_time( 'Y' ) ); ?>
	</h2>
	<?php /* If this is a monthly archive */ } elseif ( is_month() ) { ?>
	<h2 class="archive-title">
		<?php printf( __( 'Monthly Archive: <em>%s</em>', 'triton-lite' ), get_the_time( 'F, Y' ) ); ?>
	</h2>
	<?php /* If this is a daily archive*/ } elseif ( is_day() ) { ?>
	<h2 class="archive-title">
		<?php printf( __( 'Daily Archive: <em>%s</em>', 'triton-lite' ),get_the_time( 'F j, Y' ) ); ?>
	</h2>
	<?php /* If this is an author archive */ } elseif ( is_author() ) { ?>
	<h2 class="archive-title">
		<?php _e( 'Author Archive', 'triton-lite' ); ?>
	</h2>
	<?php /* If this is a paged archive */ } elseif ( isset( $_GET[ 'paged' ] ) && ! empty( $_GET[ 'paged' ] ) ) { ?>
	<h2 class="archive-title">
		<?php _e( 'Blog Archive', 'triton-lite' ); ?>
	</h2>
	<?php } ?>

<div class="lay1">

	<?php while ( have_posts() ) : the_post(); ?>
	
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
		
			<div class="imgwrap">
				<?php if ( 'post' == get_post_type() && ! is_sticky() ) : ?>
					<div class="date-meta">
						<?php triton_lite_posted_on(); ?>
					</div><!-- .date-meta -->
				<?php endif; ?>
				
				<div class="block-comm">
					<div class="comments">
						<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
							<?php comments_popup_link(
								__( '0 Comments', 'triton-lite' ),
								__( '1 Comment', 'triton-lite' ),
								__( '% Comments', 'triton-lite' )
							); ?>
						<?php endif; ?>
					</div><!-- .comments -->
				</div><!-- .block-comm -->
				
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'triton-lite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php
						if ( '' != get_the_post_thumbnail() ) {
							the_post_thumbnail( 'triton-lite-290' );
						} else {
							$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
							if ( $images ) {
								$image = array_shift( $images );
								echo wp_get_attachment_image( $image->ID, 'triton-lite-290' );
							}
						}
					?>
				</a>
			</div><!-- .imgwrap -->
			
			<div class="post-content">
				<?php if ( '' != get_the_title() ) { ?>
					<h2 class="postitle">
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'triton-lite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
							<?php the_title(); ?>
						</a>
					</h2>
				<?php } else { ?>
					<h2 class="postitle">
						<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Permalink to the Post', 'triton-lite' ); ?>" rel="bookmark">
							<?php _e( 'Permalink', 'triton-lite' ); ?>
						</a>
					</h2>
				<?php } ?>
				
				<?php triton_lite_posted_by(); ?>
				
				<?php the_excerpt(); ?>
			</div><!-- .post-content -->
		
		</div><!-- #post-<?php the_ID(); ?> -->
	
	<?php endwhile; else : ?>
	
		<div class="container">
			<div class="error-page">
				<div class="fourofour">
					<a><?php _e( '404', 'triton-lite' ); ?></a>
				</div><!-- .fourofour -->
		
				<div class="post">
					<h2>
						<?php _e( 'Not Found', 'triton-lite' ); ?>
					</h2>
					<p>
						<?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'triton-lite' ); ?>
					</p>
					<?php get_search_form(); ?>
				</div><!-- .post -->
			</div><!-- .error-page -->
		</div><!-- .container -->
	
	<?php endif; ?>

</div><!-- .lay1 -->

<?php triton_lite_content_nav( 'nav-below' ); ?>