<?php
/**
 * @package Triton Lite
 */
?>

<div class="lay1">

	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post();

			// We want to exclude posts that are prominently shown as featured
			if ( is_sticky() && '' != get_the_post_thumbnail() ) {

				// Let's check the image.
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'triton-lite-950-cropped' );

				// If it is bigger or equal to 990 in width, let's skip this post
				if ( $image[1] >= 950 )
					continue;
			}
		?>	
	
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
				
				<div class="triton-lite-excerpt">
					<?php the_excerpt(); ?>
				</div><!-- .triton-lite-excerpt -->
			</div><!-- .post-content -->
		
		</div><!-- #post-<?php the_ID(); ?> -->
	
	<?php endwhile; endif; ?>

</div><!-- .lay1 -->

<?php triton_lite_content_nav( 'nav-below' ); ?>